<?php


namespace App\Http\Livewire\Admin\Reservations;

use App\Helpers\ReservationSystem;
use Livewire\Component;
use App\Models\Room;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder;
use Faker as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationOrder;
use Illuminate\Support\Str;

class CreateReservations extends Component
{
    
    public $start_date ;
    public $end_date ;
    public $adults=1 ;

    protected $rules = [

        'reservation.start_date' => '',
        'reservation.end_date' => '',
        'reservation.days' => 'numeric',
        'reservation.total_price' => 'numeric',
        'reservation.room_quantity' => 'numeric',
        'reservation.special_request' => 'string|max:1000',
        'reservation.check_in' => 'required|string|max:20',

        'client.name' => 'required|string|max:255',
        'client.phone' => 'required|string|max:255',
        'client.country' => 'required|string|max:255',
        'client.city' => 'required|string|max:255',
        'client.email' => 'required|string|max:255',
        'email' => 'required|email|max:255|confirmed',        
        /*'room_quantity',
        'room_quantity_selected',
        'room_total_price_night',       
        'room_selectd.quantity_availables',        
        'room_selectd.total_price_night', */

    ];
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function mount()
    {
        $this->start_date = Carbon::now();
        $this->end_date = Carbon::now()->addDay();

    }
    
    

    


    public function render()
    {
        $client = new Client;
        $faker = Faker\Factory::create();
        $client->name = $faker->name;
        $client->phone = $faker->phoneNumber;
        $client->email = $faker->safeEmail;
        $client->country = $faker->country;
        $client->city = $faker->city;
        $client->special_request = $faker->text($maxNbChars = 200);
        
        return view('livewire.admin.reservations.create-reservations' ,compact('client'));
    }
}
