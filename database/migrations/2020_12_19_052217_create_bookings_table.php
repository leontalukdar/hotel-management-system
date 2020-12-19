<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('room_number');
            $table->dateTime('arrival');
            $table->dateTime('checkout');
            $table->bigInteger('user_id');
            $table->bigInteger('room_id');
            $table->boolean('is_checkedout')->default(0);
            $table->string('book_type');
            $table->dateTime('book_time');
            $table->integer('duration');
            $table->decimal('total_due');
            $table->decimal('total_payable');
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
        Schema::dropIfExists('bookings');
    }
}
