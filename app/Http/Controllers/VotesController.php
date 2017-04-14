<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('votes.index');
    }

    public function create()
    {
        return view('votes.create');
    }
}
