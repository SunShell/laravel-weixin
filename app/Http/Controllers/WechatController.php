<?php

namespace App\Http\Controllers;

use App\Autoreply;
use App\Defaultreply;
use EasyWeChat\Message\Image;
use EasyWeChat\Message\Material;
use EasyWeChat\Message\News;

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
                        case 'subscribe':
                            return $this->getDefaultMsg(1);
                            break;
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
                            return $this->getDefaultMsg(0);
                            break;
                    }
                    break;
                case 'text':
                    $val = $message->Content;
                    $uid = 'admin';
                    $num = Autoreply::where('userId', $uid)->where('keywords', $val)->count();

                    if($num > 0){
                        $arr = Autoreply::where('userId', $uid)->where('keywords', $val)->first();

                        switch ($arr->type){
                            case '0':
                                return $arr->content;
                                break;
                            case '1':
                                $image = new Image(['media_id' => $arr->content]);

                                $wechat->staff->message($image)->to($message->FromUserName)->send();
                                break;
                            case '2':
                                $news = new Material('mpnews', $arr->content);

                                $wechat->staff->message($news)->to($message->FromUserName)->send();
                                break;
                            case '3':
                                $news = new News([
                                    'title'         => $arr->mTitle,
                                    'description'   => $arr->mDescription,
                                    'url'           => asset('/verify/'.$arr->mUrl.'@v@'.$message->FromUserName),
                                    'image'         => asset('/storage/topImages/'.$arr->mImage)
                                ]);

                                $wechat->staff->message($news)->to($message->FromUserName)->send();
                                break;
                            case '4':
                                $news = new News([
                                    'title'         => $arr->mTitle,
                                    'description'   => $arr->mDescription,
                                    'url'           => $arr->mUrl,
                                    'image'         => $arr->mImage
                                ]);

                                $wechat->staff->message($news)->to($message->FromUserName)->send();
                                break;
                        }
                    }else{
                        return $this->getDefaultMsg(0);
                    }
                    break;
                default:
                    return $this->getDefaultMsg(0);
                    break;
            }
        });

        return $wechat->server->serve();
    }

    private function getDefaultMsg($type)
    {
        $res = Defaultreply::where('userId', 'admin')->where('type', $type)->value('content');

        if(!$res){
            return '您好！';
        }else{
            return $res;
        }
    }
}
