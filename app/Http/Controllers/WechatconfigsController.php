<?php

namespace App\Http\Controllers;

use App\Wechatconfig;
use Illuminate\Support\Facades\Auth;

class WechatconfigsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getOptions()
    {
        $userId = Auth::user()->name;

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
