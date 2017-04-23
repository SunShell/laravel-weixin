<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;

class MaterialsController extends Controller
{
    public $material;

    public function __construct(Application $material)
    {
        $this->middleware('auth');
        $this->material = $material->material;
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
