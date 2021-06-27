<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');                    
            $table->string('sub-title');                    
            $table->text('content');
            $table->string('slug')->index();
            $table->string('img');           
            $table->string('seo_title');
            $table->string('seo_desc');
            $table->string('seo_keys');
            $table->enum('lang', ['es','en','bp'])->default('es');//bp -> Portuguese   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
