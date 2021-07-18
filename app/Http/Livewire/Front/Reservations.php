<?php

namespace App\Http\Livewire\Front;

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
use App\Models\Complement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Reservations extends Component
{   
    public $step_title='';
    public $step=1;
    public Reservation $reservation;
    public Client $client;    

    //paso-1 elegir fechas

    public $adults = 0;
    public $kids = 0;
    
    //public $rooms_list = [];
    public $room_id;  
    public $room_quantity = 0;
    public $room;
    

    //paso 3 sleecionar complementos adicionales
    public $complements=[];
    public $ids_complements_cheked =[];
    public $complements_cheked =[];

    public $total_price_per_reservation=0;
    public $total_price_per_complements=0;
    public $total_price=0;

    //paso 4 usuario
    public $email;
    public $email_confirmation;

    //cacnelar reservacion
    public $refund = false;

    protected $rules = [

        'reservation.start_date' => '',
        'reservation.end_date' => '',
        'reservation.night' => 'numeric',
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

    public function mount(Request $request){

        $this->reservation= new Reservation; 
        $this->client= new Client();
        
        $faker = Faker\Factory::create();
        $this->client->name = $faker->name;
        $this->client->phone = $faker->phoneNumber;
        $this->email = $faker->safeEmail;
        $this->client->country = $faker->country;
        $this->client->city = $faker->city;
        $this->reservation->special_request = $faker->text($maxNbChars = 200);

        if ($request->start_date && $request->end_date) {

            $this->reservation->start_date = $request->start_date;
            $this->reservation->end_date  = $request->end_date;
            $this->reservation->adults  = $request->adults;                      
            $this->step_2_rooms();
            
        }else{

            $this->step_title='Reservation';
            $this->reservation->start_date = Carbon::now();
            $this->reservation->end_date = Carbon::now()->addDay();

        }
        
    }
    
    public function step_1_check_rooms(){
        $this->validate([
            'reservation.start_date' => 'required|date|before:reservation.end_date',
            'reservation.end_date' => 'required|date|after:reservation.start_date',
            'adults' => 'required|min:1',
        ]);        

        $this->reservation->night = $this->reservation->start_date->diffInDays($this->reservation->end_date);
        
        $this->step = 2;

        $this->rooms_list=$this->rooms();        

        // return json_encode([
        //     'night' => $this->reservation->night,
        //     'rooms' => $this->rooms(),            
        // ]);        

    }
    public function step_2_select_room(){

        
        $this->room = $this->rooms_list->firstWhere('id',$this->room_id);
        //dd($this->rooms_list->firstWhere('id',$this->room_id));
        $this->complements = $this->room->complements;
        //dd($this->complements);
        $this->step=3;
        
    }
    public function step_3_complements(){

        $this->room = $this->rooms()->firstWhere('id',$this->room_id);

        $this->total_price_per_reservation = $this->room->price_per_quantity_room_selected[$this->room_quantity];

        $this->complements_cheked = $this->room->complements->whereIn('id',$this->ids_complements_cheked);

        $this->total_price_per_complements = $this->complements_cheked->sum('total_price');

        $this->total_price = $this->total_price_per_complements+ $this->room->total_price_per_reservation;

    }
    
    public function step_4_confirmation(){
        
        // $rooms=$this->rooms();
        
        // $room=$rooms->firstWhere('id',$room_id); 
        // $complements=[];
        // $total_price_final=0;
        // $total_price_per_complements = 0;
        
        // if (array_key_exists($room_quantity , $room->price_per_quantity_room_selected)) {
            
        //     $room->total_price_per_reservation = $room->price_per_quantity_room_selected[$room_quantity];      

        //     if($ids_complements_cheked){
            
        //         $complements = $room->complements->whereIn('id',$ids_complements_cheked);
                
        //         $price_per_complements = $complements->sum('total_price');
            
        //     }

        //     $total_price_final= $room->total_price_per_reservation + $price_per_complements;
        
        // }

        // // dd([
        // //     $room_id,
        // //     $room_quantity,
        // //     $ids_complements_cheked,
        // //     '------------',
        // //     $room->id,
        // //     $complements->pluck('id')

        // // ]);

        // return json_encode([
        //     'complements' => $complements,
        //     'room' => $room,
        //     'total_price' => $total_price_final,            
        // ]);   
    }
    

    public  function getRoomsListProperty(){
        return $this->rooms();
    }

    public function rooms()
    {   

        $start_date = $this->reservation->start_date;
        $end_date = $this->reservation->end_date;
        $night = $this->reservation->night;
        $rooms = Room::where('active', 1)
            ->where('adults', '>=', $this->adults)
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
            }])->get()

            ->filter(function ($value, $key) {

                return $value->quantity > $value->reservations->sum('room_quantity');
            })
            ->transform(function ($item, $key) {

                $item->quantity_availables = $item->quantity - $item->reservations->sum('room_quantity');

                $item->price_per_total_night = $item->price * $this->reservation->night;
                
                $price_per_quantity_room_selected =[];
                
                for ($i=0; $i < $item->quantity_availables; $i++) { 

                    $price_per_quantity_room_selected[$i+1]=$item->price_per_total_night*($i+1);

                }

                $item->price_per_quantity_room_selected=$price_per_quantity_room_selected;
                
                $item->complements->transform(function ($complement, $key) {
                
                    if($complement->type_price=='night'){
                        
                        $complement->total_price=$complement->price*$this->reservation->night;
                    
                    }                
                    elseif($complement->type_price=='reservation'){
                        
                        $complement->total_price=$complement->price;
                    
                    }
                    return $complement;
                });                

                return $item;
            });

        return $rooms;
    } 
    
    public function render()
    {   

        return view('livewire.front.reservations')->layout('front.layouts.app');
    }
}
