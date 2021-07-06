<?php

namespace App\Http\Livewire\Admin\Reservations;

use App\Models\Experience;
use App\Models\Reservation;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
class ListReservations extends Component
{
    use WithPagination;
    
    public $search='';    
    public $sortBy = 'id';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortBy === $field
            ? $this->reverseSort()
            : 'asc';

        $this->sortBy = $field;
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }
    public function resetList(){
        $this->search='';
        $this->sortDirection='desc';
        $this->resetPage();
    
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $listeners = [
        'renderListReservations' => 'render',
        'resetListReservations' => 'resetList'
    ];
    
    public function render()
    {
       
        $data = Reservation::where('start_date','like','%'.$this->search.'%')
            ->orderBy($this->sortBy,$this->sortDirection)
            ->with('client','experience','room')
            ->paginate(20);

            //dd($data->getCollection());

        return view('livewire.admin.reservations.list-reservations',compact('data'));
    }
}
