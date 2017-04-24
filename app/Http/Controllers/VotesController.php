<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Vote;
use App\Votedetail;
use App\Votedaily;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['detail','detailQuery','apply','applyStore','rank','oneDetail','voteOp','verify']);
    }

    //首页
    public function index()
    {
        $activeVal  = 'voteList';
        $votes      = Vote::latest()->get();
        $voteName  = '';

        return view('votes.index', compact('activeVal','votes', 'voteName'));
    }

    //php info
    public function info()
    {
        return view('info');
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
            Votedetail::where('voteId', '=', $delId)->delete();
            Votedaily::where('voteId', '=', $delId)->delete();
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

        if($player && $player->xsNum) $xsNum = $player->xsNum + 1;

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

    public function verify($twoId)
    {
        $arr = explode('@v@', $twoId);

        session('openid', 'no');
        session(['openid' => $arr[1]]);

        return redirect('/vote/'.$arr[0]);
    }

    //投票页
    public function detail($voteId)
    {
        $vote = Vote::where('voteId', $voteId)->first();

        $players = Votedetail::where('voteId', $voteId)->where('state', 1)->orderBy('xsNum', 'asc')->get();

        $res = '';

        return view('votes.detail', compact('vote','players', 'res'));
    }

    //查询
    public function detailQuery($voteId)
    {
        $request = request();

        if(!$request->queryVal) return $this->detail($voteId);

        $queryVal = $request->queryVal;
        $vote = Vote::where('voteId', $voteId)->first();

        $players = Votedetail::where('voteId', $voteId)->where('state',1)->where(function ($query) use ($queryVal) {
            $query->where('xsNum', $queryVal)
                ->orWhere('name', 'like', '%'.$queryVal.'%');
        })->orderBy('xsNum','asc')->get();

        $res = '';

        return view('votes.detail', compact('vote','players', 'res'));
    }

    //报名
    public function apply($voteId)
    {
        $vote   = Vote::where('voteId', $voteId)->first();

        $openid = $this->getUserInfo();
        $flag   = '0';
        $now    = Carbon::now()->toDateTimeString();

        if($now < $vote->startTime){
            $flag = '3';
        }

        if($now > $vote->endTime){
            $flag = '4';
        }

        if($flag == '0'){
            $num    = Votedetail::where('voteId', $voteId)->where('xsId', $openid)->count();

            if($num > 0){
                $state = Votedetail::where('voteId', $voteId)->where('xsId', $openid)->value('state');

                if($state == '0'){
                    $flag = '1';
                }else{
                    $flag = '2';
                }
            }
        }

        $res = '';

        return view('votes.apply', compact('vote', 'flag', 'res'));
    }

    //报名保存
    public function applyStore($voteId)
    {
        $xsId = $this->getUserInfo();

        if(Votedetail::where('voteId', $voteId)->where('xsId', $xsId)->count() > 0){
            return $this->apply($voteId);
        }

        $request = request();

        $file       = $request->file('img');
        $fileName   = time().str_random(5).'.'.$file->getClientOriginalExtension();
        $file->move('storage/voteImages', $fileName);

        $player = Votedetail::where('voteId', $voteId)->orderBy('created_at','desc')->first();
        $xsNum = 1;

        if($player && $player->xsNum) $xsNum = $player->xsNum + 1;

        $voteDetail = new Votedetail;

        $voteDetail->voteId         = $voteId;
        $voteDetail->xsId           = $xsId;
        $voteDetail->xsNum          = $xsNum;
        $voteDetail->name           = $request->name;
        $voteDetail->introduction   = $request->introduction;
        $voteDetail->img            = $fileName;
        $voteDetail->state          = 1;
        $voteDetail->num            = 0;

        $voteDetail->save();

        return $this->apply($voteId);
    }

    //排名
    public function rank($voteId)
    {
        $vote = Vote::where('voteId', $voteId)->first();

        $players = Votedetail::where('voteId', $voteId)->where('state', 1)->orderBy('num','desc')->get();

        $res = '';

        return view('votes.rank', compact('vote','players', 'res'));
    }

    //选手详情
    public function oneDetail($theId)
    {
        $idArr = explode('<>', $theId);
        $voteId = $idArr[0];
        $playerId = $idArr[1];

        $vote = Vote::where('voteId', $voteId)->first();

        $player = Votedetail::where('xsId', $playerId)->first();

        $res = '';

        return view('votes.oneDetail', compact('vote','player', 'res'));
    }

    //提交投票
    public function voteOp($voteId)
    {
        $wxId = $this->getUserInfo();
        $xsId = request('xsId');

        $vote = Vote::where('voteId', $voteId)->first();
        $dayNum = $vote->dayNum;
        $playerNum = $vote->playerNum;

        $res = $this->dayVote($wxId,$xsId,$dayNum,$playerNum,$voteId);

        $players = Votedetail::where('voteId', $voteId)->where('state', 1)->orderBy('xsNum', 'asc')->get();

        return view('votes.detail', compact('vote','players', 'res'));
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

    //获取用户信息
    private function getUserInfo()
    {
        return session('openid');
    }

    //投票控制器
    private function dayVote($wxId,$xsId,$dNum,$pNum,$voteId)
    {
        //先看一下当前微信用户有没有进行投票（包括历史投票）
        $flag_1 = Votedaily::where('voteId', $voteId)->where('wxId', $wxId)->count();
        $daily  = new Votedaily;
        $today  = Carbon::now()->toDateString();
        $nowNum = Votedetail::where('voteId', $voteId)->where('xsId', $xsId)->value('num');

        $vote   = Vote::where('voteId', $voteId)->first();
        if(substr($vote->startTime,0,10) > $today){
            return '投票尚未开始！';
        }

        if(substr($vote->endTime,0,10) < $today){
            return '投票已经结束！';
        }

        //如果进行过投票
        if($flag_1 > 0){
            //再看今天有没有进行投票
            $flag_2 = Votedaily::where('voteId', $voteId)->where('wxId', $wxId)->where('voteDay', $today)->count();

            //如果今天投过票
            if($flag_2 > 0){
                $flag_3 = Votedaily::where('voteId', $voteId)->where('wxId', $wxId)->where('voteDay', $today)->where('xsId', $xsId)->value('num');
                $flag_4 = Votedaily::where('voteId', $voteId)->where('wxId', $wxId)->where('voteDay', $today)->sum('num');

                //如果今天已达最大投票数
                if($flag_4 >= $dNum){
                    return '今天的投票数已达最大值！';
                }

                //如果今天投了票，再看这个微信号是不是给当前选手投的票
                //如果今天是给当前选手投的票
                if($flag_3){
                    if($flag_3 >= $pNum){
                        return '今天给该选手的投票数已达最大值！';
                    }else{
                        Votedaily::where('voteId', $voteId)->where('wxId', $wxId)->where('xsId', $xsId)->update(['num' => $flag_3 + 1]);
                        Votedetail::where('voteId', $voteId)->where('xsId', $xsId)->update(['num' => $nowNum + 1]);

                        return '投票成功！';
                    }
                }else{
                    //如果今天不是给当前选手投的票
                    //看一下之前有没有给当前选手投过票
                    $flag_5 = Votedaily::where('voteId', $voteId)->where('wxId', $wxId)->where('xsId', $xsId)->count();

                    //投过就更新
                    if($flag_5 > 0){
                        Votedaily::where('voteId', $voteId)->where('wxId', $wxId)->where('xsId', $xsId)->update(['num' => 1, 'voteDay' => $today]);
                    }else{
                        //没投过就添加
                        $daily->voteId  = $voteId;
                        $daily->wxId    = $wxId;
                        $daily->xsId    = $xsId;
                        $daily->voteDay = $today;
                        $daily->num     = 1;

                        $daily->save();
                    }

                    Votedetail::where('voteId', $voteId)->where('xsId', $xsId)->update(['num' => $nowNum + 1]);

                    return '投票成功！';
                }
            }else{
                //如果今天没投票，再看之前这个微信号有没有给当前选手投过票
                $flag_6 = Votedaily::where('voteId', $voteId)->where('wxId', $wxId)->where('xsId', $xsId)->count();

                //投过就更新
                if($flag_6 > 0){
                    Votedaily::where('voteId', $voteId)->where('wxId', $wxId)->where('xsId', $xsId)->update(['num' => 1, 'voteDay' => $today]);
                }else{
                    //没投过就添加
                    $daily->voteId  = $voteId;
                    $daily->wxId    = $wxId;
                    $daily->xsId    = $xsId;
                    $daily->voteDay = $today;
                    $daily->num     = 1;

                    $daily->save();
                }

                Votedetail::where('voteId', $voteId)->where('xsId', $xsId)->update(['num' => $nowNum + 1]);

                return '投票成功！';
            }
        }else{
            //没有进行任何投票
            $daily->voteId  = $voteId;
            $daily->wxId    = $wxId;
            $daily->xsId    = $xsId;
            $daily->voteDay = $today;
            $daily->num     = 1;

            $daily->save();

            Votedetail::where('voteId', $voteId)->where('xsId', $xsId)->update(['num' => $nowNum + 1]);

            return '投票成功！';
        }
    }
}
