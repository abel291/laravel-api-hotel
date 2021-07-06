<?php

namespace App\Http\Livewire\Admin\Experiencies;

use App\Models\Experiencie;
use Livewire\Component;
use Livewire\WithPagination;
class ListExperiencies extends Component
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
        'renderListExperiencies' => 'render',
        'resetListExperiencies' => 'resetList'
    ];
    
    public function render()
    {
        $data = Experiencie::where('name','like','%'.$this->search.'%')
            ->orderBy($this->sortBy,$this->sortDirection)
            ->paginate(10);
        return view('livewire.admin.experiencies.list-experiencies',compact('data'));
    }
}
