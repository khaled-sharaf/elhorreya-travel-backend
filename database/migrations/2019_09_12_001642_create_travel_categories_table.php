<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('type');
            $table->string('image');
            $table->string('discount', 3)->nullable();
            $table->integer('order')->nullable();
            $table->unsignedInteger('travel_program_id');
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
        Schema::dropIfExists('travel_categories');
    }
}
