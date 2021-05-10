<?php

namespace App\Http\Livewire\Rooms;

use App\Models\Room;
use App\Models\Complement;
use App\Models\Image;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CreateRooms extends Component
{

    use WithFileUploads;

    public $room_id = '';
    public $open = false;
    public $edit_var = false;
    public $open_modal_confirmation = false;
    public $images = [];
    public $thumbnail;
    public $complements = [];
    public Room $room;

     

    protected $rules = [
        'room.name' => 'required|string|max:255',
        'room.slug' => 'required|string|max:255',
        'room.description_min' => 'required|string|max:100',
        'room.description_max' => 'required|string',
        'room.price' => 'required|numeric',
        'room.quantity' => 'required|numeric|max:255',
        'room.active' => 'required|boolean',        
        'room.beds' => 'required|numeric',   
        'room.people' => 'required|numeric|max:255',
        'thumbnail' => 'image|max:2048|mimes:jpeg,jpg,png',
        'images.*' => 'image|max:2048|mimes:jpeg,jpg,png',
        'complements.*' => 'numeric',
    ];//no sincronisa people

    public function mount(){

        $this->room=new Room;

    }

    public function create(){
        $this->open=true;
        $this->edit_var=false;
        $this->room = new Room;        
        $this->reset('images','thumbnail','complements');
        $this->resetErrorBag();
    }
    public function save()
    {   
        $this->rules['thumbnail']="required|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();
        
        $room=$this->room;
        $room->slug = Str::of($room->slug)->slug('-');
        $room->thumbnail=$room->slug.'.'.$this->thumbnail->extension();        
        $room->save();
        $room->complements()->sync($this->complements); //complementos  

        $this->thumbnail->storeAs('rooms/thumbnail', $room->thumbnail);

        $array_images=[]; 
        if ($this->images) {
            foreach ($this->images as $key => $item) {

                $room_name_images = $room->slug.'_'.uniqid().".".$item->extension();               
                
                $item->storeAs('rooms',$room_name_images);

                $array_images[$key] = ['image'=>$room_name_images];

            }
            $room->images()->createMany($array_images);         
        }

        $this->open = false;
        $this->edit_var=false;        
               
        $this->dispatchBrowserEvent('notification', [
            'title' => "Habitacion Agregada",
            'subtitle' => "La habitacion  <b>" . $this->room->name . "</b>  a sido  Agregado correctamente"
        ]);
        $this->reset('thumbnail','images');
        $this->emit('resetListRooms');
        $this->room=new Room;
        
    }
    public function edit(Room $room){

        $room->load('images','complements');   
        foreach ($room->complements as $key => $value) {
            $this->complements[$key]="$value->id";
        }     
        
        $this->reset('thumbnail','images');
        $this->resetErrorBag();
        $this->edit_var=true;
        $this->open=true;
        $this->room=$room;
    }
    
    public function update(){
        //dd($this->complements);
        $this->rules['thumbnail']="nullable|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();
        $room=$this->room;
        $room->slug = Str::of($room->slug)->slug('_');
        if ($this->thumbnail) {
            Storage::delete('rooms/thumbnail/'.$room->thumbnail);
            $room->thumbnail=$room->slug.'_'.uniqid().'.'.$this->thumbnail->extension();
            $this->thumbnail->storeAs('rooms/thumbnail', $room->thumbnail);  
        }
               
        $room->save();
        
        $room->complements()->sync($this->complements); //complementos

        $array_images=[]; 
        if ($this->images) {
            foreach ($this->images as $key => $item) {

                $room_name_images = $room->slug.'_'.uniqid().$key.'.'.$item->extension();
                
                $item->storeAs('rooms',$room_name_images);

                $array_images[$key] = ['image'=>$room_name_images];

            }
            $room->images()->createMany($array_images);         
        }

        $this->open = false;
        $this->edit_var=false;        
               
        $this->dispatchBrowserEvent('notification', [
            'title' => "Habitacion Editada",
            'subtitle' => "La habitacion  <b>" . $this->room->name . "</b>  a sido  Editada correctamente"
        ]);
        $this->reset('thumbnail','images');
        $this->emit('resetListRooms');
        $this->room=new Room;
    }
    public function delete(Room $room){

        Storage::delete('rooms/thumbnail/'.$room->thumbnail); 
        
        if ($room->images->isNotEmpty() ) {  //isNotEmpty  -> no esta vacio 
            
            $array_images_delete=[];

            foreach ($room->images as $key => $value) {
                
                $array_images_delete[$key]='rooms/'.$value->image;

            }           

            Storage::delete($array_images_delete);

            $room->images()->delete();
        }
        $room->delete();
        
        $this->reset('thumbnail','images');
        $this->emit('resetListRooms');
        $this->room=new Room;
        $this->open_modal_confirmation=false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Habitacion Eliminada",
            'subtitle' => ""
        ]);       
        
    }
    function removeImg(Image $image){
        
        Storage::delete('rooms/'.$image->image);

        $image->delete();

        $this->room->images = $this->room->images()->get();
        
        $this->dispatchBrowserEvent('notification', [
            'title' => "Imagen eliminada",
            'subtitle' => ""
        ]);

    }


    public function updatedThumbnail()
    {
        $this->validate([
            'thumbnail' => 'image|max:2048|mimes:jpeg,jpg,png'
        ]);
    }
    public function updatedImages()
    {

        $this->validate([
            'images.*' => 'image|max:2048|mimes:jpeg,jpg,png',
        ]);
    }

    protected $listeners = [
        'renderListUsers' => 'render',
        'resetListusers' => 'resetList'
    ];

    public function render()
    {
        return view('livewire.rooms.create-rooms');
    }
}
