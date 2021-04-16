<?php

namespace App\Http\Livewire\Rooms;

use Livewire\Component;

class CreateRooms extends Component
{
    public $room_id='';    
    public $open=false;
    public $open_modal_confirmation=false;
    
    protected $listeners = ['editRoom' => 'edit'];
    
    public function render()
    {
        return view('livewire.rooms.create-rooms');
    }

    public function save(){
          
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|string|max:255',
            'password' => 'required|string|max:200|confirmed',
        ]);

        User::create([
            'name' =>$this->name,
            'phone' =>$this->phone,
            'email' =>$this->email,
            'password' =>Hash::make($this->password)
        ]);
        $this->open=false;
        
        //$this->edit=false;
        
        $this->emit('resetListusers');
        
        $this->dispatchBrowserEvent('notification',[
            'title' => "Usuario Agregado",
            'subtitle' => "El usuario  <b>".$this->name."</b>  fue  Agregado correctamente"
        ]);
        
        

    }
}
