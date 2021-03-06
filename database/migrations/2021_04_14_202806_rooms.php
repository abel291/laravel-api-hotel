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
            $table->decimal('price',10,2)->default(0);
            $table->string('price_text',20)->default('$0.00')->nullable();
            $table->boolean('active')->default(0);
            $table->tinyInteger('beds')->default(0);
            $table->tinyInteger('adults')->default(0);
            $table->tinyInteger('kids')->default(0)->nullable();
            $table->string('thumbnail');
            $table->timestamps();
            $table->softDeletes();
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
