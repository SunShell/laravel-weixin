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
        $activeVal = 'voteList';

        return view('votes.index', compact('activeVal'));
    }

    public function create()
    {
        $activeVal = 'voteForm';

        return view('votes.create', compact('activeVal'));
    }

    public function store()
    {

    }
}
