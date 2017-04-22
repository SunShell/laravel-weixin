<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            return "欢迎关注铝融网！";
        });

        return $wechat->server->serve();
    }
}
