<?php

namespace App\Http\Livewire\Admin\Pages;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class CreatePages extends Component
{   
    use WithFileUploads;
    public $edit_var = true;
    public $open = false;
    public $img;
    public Page $page;

    protected $rules = [
        'page.title' => 'required|string|max:255', 
        'page.sub_title' => 'required|string|max:255',
        'page.description' => 'required|string|max:1000',
        'page.slug' => 'required|string|max:255',    
        'page.seo_title' => 'required|string|max:255',
        'page.seo_desc' => 'required|string|max:255',
        'page.seo_keys' => 'required|string|max:255',

        'img' => 'image|max:2048|mimes:jpeg,jpg,png',
        
    ];

    public function mount()
    {

        $this->page = new Page;       
        
    }

    public function edit(Page $page){               
        
        $this->reset('img');
        $this->resetErrorBag();
        
        $this->open=true;
        $this->page=$page;
    }
    public function update(){
        
        $this->rules['img']="nullable|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();

        $page = $this->page;
        $page->slug = Str::of($page->slug)->slug('-');
        if ($this->img) {
            Storage::delete('pages/'.$page->img);
            $page->img = $page->slug . '-'.rand(1,100).'-img.' . $this->img->extension();
            $this->img->storeAs('pages', $page->img);  
        }
               
        $page->save();      
               
        $this->dispatchBrowserEvent('notification', [
            'title' => "Pagina Editada",
            'subtitle' => "La pagina  <b>" . $this->page->type . "</b>  a sido  Editada correctamente"
        ]);

        $this->reset('img');
        $this->emit('resetListPost');
        $this->page = new Page;        
    }
    public function updatedImg()
    {
        $this->validate([
            'img' => 'image|max:2048|mimes:jpeg,jpg,png',
        ]);
    }   
    
    public function render()
    {
        return view('livewire.admin.pages.create-pages');
    }
}
