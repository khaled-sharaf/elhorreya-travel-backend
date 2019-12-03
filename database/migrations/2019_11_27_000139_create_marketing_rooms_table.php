<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketingRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->double('single_price_wd')->nullable();
            $table->double('single_price_we')->nullable();
            $table->double('dbl_price_wd')->nullable();
            $table->double('dbl_price_we')->nullable();
            $table->double('triple_price_wd')->nullable();
            $table->double('triple_price_we')->nullable();
            $table->double('quad_price_wd')->nullable();
            $table->double('quad_price_we')->nullable();
            $table->string('options');
            $table->text('description')->nullable();
            $table->boolean('display')->default(1);
            $table->unsignedInteger('marketing_hotel_id');
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
        Schema::dropIfExists('marketing_rooms');
    }
}
