<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();                     
            $table->date('start_date');
            $table->date('end_date');            
            $table->tinyInteger('night');            
            $table->tinyInteger('adults')->default(0);
            $table->tinyInteger('kids')->default(0)->nullable();    
            $table->float('discount_amount',10,2)->nullable();
            $table->float('sub_total_price',10,2)->nullable();     
            $table->float('total_price',10,2);     
            $table->string('check_in',8)->default('02:30 PM')->nullable();
            $table->text('special_request')->nullable();
            $table->enum('state', ['canceled','refunded','successful'])->default('successful'); 
            $table->date('canceled_date')->nullable();
            $table->string('order')->index();
            $table->tinyInteger('room_quantity');
            $table->foreignId('room_id')->index();  
            $table->foreignId('client_id')->index();
            $table->foreignId('discount_id')->nullable();

            $table->json('room_reservation');
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
        Schema::dropIfExists('reservations');
    }
}
