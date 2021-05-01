<?php

namespace App\Http\Livewire\Users;
use App\Models\User;
use Livewire\Component;
use Hash;
class CreateUsers extends Component
{    
    
    public $user_id='';    
    public $edit_var=false; 
    public $open=false; 

    public $password='';
    public $password_confirmation='';    
    public $open_modal_confirmation=false;
    public User $user;

    protected $rules = [
        'user.name' => 'required|string|max:255',
        'user.phone' => 'required|string|max:30',
        'user.email' => 'required|email|string|max:255',        
        'password' => 'required|string|max:200|confirmed',        
    ];
    
    public function create(){
        $this->open=true;
        $this->edit_var=false;
        $this->user = new User;
        $this->reset('password','password_confirmation');
        $this->resetErrorBag();
    }
    public function save(){
          
        $this->validate();
        $this->user->password=Hash::make($this->password);
        $this->user->save();

        $this->open=false;        
        $this->edit_var=false;
        
        $this->emit('resetListusers');
        
        $this->dispatchBrowserEvent('notification',[
            'title' => "Usuario Agregado",
            'subtitle' => "El usuario  <b>".$this->user->name."</b>  fue  Agregado correctamente"
        ]);
    }

    public function edit(User $user){ 
        
        $this->user_id=$user->id;      
        $this->user = $user;     
        $this->open = true;
        $this->edit_var = true;
        $this->reset('password','password_confirmation');
        $this->resetErrorBag();       
    }

    public function update(User $user){        
        
        $this->validate([
            'user.name' => 'required|string|max:255',
            'user.phone' => 'required|string|max:30',
            'user.email' => 'required|email|unique:users,email,'.$user->id.',id',            
            'password' => 'sometimes|string|max:200|confirmed'
        ]);        
        $user=$this->user;
        if ($this->password !='') {            
            $user->password = Hash::make($this->password);
        }
        $user->save();      

        $this->open=false;
        $this->edit_var=false;

        $this->reset('password','password_confirmation');
        $this->emit('renderListUsers');   

        $this->dispatchBrowserEvent('notification',[
            'title' => "Usuario Editado",
            'subtitle' => "El usuario  <b>".$user->name."</b>  fue editado correctamente"
            ]);

        $this->user = new User;        
    }

    public function delete(User $user)
    {
        $name=$user->name;        
        $this->emit('renderListUsers'); 
        $this->open_modal_confirmation=false;      
        $this->dispatchBrowserEvent('notification',[
            'title' => "Usuario Eliminado",
            'subtitle' => "El usuario  <b>".$name."</b>  fue quitado de la lista"
            ]);
        $user->delete();
        $this->user = new User;
    }   


    public function render()
    {
        return view('livewire.users.create-users');
    }

        
    //protected $listeners = ['editUser' => 'edit']; 
}
