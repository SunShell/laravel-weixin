<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;

class MaterialsController extends Controller
{
    public $material;

    public function __construct()
    {
        $this->middleware('auth');

        $wcc = new WechatconfigsController();
        $options = $wcc->getOptions();

        $this->material = new Application($options);
    }

    public function photos()
    {
        $photos = $this->material->lists('image');

        return $photos;
    }

    public function articles()
    {
        $articles = $this->material->lists('news');

        return $articles;
    }
}
