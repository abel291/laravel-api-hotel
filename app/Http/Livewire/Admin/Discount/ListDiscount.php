<?php

namespace App\Http\Livewire\Admin\Discount;

use Livewire\Component;
use App\Http\Livewire\Admin\WithSorting;
use App\Models\Discount;
use Livewire\WithPagination;

class ListDiscount extends Component
{
    use WithPagination;
    
    use WithSorting;    

    public $search='';    
    protected $listeners = [
        'renderListDiscount' => 'render',
        'resetListDiscount' => 'resetList'
    ];

    public function render()
    {
        $data = Discount::where('code','like','%'.$this->search.'%')
            ->orderBy($this->sortBy,$this->sortDirection)->withCount('reservations')
            ->paginate(10);
        return view('livewire.admin.discount.list-discount',compact('data'));
    }
    
}
