<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationCanceled extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Models\Reservation
     */
    public $reservation;  

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function __construct(Reservation $reservation)
    {   
        $this->reservation = $reservation;           
                
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $this->subject('Reservacion cancelada Orden #'.$this->reservation->order);
        return $this->view('emails.reservation_canceled');
    }
}
