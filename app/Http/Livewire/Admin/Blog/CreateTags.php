<?php

namespace App\Http\Livewire\Admin\Blog;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use ImageManager;
use App\Models\Blog;
use App\Models\Tag;
use Faker as Faker;
class CreateTags extends Component
{
    use WithFileUploads;
    
    public $open = false;
    public $edit_var = false;
    public $open_modal_confirmation = false;
   
    public Tag $tag;


    protected $rules = [
        'tag.name' => 'required|string|max:255',        
        'tag.slug' => 'required|string|max:255',        
        'tag.active' => 'required|boolean',
        
    ];

    public function mount()
    {   
        $this->tag = new Tag;

        
    }

    public function create()
    {
        $this->open = true;
        $this->edit_var = false;
        $this->mount();        
        $this->resetErrorBag();

        $faker = Faker\Factory::create();        
        $this->tag->name = $faker->sentence();       
        $this->tag->slug = Str::slug($this->tag->name);       
        $this->tag->active = rand(0,1);
        
    }
    public function save()
    {       
        $this->validate();

        $tag = $this->tag;
        $tag->slug = Str::of($tag->slug)->slug('-');       
        $tag->save();       

        $this->dispatchBrowserEvent('notification', [
            'title' => "Tag Agregada",
            'subtitle' => "El tag  <b>" . $this->tag->name . "</b>  a sido  Agregado correctamente"
        ]);
        $this->reset('open','edit_var','open_modal_confirmation');
        $this->mount();
        $this->emit('resetListTag');        
       
    }

    public function edit(Tag $tag){        
        $this->resetErrorBag();
        $this->edit_var=true;
        $this->open=true;
        $this->tag=$tag;
    }
    public function update(){        
        
        $this->validate();

        $tag = $this->tag;
        $tag->slug = Str::of($tag->slug)->slug('-');            
        $tag->save();
               
        $this->dispatchBrowserEvent('notification', [
            'title' => "Tag Editado",
            'subtitle' => "La tag  <b>" . $this->tag->name . "</b>  a sido  Editado correctamente"
        ]);

        $this->reset('open','edit_var','open_modal_confirmation');
        $this->mount();
        $this->emit('resetListTag');        
        
    }
    public function delete(Tag $tag){
        
        $tag->delete();
        $tag->posts()->detach();    
        
        $this->reset('open','edit_var','open_modal_confirmation');
        $this->mount();
        $this->emit('resetListTag');        

        $this->dispatchBrowserEvent('notification', [
            'title' => "Tag Eliminado",
            'subtitle' => ""
        ]);       
        
    }

    public function render()
    {
        return view('livewire.admin.blog.create-tags');
    }
}
