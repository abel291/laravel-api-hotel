<?php

namespace App\Http\Livewire\Admin\Rooms;

use Livewire\Component;
use App\Models\Room;
use Livewire\WithPagination;
class ListRooms extends Component
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

    protected $listeners = [
        'renderListRooms' => 'render',
        'resetListRooms' => 'resetList'
    ];

    public function resetList(){
        $this->search='';
        $this->sortDirection='desc';
        $this->resetPage();
    
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    
    public function render()
    {
        $data = Room::where('name','like','%'.$this->search.'%')
            ->orderBy($this->sortBy,$this->sortDirection)
            ->paginate(10);
        return view('livewire.admin.rooms.list-rooms',compact('data'));
    }
}
