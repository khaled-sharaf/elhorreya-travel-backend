<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('info');
            $table->boolean('go_and_back')->default(1); // 1 = go, 2 = go and back
            $table->timestamp('date_from')->nullable();
            $table->timestamp('date_to')->nullable();
            $table->tinyInteger('time_period')->nullable(); // count days = ( date from - date to )
            $table->string('stay_type')->nullable(); // إقامة فقط، شامل الإفضطار، نصف إقامة، شامل كليا
            $table->boolean('transport')->default(0); // 0 = بدون انتقالات،  1  = انتقالات
            $table->tinyInteger('adults')->default(2);
            $table->tinyInteger('children')->default(0);
            $table->double('single_price')->nullable();
            $table->double('twin_price')->nullable();
            $table->double('triple_price')->nullable();
            $table->unsignedInteger('travel_id');
            $table->timestamps();

            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_details');
    }
}
