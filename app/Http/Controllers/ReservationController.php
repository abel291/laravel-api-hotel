<?php

namespace App\Http\Controllers;


//use App\Helpers\ReservationSystem;

use App\Helpers\Helpers;
use App\Helpers\ReservationSystem;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Step1CheckData;
use App\Http\Requests\Step3Confirmation;
use App\Http\Requests\Step4Filanize;
use App\Http\Requests\CodeDiscount;
//use App\Http\Requests\Step1CheckData;
//use App\Http\Requests\Step1CheckData;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Client;
use App\Models\Complement;
use App\Models\Reservation;
use Faker as Faker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationOrder;
use App\Models\Discount;
use App\Models\Page;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{

    protected $reservation_system;
    public function __construct()
    {
        $this->reservation_system = new ReservationSystem;
    }
    public function index(Request $request)
    {


        $start_date = $request->start_date ? $request->start_date : Carbon::now()->format('Y-m-d');
        $end_date = $request->end_date ? $request->end_date : Carbon::now()->addDay()->format('Y-m-d');
        $adults = $request->adults ? $request->adults : 1;

        $client = new Client;
        $faker = Faker\Factory::create();
        $client->name = $faker->name;
        $client->phone = $faker->phoneNumber;
        $client->email = $faker->safeEmail;
        $client->country = $faker->country;
        $client->city = $faker->city;
        $client->special_request = $faker->text($maxNbChars = 200);

        $page = Page::where('type', 'reservation')->first();
        return view('front.reservation.reservation', compact('client', 'start_date', 'end_date', 'adults', 'page'));
    }


    public function step_1_check_date(Step1CheckData $request)
    {

        $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date);
        $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date);
        $night = $start_date->diffInDays($end_date);

        $rooms = ReservationSystem::check_availability(
            $request->start_date,
            $request->end_date,
            $request->adults,
            $request->kids,
            $night
        );

        $client = new Client;
        $faker = Faker\Factory::create();
        $client->name = $faker->name;
        $client->phone = $faker->phoneNumber;
        $client->email = $faker->safeEmail;
        $client->email_confirmation = $client->email;
        $client->country = $faker->country;
        $client->city = $faker->city;
        $client->check_in = '02:00 PM';
        $client->special_request = $faker->text($maxNbChars = 200);

        $discount_code_exmaple=Discount::get()->random(5)->pluck('code')->values();
        return  compact('rooms', 'night', 'client','discount_code_exmaple');
    }

    public function step_3_confirmation(Step3Confirmation $request)
    {
        
        //$this->validate_session();
        list(            
            $room,
            $sub_total_price,
            $total_price,
            $complements_cheked,
            $price_per_reservation,
            $discount
        ) = $this->room_with_price($request);

        return  compact('sub_total_price','total_price','complements_cheked','price_per_reservation','discount');
        
    }
        public function step_4_finalize(Step4Filanize $request)
    {

        // $this->validate_session();

        // $room = ReservationSystem::check_availability(
        //     $request->session()->get('start_date'),
        //     $request->session()->get('end_date'),
        //     $request->session()->get('adults'),
        //     $request->session()->get('kids'),
        //     $request->session()->get('night'),
        //     $request->session()->get('room_id'),
        // );

        list(            
            $room,
            $sub_total_price,
            $total_price,
            $complements_cheked,
            $price_per_reservation,
            $discount
        ) = $this->room_with_price($request);

        DB::beginTransaction();

        //$client = new Client();
        $client = (new Client())->fill($request->client);
        $client->save();

        $reservation = new Reservation();
        $reservation->start_date = $request->start_date;
        $reservation->end_date = $request->end_date;
        $reservation->night = $request->night;
        $reservation->adults = $request->adults;
        $reservation->kids = $request->kids;
        $reservation->check_in = $request->client['check_in'];
        $reservation->special_request = $request->client['special_request'];
        $reservation->room_quantity = $request->room_quantity;
        $reservation->sub_total_price = $sub_total_price;
        $reservation->total_price = $total_price;

        try {

            $room->complements_cheked = $complements_cheked;
            if ($room->complements_cheked) {
                $room->complements_cheked->transform(function ($item) {
                    return $item->only(['name', 'price', 'type_price', 'total_price', 'price_per_total_night']);
                })->values();
            }

            $reservation->client()->associate($client->id);
            $reservation->room()->associate($room->id);

            $room->price_per_reservation = $price_per_reservation;
            $reservation->room_reservation = $room->only(['name', 'beds', 'adults', 'price', 'price_per_total_night', 'price_per_reservation', 'complements_cheked']);
            
            $reservation->discount_reservation = $discount;
            
            //dd($reservation);
            $reservation->order = rand(1, 9) . $reservation->start_date->format('md') . $client->id;
            $reservation->save();
            $description_stripe = $client->name . " - " . $room->name . " - " . $reservation->night . ' noche(s)';

            $payment = $client->charge($reservation->total_price * 100, $request->methodpayment, [
                'description' => $description_stripe
            ]);

            $client->stripe_id = $payment->id;
            $client->save();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            $error = 'Al parecer hubo un error! El pago a través de su targeta no se pudo realizar.';
            return response()->json(['error' => $error], 500);
        }

        $pdf_path = $this->pdf_storage($reservation); //storage

        Mail::to($client->email)->queue(new ReservationOrder($reservation, $pdf_path));

        return response()->json([
            'order' => $reservation->order,
            'create_date' => $reservation->created_at->format('Y-m-d')
        ]);
    }
    public function report_pdf(Request $request)
    {
        $reservation = Reservation::where('order', $request->order)
            ->with(['client' => function ($query) use ($request) {

                $query->where('email', $request->email)->firstOrFail();
            }])->firstOrFail();

        $pdf_path = $this->pdf_storage($reservation); //storage        

        return response()->file('storage/' . $pdf_path);

        return view('pdf.report', compact('reservation', 'client'));
    }

    public function dicount_code(CodeDiscount $request)
    {



        list(
            $room,
            $total_price,
            $complements_cheked,
            $price_per_reservation
        ) = $this->room_with_price($request);



        // session([
        //     'discount_id' => $discount->id,
        //     'discount_amount' => $discount_amount,
        //     'discount_code' => $discount->code,
        //     'total_price' => $total_price
        // ]);

        return compact('total_price', 'discount_amount', 'discount_percent');
    }
    public function validate_session()
    {
        if (!session()->has('start_date')) {

            $error = 'Al parecer hubo un error!';
            return response()->json(['error' => $error], 404);
        }
    }

    public function pdf_storage($reservation)
    {

        $folder_date = $reservation->start_date->format('y-m');

        $pdf_path = "pdf/$folder_date/$reservation->order.pdf";

        if (Storage::missing($pdf_path)) { //missing -> no esta el pdf

            $client = $reservation->client;
            $pdf = PDF::loadView('pdf.report', compact('reservation', 'client'));
            Storage::put($pdf_path, $pdf->output());
        }

        return $pdf_path;
    }

    public function room_with_price($request)
    {
        $room = ReservationSystem::check_availability(
            $request->start_date,
            $request->end_date,
            $request->adults,
            $request->kids,
            $request->night,
            $request->room_id //parametro opcional para devolder solo la habitacion seleccionada
        );

        //calculo de precios
        list(
            $sub_total_price,
            $total_price,
            $complements_cheked,
            $price_per_reservation,
            $discount

        ) = ReservationSystem::price_calculation(
            $room,
            $request->room_quantity,
            $request->ids_complements_cheked,
            $request->code,
        );

        if ($complements_cheked) {
            $complements_cheked = $complements_cheked->values(); //->values() = error js {} -> []
        }


        return [
            $room,
            $sub_total_price,
            $total_price,
            $complements_cheked,
            $price_per_reservation,
            $discount
        ];
    }
}
