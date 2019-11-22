<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address_from')->nullable();
            $table->mediumText('info')->nullable();
            $table->string('image');
            $table->mediumText('gallery')->nullable();
            $table->string('type', 20)->default('internal'); // pilgrimage, umrah, internal, external
            $table->string('umrah_date')->nullable();
            $table->boolean('haram_distance')->nullable();
            $table->string('itinerary_1')->nullable();
            $table->string('itinerary_2')->nullable();
            $table->string('itinerary_3')->nullable();
            $table->string('itinerary_4')->nullable();
            $table->string('itinerary_5')->nullable();
            $table->string('discount', 3)->nullable();
            $table->boolean('favorite_company')->default(0);
            $table->boolean('display')->default(1);
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('hotel_2_id')->nullable();
            $table->unsignedInteger('travel_category_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
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
        Schema::dropIfExists('travels');
    }
}
