<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Client;
use App\Models\Complement;
use App\Models\Reservation;
use Faker as Faker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationOrder;

class ReservationController extends Controller
{

    public function index(Request $request)
    {

        $start_date = $request->start_date ? $request->start_date : Carbon::now();
        $end_date = $request->end_date ? $request->end_date : Carbon::now()->addDay();

        $client = new Client;
        $faker = Faker\Factory::create();
        $client->name = $faker->name;
        $client->phone = $faker->phoneNumber;
        $client->email = $faker->safeEmail;
        $client->country = $faker->country;
        $client->city = $faker->city;
        $client->special_request = $faker->text($maxNbChars = 200);

        return view('front.reservation.reservation', compact('client', 'start_date', 'end_date'));
    }

    public function step_1_check_date(Request $request)
    {

        Validator::make($request->all(), [
            'start_date' => 'required|date_format:Y-m-d|before:reservation.end_date',
            'end_date' => 'required|date_format:Y-m-d|after:reservation.start_date',
            'adults' => 'required|min:1',
            'kids' => 'required',
        ])->validate();

        $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date);

        $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date);

        $night = $start_date->diffInDays($end_date);

        $rooms = $this->rooms(
            $request->start_date,
            $request->end_date,
            $night,
            $request->adults,
            $request->kids,
        );
        //guardo en session para usar en step_4
        session([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'adults' => $request->adults,
            'kids' => $request->kids,
            'night' => $night,
        ]);
       //dd($rooms->toArray());
        return compact('night', 'rooms');
    }

    public function step_4_confirmation(Request $request)
    {

        $rooms = $this->rooms(
            $request->session()->get('start_date'),
            $request->session()->get('end_date'),
            $request->session()->get('night'),
            $request->session()->get('adults'),
            $request->session()->get('kids'),
        );

        $room = $rooms->firstWhere('id', $request->room_id);

        $total_price = 0;
        $price_per_reservation = 0;
        $price_per_complements = 0;
        $complements_cheked=[];
        $room_quantity_available = array_key_exists($request->room_quantity, $room->price_per_quantity_room_selected);

        //valido si la habitacion selecionada y la cantidad estan disponibles

        if ($room && $room_quantity_available) {

            $price_per_reservation = $room->price_per_quantity_room_selected[$request->room_quantity];

            if ($request->ids_complements_cheked) {

                $complements_cheked = $room->complements->whereIn('id', $request->ids_complements_cheked);

                foreach ($complements_cheked as $key => $complement) {

                    $complement->total_price = $complement->price_per_total_night * $request->room_quantity;
                }

                $price_per_complements = $complements_cheked->sum('total_price');
            }

            $total_price = $price_per_reservation + $price_per_complements;
        } else {
            //error
        }
        session([
            'room_id' => $request->room_id,
            'room_quantity' => $request->room_quantity,
            'ids_complements_cheked' => $request->ids_complements_cheked,
            'price_per_reservation' => $price_per_reservation,
            'total_price' => $total_price,

        ]);

        return  compact('total_price', 'complements_cheked', 'price_per_reservation');
    }
    public function step_5_finalize(Request $request)
    {

        //

        Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:255',
            'client_country' => 'required|string|max:255',
            'client_city' => 'required|string|max:255',
            'client_email' => 'required|email|max:255|confirmed',
            'client_check_in' => 'nullable|string|max:255',
            'client_special_request' => 'nullable|string|max:1000',
        ])->validate();

        $rooms = $this->rooms(
            $request->session()->get('start_date'),
            $request->session()->get('end_date'),
            $request->session()->get('night'),
            $request->session()->get('adults'),
            $request->session()->get('kids'),
        );
        $room = $rooms->firstWhere('id', $request->session()->get('room_id'));

        $complements = $room->complements->whereIn('id', $request->session()->get('ids_complements_cheked'));

        if ($complements) {
            $complements->transform(function ($item, $key) {

                return $item->only(['name', 'price', 'type_price', 'total_price', 'price_per_total_night']);
            });
            $room->complements_cheked = $complements;
        }


        $client = new Client();
        $client->name = $request->client_name;
        $client->email = $request->client_email;
        $client->phone = $request->client_phone;
        $client->country = $request->client_country;
        $client->city = $request->client_city;

        $reservation = new Reservation();
        $reservation->start_date = $request->session()->get('start_date');
        $reservation->end_date = $request->session()->get('end_date');
        $reservation->night = $request->session()->get('night');
        $reservation->adults = $request->session()->get('adults');
        $reservation->kids = $request->session()->get('kids');
        $reservation->check_in = $request->client_check_in;
        $reservation->special_request = $request->client_special_request;
        $reservation->room_quantity = $request->session()->get('room_quantity');
        $reservation->total_price = $request->session()->get('total_price');

        $description_stripe = $client->name . " - " . $room->name . " - " . $reservation->night . ' noche(s)';

        try {

            $payment = $client->charge($reservation->total_price * 100, $request->methodpayment, [
                'description' => $description_stripe
            ]);

        }  catch (\Exception $e) {
            
            $msg = 'Lo sentimos! El pago a través de su targeta no se pudo realizar.';
            return response()->json(['error' => $msg], 500);

        }

        $client->stripe_id = $payment->id;
        $client->save();
        $reservation->client()->associate($client->id);
        $reservation->room()->associate($room->id);
        $reservation->room_reservation = $room->only(['name', 'beds', 'adults', 'price', 'complements_cheked']);

        $reservation->order = rand(1, 9) . $reservation->start_date->format('md') . $client->id;
        $reservation->save();

        DB::commit();

        Mail::to($client->email)->queue(new ReservationOrder($reservation, 'order'));

        return response()->json(['order' => $reservation->order], 200);
    }

    public function rooms($start_date, $end_date, $night, $adults = 1, $kids = 0)
    {

        $rooms = Room::where('active', 1)
            ->select('rooms.id', 'name', 'slug', 'quantity', 'price', 'beds', 'adults', 'thumbnail')
            ->where('adults', '>=', $adults)
            ->where('kids', '>=', $kids)
            ->with(['reservations' => function ($query)  use ($start_date, $end_date) {

                $query->where('state', 'successful');

                $query->where(function ($q) use ($start_date, $end_date) {

                    $q->whereBetween('start_date', [$start_date, $end_date])
                        ->orWhereBetween('end_date', [$start_date, $end_date]);
                });
                $query->orWhere(function ($q) use ($start_date, $end_date) {

                    $q->where('start_date', '<=', $start_date)
                        ->where('end_date', '>=', $end_date);
                });
            }])
            // ->with(['experiences' => function ($query) {
            //     $query->where('active', 1);
            // }])
            ->with(['complements' => function ($query) {
                $query->where('active', 1);
                $query->select('complements.id', 'name', 'type_price', 'icon', 'price', 'description_min');
            }])->get()
            ->filter(function ($value, $key) {

                return $value->quantity > $value->reservations->sum('room_quantity');
            })
            ->transform(function ($item, $key) use ($night) {

                $item->quantity_availables = $item->quantity - $item->reservations->sum('room_quantity');

                $item->price_per_total_night = $item->price * $night;

                $price_per_quantity_room_selected = [];

                for ($i = 0; $i < $item->quantity_availables; $i++) {

                    $price_per_quantity_room_selected[$i + 1] = $item->price_per_total_night * ($i + 1);
                }

                $item->price_per_quantity_room_selected = $price_per_quantity_room_selected;

                $item->complements->transform(function ($complement, $key) use ($night) {

                    if ($complement->type_price == 'night') {

                        $complement->price_per_total_night = $complement->price * $night;
                    
                    } elseif ($complement->type_price == 'reservation') {

                        $complement->price_per_total_night = $complement->price;
                    }
                    return $complement;
                });

                return $item;
            });



        return $rooms;
    }
}
