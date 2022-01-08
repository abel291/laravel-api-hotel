<?php

namespace App\Http\Controllers;

use App\Helpers\ReservationSystem;
use Illuminate\Http\Request;
use App\Http\Requests\Step1CheckData;
use App\Http\Requests\Step3Confirmation;
use App\Http\Requests\Step4Filanize;
use App\Http\Requests\CodeDiscount;
use App\Http\Resources\ReservationRoomResource;
use App\Models\Client;
use App\Models\Reservation;
use Faker as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationOrder;
use App\Models\Discount;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{

    public function step_1_date(Step1CheckData $request)
    {

        [$rooms, $night] = $this->reservation_step(1, $request);

        return  [
            'rooms' => ReservationRoomResource::collection($rooms),
            'night' => $night
        ];
    }

    public function step_3_confirmation(Step3Confirmation $request)
    {

        [
            $room,
            $sub_total_price,
            $total_price,
            $complements_cheked,
            $price_per_reservation,
            $discount
        ] = $this->reservation_step(3, $request);

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

        $discount_code_exmaple = Discount::get()->random(5)->pluck('code')->values();

        return  compact(
            'sub_total_price',
            'total_price',
            'complements_cheked',
            'price_per_reservation',
            'discount',
            'client',
            'discount_code_exmaple'
        );
    }
    public function step_4_finalize(Step4Filanize $request)
    {

        [
            $room,
            $sub_total_price,
            $total_price,
            $complements_cheked,
            $price_per_reservation,
            $discount
        ] = $this->reservation_step(4, $request);

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

            $client->stripe_id = 123123;//$payment->id;
            $client->save();

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            $error = 'Al parecer hubo un error! El pago a través de su targeta no se pudo realizar.';
            return response()->json(['error' => $error], 500);
        }

        $pdf_path = $this->pdf_storage($reservation); //storage

        //Mail::to($client->email)->queue(new ReservationOrder($reservation, $pdf_path));

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

        return view('pdf.report', compact('reservation'));
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
    public function reservation_step(int $step, $request)
    {   
        [$rooms, $night] = ReservationSystem::check_availability(
            $request->start_date,
            $request->end_date,
            $request->adults,
            $request->kids,
        );
        if ($step == 1) {
            return  [$rooms, $night];
        }

        //asumimos que es el step 3 o 4
        $room = $rooms->firstWhere('id', $request->room_id);

        if (!$room) {
            abort(422, 'Habitacion seleccionada no disponible');
        }
        //calculo de precios
        [
            $sub_total_price,
            $total_price,
            $complements_cheked,
            $price_per_reservation,
            $discount

        ] = ReservationSystem::price_calculation(
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
    public function room_with_price($request)
    {
        [$rooms] = ReservationSystem::check_availability(
            $request->start_date,
            $request->end_date,
            $request->adults,
            $request->kids,
        );

        $room = $rooms->firstWhere('id', $request->room_id);

        if (!$room) {
            abort(422, 'Habitacion seleccionada no disponible');
        }

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
