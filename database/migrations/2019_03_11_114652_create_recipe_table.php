<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('recipe_name');
            $table->longText('recipe_description');
            $table->string('recipe_video');
            $table->string("recipe_kind");
            $table->integer('recipe_calories');
            $table->integer('preparation_time');
            $table->integer('cooker_id');
            $table->integer('user_count');
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
        Schema::dropIfExists('recipe');
    }
}
