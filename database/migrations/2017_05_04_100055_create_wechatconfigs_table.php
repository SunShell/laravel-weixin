<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechatconfigs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userId');
            $table->string('appId');
            $table->string('secretId');
            $table->string('tokenId');
            $table->string('aesKey');
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
        Schema::dropIfExists('wechatconfigs');
    }
}
