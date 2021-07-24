<?php

namespace App\Http\Controllers;


//use App\Helpers\ReservationSystem;

use App\Helpers\Helper;
use App\Helpers\ReservationSystem;
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
        
        $page = Page::where('type','reservation')->first();
        return view('front.reservation.reservation', compact('client', 'start_date', 'end_date','adults','page'));
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
        
        $rooms = $this->reservation_system->check_availability(
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
        
        return  compact('rooms','night');
        
    }

    public function step_4_confirmation(Request $request)
    {

        //habitacion seleccionada 
        $room = $this->reservation_system->check_availability(
            $request->session()->get('start_date'),
            $request->session()->get('end_date'),
            $request->session()->get('adults'),
            $request->session()->get('kids'),
            $request->session()->get('night'),
            $request->room_id //parametro opcional para devolder solo la habitacion seleccionada
        );

        //calculo de precios
        list( $total_price, $complements_cheked, $price_per_reservation ) = $this->reservation_system->price_calculation(
            $room,
            $request->room_quantity,
            $request->ids_complements_cheked,
            ''
        ); 
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
        Validator::make($request->all(), [
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:255',
            'client_country' => 'required|string|max:255',
            'client_city' => 'required|string|max:255',
            'client_email' => 'required|email|max:255|confirmed',
            'client_check_in' => 'nullable|string|max:255',
            'client_special_request' => 'nullable|string|max:1000',
        ])->validate();

        $room = $this->reservation_system->check_availability(
            $request->session()->get('start_date'),
            $request->session()->get('end_date'),
            $request->session()->get('adults'),
            $request->session()->get('kids'),
            $request->session()->get('night'),
            $request->session()->get('room_id'),
        );        

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

        list($reservation,$error) = $this->reservation_system->check_payment(
            $reservation,
            $client,
            $room,
            $request->methodpayment,
            $request->session()->get('ids_complements_cheked')
        );

        if($error){
            return response()->json(['error'=>$error],500);
        }else{
            session('');
            return response()->json([
                'order' => $reservation->order,
                'create_date' => $reservation->created_at->format('Y-m-d')
            ]);
        }
        
    }

    
}
?>