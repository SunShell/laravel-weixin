<?php

namespace App\Http\Controllers;

use EasyWeChat\Message\Image;
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

        $userApi = $wechat->user;

        $wechat->server->setMessageHandler(function($message) use ($userApi,$wechat){
            switch ($message->MsgType) {
                case 'text':
                    switch($message->Content){
                        case '最美妈妈':
                            $image = new Image(['media_id' => '18gcYy6GNI26QOrkRRtmIgK-gNmXA1nnxfeHVVLBuO8']);

                            $wechat->staff->message($image)->to($message->FromUserName)->send();

                            return '活动尚未开始，请耐心等待！';
                            break;
                        default:
                            return $this->getDefaultMsg();
                            break;
                    }
                    break;
                default:
                    return $this->getDefaultMsg();
                    break;
            }
        });

        return $wechat->server->serve();
    }

    private function getDefaultMsg()
    {
        return '亲，欢迎加入到铝融网免费找货卖货微信服务哦！你有困难我帮助，你有采购我来找。轻松写下你的需求：发语音、发文字我统统照收，并且免费报价报给您哦！不过，您要留下姓名和联系方式，我们会尽快联系您，为您找货！我们的客服热线0533-6202989，欢迎您随时来骚扰！';
    }
}
