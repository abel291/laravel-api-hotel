<?php

namespace App\Http\Livewire\Admin\Blog;

use Livewire\Component;
use App\Models\Blog;
use Livewire\WithPagination;
class ListPosts extends Component
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
        'renderListPost' => 'render',
        'resetListPost' => 'resetList'
    ];
    public function render()
    {   
        $data = Blog::where('title','like','%'.$this->search.'%')
            ->orderBy($this->sortBy,$this->sortDirection)
            ->paginate(10);
        return view('livewire.admin..blog.list-posts',compact('data'));
        
    }
}
