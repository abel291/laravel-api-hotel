<?php

namespace App\Http\Livewire\Admin\Reservations;

use App\Models\Reservation;
use Livewire\Component;

class DetailsReservation extends Component
{
    
    public function render()
    {
        return view('livewire.admin.reservations.details-reservation');
    }
}
