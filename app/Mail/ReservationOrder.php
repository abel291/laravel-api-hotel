<?php

namespace App\Mail;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Models\Reservation
     */
    public $reservation;
    public $type;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function __construct(Reservation $reservation,$type)
    {
        $this->reservation = $reservation;
        $this->type = $type;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        if ($this->type=='order') {
            $view='reservation_order';
            $this->subject('Reservacion Orden #'.$this->reservation->order);
        }
        elseif($this->type=='canceled'){
            $view='reservation_canceled';
            $this->subject('Reserva cancelada Orden #'.$this->reservation->order);
        }

        
        return $this->text('emails.'.$view);
    }             //->view('emails.reservation_order')
}
