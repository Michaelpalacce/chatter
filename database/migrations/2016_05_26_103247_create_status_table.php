<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses',function(Blueprint $table){
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id');
            $table->integer('parent_id')->nullable();
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
        Schema::drop('statuses');

    }
}
