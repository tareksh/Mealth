<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("user_id");
            $table->string('title');
            $table->date('start_time');

            $table->integer("duration");
            $table->integer("calories");
            $table->integer("price");
            $table->string("privacy");
            $table->string("kind");

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
        Schema::dropIfExists('food_schedules');
    }
}
