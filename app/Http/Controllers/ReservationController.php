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
//use App\Http\Requests\Step1CheckData;
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


        //guardo en session para otros step        
        session([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'adults' => $request->adults,
            'kids' => $request->kids,
            'night' => $night,
        ]);

        return  compact('rooms', 'night');
    }

    public function step_3_confirmation(Step3Confirmation $request)
    {
        
        $this->validate_session();
        
        $room = ReservationSystem::check_availability(
            $request->session()->get('start_date'),
            $request->session()->get('end_date'),
            $request->session()->get('adults'),
            $request->session()->get('kids'),
            $request->session()->get('night'),
            $request->room_id //parametro opcional para devolder solo la habitacion seleccionada
        );

        //calculo de precios
        list(
            $total_price,
            $complements_cheked,
            $price_per_reservation

        ) = ReservationSystem::price_calculation(
            $room,
            $request->room_quantity,
            $request->ids_complements_cheked,
        );

        //guardo en session para otros step
        session([
            'room_id' => $request->room_id,
            'room_quantity' => $request->room_quantity,
            'ids_complements_cheked' => $request->ids_complements_cheked,
            'price_per_reservation' => $price_per_reservation,
            'sub_total_price' => $total_price,
            'total_price' => $total_price,
        ]);

        return  compact('complements_cheked', 'price_per_reservation', 'total_price',);
    }
    public function step_4_finalize(Step4Filanize $request)
    {
        
        $this->validate_session();
        
        $room = ReservationSystem::check_availability(
            $request->session()->get('start_date'),
            $request->session()->get('end_date'),
            $request->session()->get('adults'),
            $request->session()->get('kids'),
            $request->session()->get('night'),
            $request->session()->get('room_id'),
        );

        DB::beginTransaction();

        //$client = new Client();
        $client = (new Client())->fill($request->client);
        $client->save();

        $reservation = new Reservation();
        $reservation->start_date = $request->session()->get('start_date');
        $reservation->end_date = $request->session()->get('end_date');
        $reservation->night = $request->session()->get('night');
        $reservation->adults = $request->session()->get('adults');
        $reservation->kids = $request->session()->get('kids');
        $reservation->check_in = $request->client['check_in'];
        $reservation->special_request = $request->client['special_request'];
        $reservation->room_quantity = $request->session()->get('room_quantity');
        $reservation->sub_total_price = $request->session()->get('sub_total_price');
        $reservation->total_price = $request->session()->get('total_price');

        try {

            $room->complements_cheked = $room->complements->whereIn('id', session()->get('ids_complements_cheked'));
            
            if ($room->complements_cheked) {
                $room->complements_cheked->transform(function ($item, $key) use($reservation) {

                    $item->total_price=$item->price_per_total_night * $reservation->room_quantity;
                    
                    return $item->only(['name', 'price', 'type_price', 'total_price', 'price_per_total_night']);
                    
                })->values();
            }
            //dd($room->complements_cheked);
            $reservation->client()->associate($client->id);
            $reservation->room()->associate($room->id);
            $reservation->room_reservation = $room->only(['name', 'beds', 'adults', 'price', 'complements_cheked']);

            if (session()->has('discoun_id')) {
                $discount=Discount::find(session()->get('discoun_id'));
                $discount->amount=session()->get('discount_amount');
                $discount->discount_reservation =$discount->only('code','percent','amount');
                //$reservation->'discount_amount' = $request->session()->get('discount_amount');
                //$reservation->discount()->associate(session()->get('discoun_id'));
            }

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

        Mail::to($client->email)->queue(new ReservationOrder($reservation, 'order'));

        session()->forget([
            'start_date',
            'end_date',
            'adults',
            'kids',
            'night',
            'room_id',
            'room_quantity',
            'ids_complements_cheked',
            'price_per_reservation',
            'sub_total_price',
            'total_price',
            'discount_id',
            'discount_amount',
        ]);

        return response()->json([
            'order' => $reservation->order,
            'create_date' => $reservation->created_at->format('Y-m-d')
        ]);
    }
    public function report_pdf(Request $request){

        dd($request->all());

    }
    public function dicount_code(Request $request)
    {
        $this->validate_session();
        
        session()->forget(['discount_id', 'discount_amount']);

        $sub_total_price = session()->get('sub_total_price');

        session([
            'total_price' => $sub_total_price
        ]);

        Validator::make($request->all(), [
            'code' => 'required|exists:discounts,code',
        ])->validate();

        if (!session()->has('room_id')) {

            $error = "No se puede usar este codigo de descuento";
            return response()->json(['error' => $error], 500);
        }

        $discount = Discount::where('code', $request->code)->where('active', 1)
            ->withCount('reservations')->firstOrFail();

        if ($discount->quantity <= $discount->reservations_count) {
            $error = "Este codigo de descuento ya no esta disponible";
            return response()->json(['error' => $error], 500);
        }

        $discount_amount = round($sub_total_price * ($discount->percent / 100), 2);

        $total_price = $sub_total_price - $discount_amount;

        $discount_percent = $discount->percent;

        session([
            'discount_id' => $discount->id,
            'discount_amount' => $discount_amount,
            'discount_code' => $discount->code,
            'total_price' => $total_price
        ]);

        return compact('total_price', 'discount_amount', 'discount_percent');
    }
    public function validate_session()
    {
        if( !session()->has('start_date') ){

            $error = 'Al parecer hubo un error!';
            return response()->json(['error' => $error ], 404);

        }
        
    }
}
