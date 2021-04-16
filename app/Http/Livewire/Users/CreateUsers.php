<?php

namespace App\Http\Livewire\Users;
use App\Models\User;
use Livewire\Component;
use Hash;
class CreateUsers extends Component
{    
   
    public $user_id='';
    public $name='';
    public $phone='';
    public $email='';
    public $password='';
    public $password_confirmation='';
    public $open=false;
    public $open_modal_confirmation=false;
    
    
    protected $listeners = ['editUser' => 'edit'];
    
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

    public function edit(User $user){       
        $this->user_id=$user->id;
        $this->name=$user->name;
        $this->phone=$user->phone;
        $this->email=$user->email;
        $this->open=true;
        //$this->edit=true;
        
        
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
    }

    public function update(User $user){        
        
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
            'password' => 'sometimes|string|max:200|confirmed'
        ]);

        
        $user->name = $this->name;
        $user->phone = $this->phone;
        $user->email = $this->email;
        if ($this->password !='') {
            $user->password = Hash::make($this->password);
        }   
        $user->save();    

        $this->open=false;
        //$this->edit=false;
        $this->reset('name','phone','email','password','password_confirmation');
        $this->emit('renderListUsers');        
        $this->dispatchBrowserEvent('notification',[
            'title' => "Usuario Editado",
            'subtitle' => "El usuario  <b>".$user->name."</b>  fue editado correctamente"
            ]);
        
    }


    public function render()
    {
        return view('livewire.users.create-users');
    }
}
