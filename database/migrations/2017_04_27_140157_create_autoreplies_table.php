<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutorepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autoreplies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userId');
            $table->string('keywords');
            $table->tinyInteger('type');//0 文字，1 素材图片，2 素材文章，3 图文消息投票，4 图文消息自定义
            $table->text('content')->nullable();
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
        Schema::dropIfExists('autoreplies');
    }
}
