<?php

namespace App\Http\Livewire\Admin\Experiencies;

use App\Models\Experiencie;
use App\Models\Image;
use Livewire\Component;
use ImageManager;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class CreateExperiencies extends Component
{
    use WithFileUploads;

    public $item_id = '';
    public $open = false;
    public $edit_var = false;
    public $open_modal_confirmation = false;
    public $thumbnail;
    public $images = [];
    public Experiencie $experiencie;

    protected $rules = [
        'experiencie.name' => 'required|string|max:255',
        'experiencie.slug' => 'required|string|max:255',
        'experiencie.description_min' => 'required|string|max:100',
        'experiencie.description_max' => 'required|string',
        'experiencie.price' => 'required|numeric',
        'experiencie.type_price' => 'required|string',
        'experiencie.active' => 'required|boolean',
        'thumbnail' => 'image|max:2048|mimes:jpeg,jpg,png',
        'images.*' => 'image|max:2048|mimes:jpeg,jpg,png',
    ]; //no cargan los datos en la vista
    public function mount()
    {

        $this->experiencie = new Experiencie();
    }
    public function create()
    {

        $this->open = true;
        $this->edit_var = false;
        $this->experiencie = new Experiencie;
        $this->reset('images', 'thumbnail');
        $this->resetErrorBag();
    }
    public function save()
    {
        $this->rules['thumbnail'] = "required|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();

        $experiencie = $this->experiencie;
        $experiencie->slug = Str::of($experiencie->slug)->slug('-');
        $experiencie->thumbnail = $experiencie->slug . '.' . $this->thumbnail->extension();
        $experiencie->save();

        $this->thumbnail->storeAs('experiencies/thumbnail', $experiencie->thumbnail);

        $array_images = [];
        if ($this->images) {
            foreach ($this->images as $key => $item) {

                $experiencie_name_images = $experiencie->slug . '_' . uniqid() . "." . $item->extension();

                $item->storeAs('experiencies', $experiencie_name_images);

                $array_images[$key] = ['image' => $experiencie_name_images];
            }
            $experiencie->images()->createMany($array_images);
        }

        $this->open = false;
        $this->edit_var = false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Experiencia Agregada",
            'subtitle' => "La experiencia  <b>" . $this->experiencie->name . "</b>  a sido  Agregado correctamente"
        ]);
        $this->reset('thumbnail', 'images');
        $this->emit('resetListExperiencies');
        $this->experiencie = new Experiencie;
    }

    public function edit(Experiencie $experiencie)
    {

        $experiencie->load('images');
        $this->reset('thumbnail', 'images');
        $this->resetErrorBag();
        $this->edit_var = true;
        $this->open = true;
        //dd($experiencie);
        $this->experiencie = $experiencie;
    }
    public function update(Experiencie $experiencie)
    {
        $this->rules['thumbnail'] = "nullable|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();
        $experiencie = $this->experiencie;
        $experiencie->slug = Str::of($experiencie->slug)->slug('_');
        if ($this->thumbnail) {

            Storage::delete('experiencies/thumbnail/' . $experiencie->thumbnail);

            $experiencie->thumbnail = $experiencie->slug . '_' . uniqid() . '.' . $this->thumbnail->extension();

            $this->thumbnail->storeAs('experiencies/thumbnail', $experiencie->thumbnail);
        }

        $experiencie->save();

        $array_images = [];
        if ($this->images) {
            foreach ($this->images as $key => $item) {

                $experiencie_name_images = $experiencie->slug . '_' . uniqid() . $key . '.' . $item->extension();

                $item->storeAs('experiencies', $experiencie_name_images);

                $array_images[$key] = ['image' => $experiencie_name_images];
            }
            $experiencie->images()->createMany($array_images);
        }
        $this->open = false;
        $this->edit_var = false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Experiencia Editada",
            'subtitle' => "La Experiencia  <b>" . $this->experiencie->name . "</b>  a sido  Editada correctamente"
        ]);

        $this->reset('thumbnail', 'images');

        $this->emit('resetListExperiencies');

        $this->experiencie = new Experiencie;

    }

    public function delete(Experiencie $experiencie){

        Storage::delete('experiencies/thumbnail/'.$experiencie->thumbnail); 
        
        if ($experiencie->images->isNotEmpty() ) {  //isNotEmpty  -> no esta vacio 
            
            
             $array_images_delete=[];
            foreach ($experiencie->images as $key => $value) {
                
                $array_images_delete[$key]='experiencies/'.$value->image;

            }           

            Storage::delete($array_images_delete);

            $experiencie->images()->delete();
        }
        $experiencie->rooms()->detach();
        $experiencie->delete();
        
        $this->reset('thumbnail','images');
        $this->emit('resetListExperiencies');
        $this->experiencie=new Experiencie;
        $this->open_modal_confirmation=false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Habitacion Eliminada",
            'subtitle' => ""
        ]);       
        
    }
    public function removeImg(Image $image)
    {

        Storage::delete('experiencies/' . $image->image);

        $image->delete();

        $this->experiencie->images = $this->experiencie->images()->get();

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

    public function render()
    {
        return view('livewire.admin.experiencies.create-experiencies');
    }
}
