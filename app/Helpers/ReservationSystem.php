<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Mail\ReservationOrder;
use App\Models\Room;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReservationSystem
{
    public function check_availability (string $start_date,string $end_date, int $adults,int $kids,int $night,int $room_id=0)
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
        
        if($room_id){
            return $rooms->firstWhere('id', $room_id);
        }else{
            return $rooms->values();
        }
    } 
    public function price_calculation ( $room,int $room_quantity,array $ids_complements_cheked=[], string $code_discount='') {
        
        $total_price = 0;
        $price_per_reservation = 0;
        $price_per_complements = 0;
        $complements_cheked=[];
        $room_quantity_available = array_key_exists($room_quantity, $room->price_per_quantity_room_selected);

        //valido si la habitacion selecionada y la cantidad estan disponibles
        if ($room && $room_quantity_available) {

            $price_per_reservation = $room->price_per_quantity_room_selected[$room_quantity];

            if ($ids_complements_cheked) {

                $complements_cheked = $room->complements->whereIn('id', $ids_complements_cheked);

                foreach ($complements_cheked as $key => $complement) {

                    $complement->total_price = $complement->price_per_total_night * $room_quantity;
                }

                $price_per_complements = $complements_cheked->sum('total_price');
            }
            $total_price = $price_per_reservation + $price_per_complements;
        } else{
            //error
        }

        return [ $total_price, $complements_cheked, $price_per_reservation];

    } 
    
    public function check_payment($reservation,$client,$room,$methodpayment,$ids_complements_cheked){
        
        try {

            DB::beginTransaction();  
            $room->complements_cheked = $room->complements->whereIn('id', $ids_complements_cheked);
            if ($room->complements_cheked) {
                $room->complements_cheked->transform(function ($item, $key) {
                    
                    return $item->only(['name', 'price', 'type_price', 'total_price', 'price_per_total_night']);

                });           
            }
            $client->save();
            $reservation->client()->associate($client->id);
            $reservation->room()->associate($room->id);
            $reservation->room_reservation = $room->only(['name', 'beds', 'adults', 'price', 'complements_cheked']);

            $reservation->order = rand(1, 9) . $reservation->start_date->format('md') . $client->id;
            $reservation->save();   
            
            $error='';

            $description_stripe = $client->name . " - " . $room->name . " - " . $reservation->night . ' noche(s)';      
            $payment = $client->charge($reservation->total_price * 100, $methodpayment, [
                'description' => $description_stripe
            ]);
            
            $client->stripe_id = $payment->id;
            $client->save();
            
            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            $error = 'Al parecer hubo un error! El pago a través de su targeta no se pudo realizar.';
            return ['',$error];           

        }
        
        Mail::to($client->email)->queue(new ReservationOrder($reservation, 'order'));

        return [$reservation,$error];

       
    }
}
