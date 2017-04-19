<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Vote;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['pcDetail']);
    }

    //首页
    public function index()
    {
        $activeVal  = 'voteList';
        $votes      = Vote::latest()->get();
        $voteName  = '';

        return view('votes.index', compact('activeVal','votes', 'voteName'));
    }

    //搜索
    public function search()
    {
        $voteName   = request('voteName');

        if($voteName == '') return redirect()->home();

        $activeVal  = 'voteList';
        $votes      = Vote::where('name', 'like', '%'.$voteName.'%')->get();

        return view('votes.index', compact('activeVal','votes', 'voteName'));
    }

    //删除
    public  function destroy()
    {
        $voteIds = request('voteIds');
        $delArr  = explode(',', $voteIds);

        foreach ($delArr as $delId){
            Vote::where('voteId', '=', $delId)->delete();
        }

        return redirect()->home();
    }

    //PC端详情页
    public function pcDetail($voteId)
    {
        $vote  = Vote::where('voteId', $voteId)->first();

        return view('votes/pcDetail', compact('vote'));
    }

    //投票页
    public function detail()
    {

    }

    //添加页面
    public function create()
    {
        $activeVal = 'voteForm';

        return view('votes.create', compact('activeVal'));
    }

    //保存
    public function store()
    {
        $request = request();

        $file       = $request->file('topImg');
        $fileName   = time().str_random(5).'.'.$file->getClientOriginalExtension();
        $file->move('storage/topImages', $fileName);

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

    //格式化时间
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
