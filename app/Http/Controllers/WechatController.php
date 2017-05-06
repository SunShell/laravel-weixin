<?php

namespace App\Http\Controllers;

use App\Autoreply;
use App\Defaultreply;
use App\Menuconfig;
use App\Wechatconfig;
use EasyWeChat\Message\Image;
use EasyWeChat\Message\Material;
use EasyWeChat\Message\News;
use EasyWeChat\Foundation\Application;

class WechatController extends Controller
{
    private $userId;
    private $options;

    public function serve($gzptId)
    {
        $this->userId = env('WECHAT_USERID_'.$gzptId, 'nobody');
        $this->options = $this->getOptions();

        $wechat = new Application($this->options);
        $userId = $this->userId;

        $wechat->server->setMessageHandler(function($message) use ($wechat,$userId){
            switch ($message->MsgType) {
                case 'event':
                    switch ($message->Event){
                        case 'subscribe':
                            return $this->getDefaultMsg(1);
                            break;
                        case 'CLICK':
                            $val = $message->EventKey;
                            $num = Menuconfig::where('userId', $userId)->where('type', 'click')->where('content', $val)->count();

                            if($num > 0){
                                $arr = Menuconfig::where('userId', $userId)->where('type', 'click')->where('content', $val)->first();

                                switch ($arr->arType){
                                    case '0':
                                        return $arr->mContent;
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
                            }
                            break;
                        default:
                            return $this->getDefaultMsg(0);
                            break;
                    }
                    break;
                case 'text':
                    $val = $message->Content;
                    $num = Autoreply::where('userId', $userId)->where('keywords', $val)->count();

                    if($num > 0){
                        $arr = Autoreply::where('userId', $userId)->where('keywords', $val)->first();

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

    //获取默认回复
    private function getDefaultMsg($type)
    {
        $userId = $this->userId;

        $res = Defaultreply::where('userId', $userId)->where('type', $type)->value('content');

        if(!$res){
            return '您好！';
        }else{
            return $res;
        }
    }

    //获取公众平台参数
    private function getOptions()
    {
        $userId = $this->userId;

        $config = Wechatconfig::where('userId', $userId)->first();

        return [
            'debug'  => env('WECHAT_DEBUG', false),
            'use_laravel_cache' => false,
            'app_id' => $config->appId,
            'secret' => $config->secretId,
            'token'  => $config->tokenId,
            'aes_key' => $config->aesKey,
            'log' => [
                'level' => 'debug',
                'file'  => storage_path('logs/wechat_'.$userId.'.log')
            ]
        ];
    }
}
