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
            $table->string('info_offer')->nullable();
            $table->boolean('go_and_back')->default(0); // 0 = go, 1 = go and back
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->tinyInteger('time_period')->nullable(); // count days = ( date from - date to )
            $table->string('stay_type')->nullable(); // إقامة فقط، شامل الإفضطار، نصف إقامة، شامل كليا
            $table->boolean('transport')->default(0); // 0 = بدون انتقالات،  1  = انتقالات
            $table->integer('adults')->nullable()->default(0);
            $table->integer('children')->nullable()->default(0);
            $table->double('single_price')->nullable();
            $table->double('twin_price')->nullable();
            $table->double('triple_price')->nullable();
            $table->boolean('display')->default(1);
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
