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


class ReservationController extends Controller
{   
    
    public function index(Request $request){

        if ($request->start_date && $request->end_date) {           
        
        }
        $dan = new Client();
        $faker = Faker\Factory::create();
        $dan->name = $faker->name;
        $dan->phone = $faker->phoneNumber;
        $dan->email = $faker->safeEmail;
        $dan->country = $faker->country;
        $dan->city = $faker->city;
        $dan->special_request = $faker->text($maxNbChars = 200);

        //dd($dan);
        return view('front.home.reservation', compact('dan') );
    }
    
    public function step_1_check_date(Request $request){
        
        //dd($request->all());
        $start_date=Carbon::createFromFormat('Y-m-d', $request->start_date);

        $end_date=Carbon::createFromFormat('Y-m-d', $request->end_date);

        $night =$start_date->diffInDays($end_date);

        $rooms=$this->rooms(
            $request->start_date,
            $request->end_date,
            $night,
            $request->adults,
            $request->kids,
        ); 
        
        
        //guardo en session para usar en step_4

        return compact('night','rooms');

    }

    public function step_4_confirmation(Request $request){

        //dd($request->all());
        $start_date=Carbon::createFromFormat('Y-m-d', $request->start_date);

        $end_date=Carbon::createFromFormat('Y-m-d', $request->end_date);

        $night =$start_date->diffInDays($end_date);

        $rooms=$this->rooms(
            $request->start_date,
            $request->end_date,
            $night,
            $request->adults,
            $request->kids,
        );

        $room=$rooms->firstWhere('id',$request->room_id);
        
        $complements = $room->complements->whereIn('id',$request->ids_complements_cheked);
        
        $total_price=0;
        $price_per_reservation=0;
        $price_per_complements = 0;
        


        $room_quantity_available=array_key_exists($request->room_quantity , $room->price_per_quantity_room_selected);
        
        //valido si la habitacion selecionada y la cantidad estan disponibles
        if ($room && $room_quantity_available) { 
            
            $price_per_reservation = $room->price_per_quantity_room_selected[$request->room_quantity];      

            if($request->ids_complements_cheked){
            
                $complements = $room->complements->whereIn('id',$request->ids_complements_cheked);
                
                $price_per_complements = $complements->sum('total_price');
            
            }

            $total_price = $price_per_reservation + $price_per_complements;
        
        }else{
            //error
        }
        
        return  compact('total_price','complements','room');
    }
    public function rooms($start_date,$end_date,$night,$adults=1,$kids=0)
    {        
        
        $rooms = Room::where('active', 1)
            ->select('rooms.id','user','slug','quantity','price','beds','adults','thumbnail')
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
                $query->select('complements.id','name','type_price','icon','price','description_min');
            }])->get()           
            ->filter(function ($value, $key) {

                return $value->quantity > $value->reservations->sum('room_quantity');
            })
            ->transform(function ($item, $key) use ($night){

                $item->quantity_availables = $item->quantity - $item->reservations->sum('room_quantity');

                $item->price_per_total_night = $item->price * $night;
                
                $price_per_quantity_room_selected =[];
                
                for ($i=0; $i < $item->quantity_availables; $i++) { 

                    $price_per_quantity_room_selected[$i+1]=$item->price_per_total_night*($i+1);

                }

                $item->price_per_quantity_room_selected=$price_per_quantity_room_selected;
                
                $item->complements->transform(function ($complement, $key) use ($night) {
                
                    if($complement->type_price=='night'){
                        
                        $complement->total_price=$complement->price* $night;
                    
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
    
}
