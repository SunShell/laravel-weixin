<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voteId');
            $table->string('name');
            $table->timestamp('startTime')->nullable();
            $table->timestamp('endTime')->nullable();
            $table->string('playerName');
            $table->text('detail');
            $table->string('topImg');
            $table->tinyInteger('voteType')->default(0);
            $table->mediumInteger('dayNum')->default(0);
            $table->mediumInteger('playerNum')->default(0);
            $table->boolean('isDaily')->default(true);
            $table->boolean('isPublic')->default(false);
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
        Schema::dropIfExists('votes');
    }
}
