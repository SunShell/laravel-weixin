<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votedetails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voteId');
            $table->string('xsId');
            $table->string('name');
            $table->string('phoneNum');
            $table->string('img');
            $table->boolean('state')->default(false);
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
        Schema::dropIfExists('votedetails');
    }
}
