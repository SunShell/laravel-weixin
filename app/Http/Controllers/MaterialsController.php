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
        $photos = $this->material->list('image');

        return $photos;
    }
}
