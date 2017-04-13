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
            $table->string('voteid');
            $table->string('name');
            $table->timestamp('btm');
            $table->timestamp('etm');
            $table->string('pname');
            $table->text('detail');
            $table->string('topimg');
            $table->tinyInteger('votetype')->default(0);
            $table->mediumInteger('dnum')->default(0);
            $table->mediumInteger('pnum')->default(0);
            $table->boolean('isdaily')->default(true);
            $table->boolean('ispublic')->default(false);
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
