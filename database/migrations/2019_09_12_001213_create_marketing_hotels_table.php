<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketingHotelsTable extends Migration
{
    public function up()
    {
        Schema::create('marketing_hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->boolean('stars')->nullable();
            $table->mediumText('info')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('image');
            $table->mediumText('gallery')->nullable();
            $table->mediumText('features')->nullable();
            $table->boolean('display')->default(1);
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
        Schema::dropIfExists('marketing_hotels');
    }
}
