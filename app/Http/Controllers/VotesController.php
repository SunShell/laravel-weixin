<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Vote;
use App\VoteDetail;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');//->except(['pcDetail']);
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
        $vote = Vote::where('voteId', $voteId)->first();

        $players = Votedetail::where('voteId', $voteId)->orderBy('state','asc')->orderBy('created_at','desc')->get();

        return view('votes/pcDetail', compact('vote','players'));
    }

    //PC端选手搜索和审核
    public function pcDetailQuery($voteId)
    {
        $request = request();

        if(!$request->queryVal && !$request->checkId) return $this->pcDetail($voteId);

        $queryVal = $request->queryVal;
        $checkId = $request->checkId;

        if($checkId){
            VoteDetail::where('xsId', $checkId)->update(['state' => 1]);

            return $this->pcDetail($voteId);
        }else{
            $vote = Vote::where('voteId', $voteId)->first();

            $players = Votedetail::where('voteId', $voteId)->where(function ($query) use ($queryVal) {
                $query->where('xsNum', $queryVal)
                    ->orWhere('name', 'like', '%'.$queryVal.'%');
            })->orderBy('created_at','desc')->get();

            return view('votes/pcDetail', compact('vote','players'));
        }
    }

    //pc端报名
    public function pcApply($voteId)
    {
        $vote  = Vote::where('voteId', $voteId)->first();

        return view('votes/pcApply', compact('vote'));
    }

    //pc端报名保存
    public function pcApplyStore($voteId)
    {
        $request = request();

        $file       = $request->file('img');
        $fileName   = time().str_random(5).'.'.$file->getClientOriginalExtension();
        $file->move('storage/voteImages', $fileName);

        $player = Votedetail::where('voteId', $voteId)->orderBy('created_at','desc')->first();
        $xsNum = 1;

        if($player->xsNum) $xsNum = $player->xsNum + 1;

        $voteDetail = new Votedetail;

        $voteDetail->voteId         = $voteId;
        $voteDetail->xsId           = 'pc_'.time().'_'.str_random(5);
        $voteDetail->xsNum          = $xsNum;
        $voteDetail->name           = $request->name;
        $voteDetail->introduction   = $request->introduction;
        $voteDetail->img            = $fileName;
        $voteDetail->state          = 1;
        $voteDetail->num            = 0;

        $voteDetail->save();

        return redirect('/votes/'.$voteId);
    }

    //pc端排名
    public function pcRank($voteId)
    {
        $vote = Vote::where('voteId', $voteId)->first();

        $players = Votedetail::where('voteId', $voteId)->where('state', 1)->orderBy('num','desc')->get();

        return view('votes/pcRank', compact('vote','players'));
    }

    //pc端选手详情
    public function pcOneDetail($theId)
    {
        $idArr = explode('<>', $theId);
        $voteId = $idArr[0];
        $playerId = $idArr[1];

        $vote = Vote::where('voteId', $voteId)->first();

        $player = Votedetail::where('xsId', $playerId)->first();

        return view('votes/pcOneDetail', compact('vote','player'));
    }

    //投票页
    public function detail()
    {

    }

    //投票添加页面
    public function create()
    {
        $activeVal = 'voteForm';

        return view('votes.create', compact('activeVal'));
    }

    //投票保存
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
