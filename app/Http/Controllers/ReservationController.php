<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Client;
use App\Models\Reservation;
use Faker as Faker;


class ReservationController extends Controller
{   
    
    public function index(Request $request){

        if ($request->start_date && $request->end_date) {
           
        
        }

        return view('front.home.reservation');
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

        return compact('night','rooms');
        

    }
    public function rooms($start_date,$end_date,$night,$adults=0,$kids)
    {        
        
        $rooms = Room::where('active', 1)
            ->where('adults', '>=', $adults)
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

                $item->price_per_total_night = $item->price * 1;
                
                $price_per_quantity_room_selected =[];
                
                for ($i=0; $i < $item->quantity_availables; $i++) { 

                    $price_per_quantity_room_selected[$i+1]=$item->price_per_total_night*($i+1);

                }

                $item->price_per_quantity_room_selected=$price_per_quantity_room_selected;
                
                $item->complements->transform(function ($complement, $key) {
                
                    if($complement->type_price=='night'){
                        
                        $complement->total_price=$complement->price* 1;
                    
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
