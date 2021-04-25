<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_user', function (Blueprint $table) {
            //
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('booking_id')->unsigned();
            $table->timestamps();
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_user', function (Blueprint $table) {
            //
        });
    }
}
