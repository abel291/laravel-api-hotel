<?php

namespace App\Http\Livewire\Admin\Users;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use Hash;
class ListUsers extends Component
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
        'renderListUsers' => 'render',
        'resetListusers' => 'resetList'
    ];
    

    public function mount(){
        
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

    public function render()
    {
       // $this->search='';

        
        $data = User::where('name','like','%'.$this->search.'%')
            ->orderBy($this->sortBy,$this->sortDirection)
            ->paginate(10);
        return view('livewire.admin.users.list-users',compact('data'));
    }

    


    
}
