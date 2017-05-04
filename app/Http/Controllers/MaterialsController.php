<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;

class MaterialsController extends Controller
{
    public $material;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getFun()
    {
        $wcc = new WechatconfigsController();
        $options = $wcc->getOptions();

        $this->material = new Application($options);
    }

    public function photos()
    {
        $this->getFun();

        $photos = $this->material->lists('image');

        return $photos;
    }

    public function articles()
    {
        $this->getFun();
        
        $articles = $this->material->lists('news');

        return $articles;
    }
}
