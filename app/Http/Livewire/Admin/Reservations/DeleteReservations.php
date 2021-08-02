<?php

namespace App\Http\Livewire\Admin\Reservations;

use Livewire\Component;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationOrder;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Refund;
class DeleteReservations extends Component
{
    public Reservation $reservation;
    public Client $client;  
    public $open_modal_confirmation=false;
    public $refund = false;
    public $refund_percent = 10;

    protected $rules = [
        'refund' => 'boolean',
        'refund_percent' => 'required_if:refund,1|numeric|min:10|max:100',
    ];

    public function mount()
    {
        $this->reservation = new Reservation;
        $this->client = new Client;
        $this->reset('refund','refund_percent','open_modal_confirmation');        
        //dd($this->reservation->room_reservation);
    }

    public function show(Reservation $reservation)
    {        
        $this->reservation = $reservation;

        $this->client=$reservation->client;

        $this->reset('refund','refund_percent');
        $this->resetErrorBag();
    }
    public function cancel_reservation(Reservation $reservation)
    {   
        
        //'canceled','refunded','successful'        
        if ($reservation->state != 'successful') {
            $this->reset('refund', 'refund_percent', 'open_modal_confirmation');
            $this->dispatchBrowserEvent('notification', [
                'title' => "Reservation Cancelada",
                'subtitle' => "Esta reserva ya ha sido cancelada"
            ]);
            return true;
        }
        
        $reservation->state =$this->refund ?'refunded':'canceled';
        $reservation->canceled_date = Carbon::now();        
        
        DB::beginTransaction();
        if ($this->refund) {            
            try {
                $reservation->refund_reservation = [
                    'amount'=> round( $reservation->total_price*($this->refund_percent/100) ,2),
                    'percent'=>$this->refund_percent
                ];
                
                Stripe::setApiKey(env('STRIPE_SECRET'));   
                Refund::create([
                    'amount' => $reservation->refund_reservation->amount*100,
                    'payment_intent' => $reservation->client->stripe_id,
                ]);          
                
            } catch (\Exception $e) {
               $this->addError('refund', $e->getMessage());
               DB::rollBack();
                return true;
            }
        }

        $reservation->save();
        Mail::to($reservation->client->email)->queue(new ReservationOrder($reservation, 'canceled'));
        
        DB::commit();

        $this->emit('resetListReservations');
        
        $this->dispatchBrowserEvent('notification', [
            'title' => "Reservation Cancelada",
            'subtitle' => "Se enviara una notification al correo a : " . $reservation->client->email . " con todo los detalles"
        ]);
        $this->mount();//reset var
        
    }
    public function render()
    {
        return view('livewire.admin.reservations.delete-reservations');
    }
}
