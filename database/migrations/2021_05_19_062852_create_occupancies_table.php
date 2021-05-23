<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccupanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occupancies', function (Blueprint $table) {
            $table->id('occupancy_id');
            $table->string('guest_name1');  
            $table->string('guest_name2');
            $table->string('email');
            $table->string('contact_no');
            $table->string('address');
            $table->string('country');
            $table->date('check_in');
            $table->time('checkin_time');
            $table->date('check_out');
            $table->time('checkout_time');
            $table->string('user');
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
        Schema::dropIfExists('occupancies');
    }
}
