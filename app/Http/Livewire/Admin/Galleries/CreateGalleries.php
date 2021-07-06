<?php

namespace App\Http\Livewire\Admin\Galleries;

use App\Models\Gallery;
use App\Models\Image;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use ImageManager;

class CreateGalleries extends Component
{

    use WithFileUploads;
    public $gallery_id = '';
    public $open = false;
    public $edit_var = false;
    public $open_modal_confirmation = false;
    public $images;
    public $images_order = [];
    public Gallery $gallery;
    
    protected $rules = [
        'gallery.name' => 'required|string|max:255',
        'gallery.active' => 'required|boolean',
        'images.*' => 'image|max:2048|mimes:jpeg,jpg,png',
    ];

    public function mount()
    {

        $this->gallery = new Gallery();
    }

    public function create()
    {
        $this->open = true;
        $this->edit_var = false;
        $this->gallery = new Gallery();
        $this->reset('images','images_order');
        $this->resetErrorBag();
    }
    public function save()
    {
        //dd($this->images_order);
        $this->validate();
        $gallery = $this->gallery;
        $gallery->slug = Str::slug($gallery->name);
        $gallery->save();

        $array_images = [];
        if ($this->images) {
            $this->upload_images($gallery);
        }
        $this->open = false;
        $this->edit_var = false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Habitacion Agregada",
            'subtitle' => "La categoria  <b>" . $this->gallery->name . "</b>  a sido  Agregado correctamente"
        ]);
        $this->reset('images','images_order');
        $this->emit('resetListGalleries');
        $this->gallery = new Gallery();
    }
    public function edit(Gallery $gallery)
    {   
        $gallery->load('images');
        //$this->images_order = $gallery->images->pluck('id')->flip()->toArray();
        

        $this->reset('images');
        $this->resetErrorBag();
        $this->edit_var = true;
        $this->open = true;
        $this->gallery = $gallery;
    }
    public function update()
    {
        
        $this->validate();
        $gallery = $this->gallery;
        $gallery->slug = Str::slug($gallery->name);
        $gallery->save();
        if ($this->images) {
            $this->upload_images($gallery);
        }
       
        //orden de la imagenes
        if(isset($this->images_order['image_saved'])){
            
            $image_saved_order=$this->images_order['image_saved'];           
            
            foreach ( $this->gallery->images()->get() as $key => $value ) {
                
                //la llaves del array de images_order['image_saved'] es el id de las img en la bd , y el valor es el orden

                //verifico que el id de la img esta en las llave del array
                if( array_key_exists($value->id,$image_saved_order )){
                    
                    //agrego el orden
                    $value->order=$image_saved_order[$value->id];
                    $value->save();
                
                }
        
            }
        }

        $this->open = false;
        $this->edit_var = false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Galleria Agregada",
            'subtitle' => "La categoria  <b>" . $this->gallery->name . "</b>  a sido  Agregada correctamente"
        ]);
        $this->reset('images','images_order');
        $this->emit('resetListGalleries');
        $this->gallery = new Gallery();
        
    }
    public function delete(Gallery $gallery){

        
        $gallery->load('images');
        if ($gallery->images->isNotEmpty() ) {  //isNotEmpty  -> no esta vacio             
            
            $array_images_delete=[];
            foreach ($gallery->images as $key => $value) {                
                array_push($array_images_delete,'galleries/'.$value->image);
                array_push($array_images_delete,'galleries/thumbnail/'.$value->image);
                                                          
            }           

            Storage::delete($array_images_delete);

            $gallery->images()->delete();
        }        
        $gallery->delete();
        
        $this->reset('images','images_order');
        $this->emit('resetListGalleries');
        $this->gallery=new Gallery();
        $this->open_modal_confirmation=false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Categoria Eliminada",
            'subtitle' => ""
        ]);       
        
    }
    
    public function removeImg(Image $image)
    {

        Storage::delete('galleries/' . $image->image);
        Storage::delete('galleries/thumbnail/' . $image->image);

        $image->delete();

        $this->gallery->images = $this->gallery->images()->get();

        $this->dispatchBrowserEvent('notification', [
            'title' => "Imagen eliminada",
            'subtitle' => ""
        ]);
    }
    public function updatedImages()
    {
        
        $this->validate([
            'images.*' => 'image|max:2048|mimes:jpeg,jpg,png',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.galleries.create-galleries');
    }

    public function upload_images($gallery){
        
        $array_images = [];
               
        foreach ($this->images as $key => $item) {
            
            $gallery_name = $gallery->slug . '_' . uniqid();
            $gallery_name_images = $gallery_name . '.' . $item->extension();
            //$gallery_name_thumbnail = $gallery_name . '.' . $item->extension();

            //SAVE IMAGE
            $item->storeAs('galleries', $gallery_name_images);

            //SAVE IMAGE thumbnail
            $img_thumbnail = ImageManager::make($item)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode( $item->extension() , 90); //jpeg
            Storage::put('galleries/thumbnail/' . $gallery_name_images, $img_thumbnail->__toString());
            
            //if para el orden de la imagenes
            if(isset($this->images_order['image_tmp'][$key])){
                $order=$this->images_order['image_tmp'][$key];
            }else{//si no tiene order ,entonces sera como se subio 
                $order=0;
            } 
            
            
            $array_images[$key] = [
                'image' => $gallery_name_images,
                'order' => $order
            ];
            }
            $gallery->images()->createMany($array_images);
       
                }
}
