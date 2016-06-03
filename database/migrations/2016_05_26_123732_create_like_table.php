<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likeable',function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id');
            $table->integer('likeable_id');
            $table->string('likeable_type');
            $table->text('body');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('likeable');
    }
}
