<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public $menu;

    public function __construct(Application $app)
    {
        $this->middleware('auth');
        $this->menu = $app->menu;
    }

    public function menu()
    {
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
                        "name" => "测试",
                        "key" => "zmmm"
                    ]
                ]
            ]
        ];

        $this->menu->add($buttons);
    }

    public function getMenu()
    {
        return $this->menu->current();
    }

    public function delMenu($menuId)
    {
        return $this->menu->destroy($menuId);
    }
}
