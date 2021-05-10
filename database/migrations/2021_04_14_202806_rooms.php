<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description_min');
            $table->text('description_max');           
            $table->tinyInteger('quantity')->default(0);            
            $table->integer('price')->default(0);
            $table->boolean('active')->default(0);
            $table->tinyInteger('beds')->default(0);
            $table->tinyInteger('people')->default(0);
            $table->string('thumbnail')->nullable();
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
        Schema::dropIfExists('rooms');
    }
}
