<?php

namespace App\Http\Controllers;

use EasyWeChat\Message\Image;
use EasyWeChat\Message\News;
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
                case 'event':
                    switch ($message->Event){
                        case 'CLICK':
                            if($message->EventKey == 'zmmm'){
                                $news = new News([
                                    'title'         => '最美妈妈，母亲节送出一份爱的礼物',
                                    'description'   => '点击进入投票并转发给好友，就有机会赢得礼品一份！',
                                    'url'           => 'http://www.lvshangwang.com/verify/1493022390JT13lCdFoh@v@'.$message->FromUserName,
                                    'image'         => 'http://www.lvshangwang.com/storage/topImages/14930223905j0mS.jpg'
                                ]);

                                $wechat->staff->message($news)->to($message->FromUserName)->send();
                            }
                            break;
                        default:
                            return $this->getDefaultMsg();
                            break;
                    }
                    break;
                case 'text':
                    switch($message->Content){
                        case '投票':
                        case '最美妈妈':
                            $news = new News([
                                'title'         => '最美妈妈，母亲节送出一份爱的礼物',
                                'description'   => '点击进入投票并转发给好友，就有机会赢得礼品一份！',
                                'url'           => 'http://www.lvshangwang.com/verify/1493022390JT13lCdFoh@v@'.$message->FromUserName,
                                'image'         => 'http://www.lvshangwang.com/storage/topImages/14930223905j0mS.jpg'
                            ]);

                            $wechat->staff->message($news)->to($message->FromUserName)->send();
                            break;
                        case '手势':
                            $image = new Image(['media_id' => '18gcYy6GNI26QOrkRRtmIndFLbo8ImwjGEj88fyU9HM']);

                            $wechat->staff->message($image)->to($message->FromUserName)->send();
                            break;
                        case '厕所':
                            $image = new Image(['media_id' => '18gcYy6GNI26QOrkRRtmIpn9n95c2gIREY40MEzidX0']);

                            $wechat->staff->message($image)->to($message->FromUserName)->send();
                            break;
                        case '美女':
                            $image = new Image(['media_id' => '18gcYy6GNI26QOrkRRtmIksDQEFGNFVT7eu_OoudKEw']);

                            $wechat->staff->message($image)->to($message->FromUserName)->send();
                            break;
                        case '地铁':
                            $image = new Image(['media_id' => '18gcYy6GNI26QOrkRRtmImuSAz3srUOfDevZr5tGl2Q']);

                            $wechat->staff->message($image)->to($message->FromUserName)->send();
                            break;
                        case '颜色':
                            $image = new Image(['media_id' => '18gcYy6GNI26QOrkRRtmIr0Mg2Pi4PeP6WJ58KZjqVs']);

                            $wechat->staff->message($image)->to($message->FromUserName)->send();
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
