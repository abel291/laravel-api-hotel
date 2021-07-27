<?php

namespace App\Http\Livewire\Admin\Discount;

use App\Models\Discount;
use Livewire\Component;

class CreateDiscount extends Component
{
    public $discount_id = '';
    public $open = false;
    public $edit_var = false;
    public $open_modal_confirmation = false;    
    public Discount $discount;
    
    protected $rules = [
        'discount.code' => 'required|string|max:8|unique:discounts,code',
        'discount.percent' => 'required|numeric|min:1|max:100',
        'discount.active' => 'required|boolean',
        'discount.quantity' => 'required|min:1|numeric',
    ];

    public function create()
    {
        $this->open = true;
        $this->edit_var = false;
        $this->discount = new Discount();        
        $this->resetErrorBag();
    }

    public function save()
    {        
        $this->validate();
        
        $this->discount->save();       

        $this->dispatchBrowserEvent('notification', [
            'title' => "Codigo de descuento Agregado",
            'subtitle' => "El Codigo  <b>#" . $this->discount->name . "</b>  a sido  Agregado correctamente"
        ]);
        $this->open = false;
        $this->edit_var = false;
        $this->emit('resetListDiscount');        
    }
    public function edit(Discount $discount)
    {
        
        $this->edit_var = true;
        $this->open = true;
        $this->discount = $discount;
    }

    public function update(Discount $discount)
    {
        $discount=$this->discount;       
        
        $discount->save();       

        $this->dispatchBrowserEvent('notification', [
            'title' => "Codigo de descuento Editado",
            'subtitle' => "El Codigo  <b>#" . $this->discount->name . "</b>  a sido  Agregado correctamente"
        ]);
        $this->open = false;
        $this->edit_var = false;
        $this->emit('resetListDiscount');   
    }
    public function delete(Discount $discount){        

        if ($discount->reservations->isNotEmpty()) {   //isNotEmpty  -> no esta vacio 
            
            $discount->delete();
            
        }else{
            $discount->forceDelete();        
        }        
        
        $this->emit('resetListDiscount');   
        $this->open_modal_confirmation=false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Codigo Eliminado",
            'subtitle' => ""
        ]);       
        
    }

    public function render()
    {
        return view('livewire.admin.discount.create-discount');
    }
}
