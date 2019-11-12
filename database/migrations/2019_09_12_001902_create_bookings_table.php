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
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->text('message')->nullable();
            $table->integer('adults')->nullable()->default(0);
            $table->integer('children')->nullable()->default(0);
            $table->unsignedInteger('travel_id');
            $table->unsignedInteger('travel_detail_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('travel_detail_id')->references('id')->on('travel_details')->onDelete('cascade');
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
