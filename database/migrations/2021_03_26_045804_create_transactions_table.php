<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->string('first_name');  
            $table->string('last_name');
            $table->string('email');
            $table->string('contact_no');
            $table->string('address');
            $table->string('country');
            $table->string('payment_method')->nullable();
            $table->integer('total_room_rate')->default(0);
            $table->integer('tax_total')->default(0);
            $table->integer('grand_total')->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
