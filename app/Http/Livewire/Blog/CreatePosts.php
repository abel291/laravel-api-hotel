<?php

namespace App\Http\Livewire\Blog;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use ImageManager;
use App\Models\Blog;
use App\Models\Tag;
use Faker as Faker;
class CreatePosts extends Component
{
    use WithFileUploads;

    public $posts_id = '';
    public $open = false;
    public $edit_var = false;
    public $open_modal_confirmation = false;
    public $img;
    public $tags=[];
    public Blog $post;
    public Tag $tag;


    protected $rules = [
        'post.title' => 'required|string|max:255', 
        'post.description_min' => 'required|string|max:255',
        'post.description_max' => 'required|string|max:1000',
        'post.slug' => 'required|string|max:255',        
        'post.active' => 'required|boolean',
        'post.seo_title' => 'required|string|max:255',
        'post.seo_desc' => 'required|string|max:255',
        'post.seo_keys' => 'required|string|max:255',

        'img' => 'image|max:2048|mimes:jpeg,jpg,png',
        'tags.*' => 'numeric',
    ];

    public function mount()
    {

        $this->post = new Blog;
        $this->tag = new Tag;
        
    }

    public function create()
    {
        $this->open = true;
        $this->edit_var = false;
        $this->mount();
        $this->reset('img');
        $this->resetErrorBag();

        $faker = Faker\Factory::create();        
        $this->post->title = $faker->sentence();
        $this->post->description_min = $faker->text(100);
        $this->post->description_max = $faker->text(300);
        $this->post->slug = Str::slug($faker->sentence());       
        $this->post->active = rand(0,1);
        $this->post->seo_title = $faker->sentence();
        $this->post->seo_desc = $faker->text(100);
        $this->post->seo_keys = $faker->sentence();
    }
    public function save()
    {   

        
        $this->rules['img'] = "required|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();

        $post = $this->post;
        $post->slug = Str::of($post->slug)->slug('-');
        $post->img = $post->slug . '-'.rand(1,100).'-img.' . $this->img->extension();
        $post->save();
        
        
        $this->img->storeAs('posts', $post->img);

        if ($this->tags) {
            $post->tags()->sync($this->tags); 
        }        

               

        $this->dispatchBrowserEvent('notification', [
            'title' => "Post Agregada",
            'subtitle' => "El post  <b>" . $this->post->title . "</b>  a sido  Agregado correctamente"
        ]);
        $this->reset('tags','img','edit_var','open');
        $this->emit('resetListPost');
        $this->post = new Blog;
        $this->tag = new Tag;
    }

    public function edit(Blog $post){

        $post->load('tags');        
        foreach ($post->tags as $key => $value) {
            $this->tags[$key] = "$value->id";
        }         
        
        $this->reset('img');
        $this->resetErrorBag();
        $this->edit_var=true;
        $this->open=true;
        $this->post=$post;
    }
    public function update(){
        
        $this->rules['img']="nullable|image|max:2048|mimes:jpeg,jpg,png";
        $this->validate();

        $post = $this->post;
        $post->slug = Str::of($post->slug)->slug('-');
        if ($this->img) {
            Storage::delete('posts/'.$post->img);
            $post->img = $post->slug . '-'.rand(1,100).'-img.' . $this->img->extension();
            $this->img->storeAs('posts', $post->img);  
        }
               
        $post->save();
        
        if ($this->tags) {
            $post->tags()->sync($this->tags); 
        }  
               
        $this->dispatchBrowserEvent('notification', [
            'title' => "Post Editada",
            'subtitle' => "La Post  <b>" . $this->post->title . "</b>  a sido  Editada correctamente"
        ]);

        $this->reset('tags','img','edit_var','open');
        $this->emit('resetListPost');
        $this->post = new Blog;
        $this->tag = new Tag;
    }
    public function delete(Blog $post){

        Storage::delete('posts/'.$post->img); 
        $post->delete();
        $post->tags()->detach();    
        
        $this->reset('open_modal_confirmation','tags','img','edit_var','open');
        $this->emit('resetListPost');
        $this->post = new Blog;
        $this->tag = new Tag; 

        $this->dispatchBrowserEvent('notification', [
            'title' => "Post Eliminado",
            'subtitle' => ""
        ]);       
        
    }

    public function updatedImg()
    {

        $this->validate([
            'img' => 'image|max:2048|mimes:jpeg,jpg,png',
        ]);
    }
    public function render()
    {
        return view('livewire.blog.create-posts');
    }
}
