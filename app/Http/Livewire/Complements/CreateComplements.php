<?php

namespace App\Http\Livewire\Complements;

use Livewire\Component;

use App\Models\Complement;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use ImageManager;

class CreateComplements extends Component
{
    use WithFileUploads;

    public $complement_id = '';
    public $open = false;
    public $edit_var = false;
    public $open_modal_confirmation = false;
    public $icon;
    public Complement $complement;

    protected $rules = [
        'complement.name' => 'required|string|max:255',
        'icon' => 'image|max:2048|mimes:jpeg,jpg,png',
    ];

    public function mount()
    {

        $this->complement = new Complement;
    }

    public function create()
    {
        $this->open = true;
        $this->edit_var = false;
        $this->complement = new Complement();
        $this->reset('icon');
        $this->resetErrorBag();
    }
    public function save()
    {
        $this->rules['icon'] = "required|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();
        $complement = $this->complement;
        $complement->icon = Str::of($complement->name)->slug('-') . uniqid() . '.jpg';

        $img = ImageManager::make($this->icon)
            ->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 90);
            //->save(storage_path('app/public') . '/complement/' . $complement->icon);
            
        Storage::put('complements/'.$complement->icon, $img->__toString());

        $complement->save();

        $this->open = false;
        $this->edit_var = false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Servicio Agregado",
            'subtitle' => "El servicio  <b>" . $this->complement->name . "</b>  a sido  Agregado correctamente"
        ]);
        $this->reset('icon');
        $this->emit('resetListComplements');
        $this->complement = new Complement();
    }

    public function edit(Complement $complement)
    {

        $this->reset('icon');
        $this->edit_var = true;
        $this->open = true;
        $this->complement = $complement;
    }

    public function update(Complement $complement)
    {
        $this->rules['icon'] = 'nullable|image|max:2048|mimes:jpeg,jpg,png';
        $this->validate();
        $complement = $this->complement;
        if ($this->icon) {
            Storage::delete('complement/' . $complement->icon);
            $complement->icon = Str::of($complement->name)->slug('-') . uniqid() . '.png';
            $img = ImageManager::make($this->icon)
            ->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 90);
            //->save(storage_path('app/public') . '/complement/' . $complement->icon);
            
            Storage::put('complements/'.$complement->icon, $img->__toString());

        }

        $complement->save();
        $this->open = false;
        $this->edit_var = false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "servicio Editada",
            'subtitle' => "La servicio  <b>" . $this->complement->name . "</b>  a sido  Editada correctamente"
        ]);
        $this->reset('icon');
        $this->emit('resetListComplements');
        $this->complement = new Complement;
    }
    
    public function delete(Complement $complement)
    {
        Storage::delete('complements/' . $complement->icon);
        
        $complement->rooms()->detach();
        $complement->delete();

        $this->reset('icon');
        $this->emit('resetListComplements');
        $this->complement = new Complement;
        $this->open_modal_confirmation = false;

        $this->dispatchBrowserEvent('notification', [
            'title' => "Servicio Eliminada",
            'subtitle' => ""
        ]);
    }


    public function updatedIcon()
    {

        $this->validate([
            'icon' => 'image|max:2048|mimes:jpeg,jpg,png'
        ]);
    }

    public function render()
    {
        return view('livewire.complements.create-complements');
    }
}
