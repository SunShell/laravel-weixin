<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;

class MenuController extends Controller
{
    public $menu;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getFun()
    {
        $wcc = new WechatconfigsController();
        $options = $wcc->getOptions();

        $app = new Application($options);
        $this->menu = $app->menu;
    }

    public function menu()
    {
        $this->getFun();

        $buttons = [
            [
                "type" => "view",
                "name" => "铝融网",
                "url"  => "http://www.lrw360.com/"
            ],
            [
                "name"       => "铝融服务",
                "sub_button" => [
                    [
                        "type" => "media_id",
                        "name" => "关于我们",
                        "media_id"  => "18gcYy6GNI26QOrkRRtmIhFV5WeeZ5tgrbn2h2DwyRc"
                    ],
                    [
                        "type" => "media_id",
                        "name" => "物流服务",
                        "media_id"  => "18gcYy6GNI26QOrkRRtmIkSuAEbNU2ANxvj6dR3ot5U"
                    ],
                    [
                        "type" => "media_id",
                        "name" => "仓储服务",
                        "media_id" => "18gcYy6GNI26QOrkRRtmImG41Z-KotUDlLO3V54NdRs"
                    ],
                ],
            ],
            [
                "name"          => "铝融活动",
                "sub_button"    => [
                    [
                        "type" => "click",
                        "name" => "最美妈妈",
                        "key" => "zmmm"
                    ]
                ]
            ]
        ];

        return $this->menu->add($buttons);
    }

    public function getMenu()
    {
        $this->getFun();

        return $this->menu->all();
    }

    public function delMenu()
    {
        $this->getFun();

        return $this->menu->destroy();
    }
}
