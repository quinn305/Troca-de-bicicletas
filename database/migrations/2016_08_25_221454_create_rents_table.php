<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('status');
            $table->integer('old_code');
            $table->integer('new_code');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('bike_id')->unsigned();
            $table->foreign('bike_id')->references('id')->on('bikes');
            $table->integer('stand_from_id')->unsigned();
            $table->foreign('stand_from_id')->references('id')->on('stands');
            $table->integer('stand_to_id')->unsigned()->nullable();
            $table->foreign('stand_to_id')->references('id')->on('stands');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
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
        Schema::drop('rents');
    }
}
