<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotedailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votedailies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voteId');
            $table->string('wxId');
            $table->string('xsId');
            $table->string('voteDay');
            $table->mediumInteger('num');
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
        Schema::dropIfExists('votedailies');
    }
}
