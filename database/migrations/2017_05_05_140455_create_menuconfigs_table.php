<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menuconfigs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userId');
            $table->string('nodeId');
            $table->string('parentId')->default('root');
            $table->string('name');
            $table->string('type');
            $table->string('content')->nullable();
            $table->tinyInteger('arType')->nullable();
            $table->text('mContent')->nullable();
            $table->string('mTitle')->nullable();
            $table->string('mDescription')->nullable();
            $table->string('mUrl')->nullable();
            $table->string('mImage')->nullable();
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
        Schema::dropIfExists('menuconfigs');
    }
}
