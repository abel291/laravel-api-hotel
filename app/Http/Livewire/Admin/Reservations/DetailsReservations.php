<?php

namespace App\Http\Livewire\Admin\Reservations;

use App\Models\Client;
use App\Models\Reservation;
use Livewire\Component;

class DetailsReservations extends Component
{
    public Reservation $reservation;
    public Client $client;
   
   
    public function mount()
    {
        $this->reservation = new Reservation;
        $this->client = new Client;
        //dd($this->reservation->room_reservation);
    }

    public function show(Reservation $reservation)
    {
        
        $this->reservation = $reservation;
        $this->client=$reservation->client;
        
    }
    
    public function render()
    {
        
        
        return view('livewire.admin.reservations.details-reservations');
    }
}
