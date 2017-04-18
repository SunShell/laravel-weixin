<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Vote;

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
        $request = request();

        $file       = $request->file('topImg');
        $fileName   = time().'_'.$file->getClientOriginalName();
        $file->move('topImages', $fileName);

        $vote = new Vote;

        $vote->voteId       = time().str_random(10);
        $vote->name         = $request->name;
        $vote->startTime    = $this->formatDt($request->startTime,'0');
        $vote->endTime      = $this->formatDt($request->endTime,'1');
        $vote->playerName   = $request->playerName;
        $vote->detail       = $request->detail;
        $vote->topImg       = $fileName;
        $vote->voteType     = $request->voteType;
        $vote->dayNum       = $request->dayNum;
        $vote->playerNum    = $request->playerNum;
        $vote->isDaily      = $request->isDaily;
        $vote->isPublic     = $request->isPublic;

        $vote->save();

        return redirect()->home();
    }

    private function formatDt($val, $type)
    {
        $arr = explode('/', $val);

        if($type == '0') {
            $dt = Carbon::create($arr[0], $arr[1], $arr[2], 0, 0, 0);
        }else{
            $dt = Carbon::create($arr[0], $arr[1], $arr[2], 23, 59, 59);
        }

        return $dt->toDateTimeString();
    }
}
