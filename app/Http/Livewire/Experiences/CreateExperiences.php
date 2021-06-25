<?php

namespace App\Http\Livewire\Experiences;

use App\Models\Experience;
use App\Models\Image;
use Livewire\Component;
use ImageManager;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class CreateExperiences extends Component
{
    use WithFileUploads;

    public $item_id = '';
    public $open = false;
    public $edit_var = false;
    public $open_modal_confirmation = false;
    public $thumbnail;
    public $images = [];
    public Experience $experience;

    protected $rules = [
        'experience.name' => 'required|string|max:255',
        'experience.slug' => 'required|string|max:255',
        'experience.description_min' => 'required|string|max:100',
        'experience.description_max' => 'required|string',
        'experience.price' => 'required|numeric',
        'experience.type_price' => 'required|string',
        'experience.active' => 'required|boolean',
        'thumbnail' => 'image|max:2048|mimes:jpeg,jpg,png',
        'images.*' => 'image|max:2048|mimes:jpeg,jpg,png',
    ]; //no cargan los datos en la vista
    public function mount()
    {

        $this->experience = new Experience();
    }
    public function create()
    {

        $this->open = true;
        $this->edit_var = false;
        $this->experience = new Experience;
        $this->reset('images', 'thumbnail');
        $this->resetErrorBag();
    }
    public function save()
    {
        $this->rules['thumbnail'] = "required|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();

        $experience = $this->experience;
        $experience->slug = Str::of($experience->slug)->slug('-');
        $experience->thumbnail = $experience->slug . '.' . $this->thumbnail->extension();
        $experience->save();

        $this->thumbnail->storeAs('experiences/thumbnail', $experience->thumbnail);

        $array_images = [];
        if ($this->images) {
            foreach ($this->images as $key => $item) {

                $experience_name_images = $experience->slug . '_' . uniqid() . "." . $item->extension();

                $item->storeAs('experiences', $experience_name_images);

                $array_images[$key] = ['image' => $experience_name_images];
            }
            $experience->images()->createMany($array_images);
        }

        $this->open = false;
        $this->edit_var = false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Experiencia Agregada",
            'subtitle' => "La experiencia  <b>" . $this->experience->name . "</b>  a sido  Agregado correctamente"
        ]);
        $this->reset('thumbnail', 'images');
        $this->emit('resetListExperiences');
        $this->experience = new Experience;
    }

    public function edit(Experience $experience)
    {

        $experience->load('images');
        $this->reset('thumbnail', 'images');
        $this->resetErrorBag();
        $this->edit_var = true;
        $this->open = true;
        //dd($experience);
        $this->experience = $experience;
    }
    public function update(Experience $experience)
    {
        $this->rules['thumbnail'] = "nullable|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();
        $experience = $this->experience;
        $experience->slug = Str::of($experience->slug)->slug('_');
        if ($this->thumbnail) {

            Storage::delete('experiences/thumbnail/' . $experience->thumbnail);

            $experience->thumbnail = $experience->slug . '_' . uniqid() . '.' . $this->thumbnail->extension();

            $this->thumbnail->storeAs('experiences/thumbnail', $experience->thumbnail);
        }

        $experience->save();

        $array_images = [];
        if ($this->images) {
            foreach ($this->images as $key => $item) {

                $experience_name_images = $experience->slug . '_' . uniqid() . $key . '.' . $item->extension();

                $item->storeAs('experiences', $experience_name_images);

                $array_images[$key] = ['image' => $experience_name_images];
            }
            $experience->images()->createMany($array_images);
        }
        $this->open = false;
        $this->edit_var = false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Experiencia Editada",
            'subtitle' => "La Experiencia  <b>" . $this->experience->name . "</b>  a sido  Editada correctamente"
        ]);

        $this->reset('thumbnail', 'images');

        $this->emit('resetListExperiences');

        $this->experience = new Experience;

    }

    public function delete(Experience $experience){

        Storage::delete('experiences/thumbnail/'.$experience->thumbnail); 
        
        if ($experience->images->isNotEmpty() ) {  //isNotEmpty  -> no esta vacio 
            
            
             $array_images_delete=[];
            foreach ($experience->images as $key => $value) {
                
                $array_images_delete[$key]='experiences/'.$value->image;

            }           

            Storage::delete($array_images_delete);

            $experience->images()->delete();
        }
        $experience->rooms()->detach();
        $experience->delete();
        
        $this->reset('thumbnail','images');
        $this->emit('resetListExperiences');
        $this->experience=new Experience;
        $this->open_modal_confirmation=false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Habitacion Eliminada",
            'subtitle' => ""
        ]);       
        
    }
    public function removeImg(Image $image)
    {

        Storage::delete('experiences/' . $image->image);

        $image->delete();

        $this->experience->images = $this->experience->images()->get();

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
        return view('livewire.experiences.create-experiences');
    }
}
