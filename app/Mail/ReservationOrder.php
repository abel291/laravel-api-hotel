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
    public $pdf_path;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function __construct(Reservation $reservation,$pdf_path)
    {
        $this->reservation = $reservation;            
        $this->pdf_path = $pdf_path;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {          
            
        $this->subject('Reservacion Orden #'.$this->reservation->order);      
        return $this->text('emails.reservation_order')
                ->attach('storage/'.$this->pdf_path);
    }             //->view('emails.reservation_order')
}
