<?php

namespace App\Http\Controllers;

use App\Vote;
use App\Autoreply;
use App\Defaultreply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use EasyWeChat\Foundation\Application;

class WxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function autoReply()
    {
        $activeVal = 'arList';

        return view('weixin.arList', compact('activeVal'));
    }

    public function getPageInfo()
    {
        $pageSize = request('pageSize');
        $kwd = request('kwd');

        $user   = Auth::user()->name;

        if($kwd != ''){
            $allNum = Autoreply::where('userId', $user)->where('keywords', 'like', '%'.$kwd.'%')->count();
            $list   = Autoreply::where('userId', $user)->where('keywords', 'like', '%'.$kwd.'%')->orderBy('created_at','desc')->skip(0)->take($pageSize)->get();
        }else{
            $allNum = Autoreply::where('userId', $user)->count();
            $list   = Autoreply::where('userId', $user)->orderBy('created_at','desc')->skip(0)->take($pageSize)->get();
        }

        return response()->json(array('allNum'=> $allNum, 'pageData' => $list), 200);
    }

    public function getPaging()
    {
        $kwd = request('kwd');
        $pageSize = request('pageSize');
        $pageId = (request('pageId') - 1) * $pageSize;

        $user = Auth::user()->name;

        if($kwd != ''){
            $list = Autoreply::where('userId', $user)->where('keywords', 'like', '%'.$kwd.'%')->orderBy('created_at','desc')->skip($pageId)->take($pageSize)->get();
        }else {
            $list = Autoreply::where('userId', $user)->orderBy('created_at','desc')->skip($pageId)->take($pageSize)->get();
        }

        return response()->json(array('pageData' => $list), 200);
    }

    public function del()
    {
        $delIds = request('delIds');
        $deleted = DB::delete("delete from autoreplies where id in (".$delIds.")");

        return response()->json(array('delRes' => $deleted), 200);
    }

    public function sel($mType)
    {
        $arr = explode('<@>', $mType);
        $pageNum = 5;
        $pageId = ($arr[1] - 1) * $pageNum;

        switch ($arr[0]){
            case '1':
                $wcc = new WechatconfigsController();
                $options = $wcc->getOptions();

                $app = new Application($options);
                $material = $app->material;

                $json = $material->lists('image', $pageId, $pageNum);
                $obj = json_decode($json);
                $lists = $obj->item;
                $totalNum = $obj->total_count;
                break;
            case '2':
                $wcc = new WechatconfigsController();
                $options = $wcc->getOptions();

                $app = new Application($options);
                $material = $app->material;

                $json = $material->lists('news', $pageId, $pageNum);
                $obj = json_decode($json);
                $lists = $obj->item;
                $totalNum = $obj->total_count;
                break;
            case '3':
                $lists = Vote::orderBy('created_at','desc')->skip($pageId)->take($pageNum)->get();
                $totalNum = Vote::count();
                break;
        }

        return view('weixin.arSel', compact('mType', 'lists', 'totalNum', 'pageNum'));
    }

    public function store()
    {
        $ar = new Autoreply;

        $ar->userId = Auth::user()->name;
        $ar->keywords = request('arKeyword');
        $ar->type = request('arType');
        $ar->content = request('arContent');
        $ar->mTitle = request('arType') == '0' ? substr(request('arContent'),0,10) : request('arMtitle');
        $ar->mDescription = request('arMdescription');
        $ar->mUrl = request('arMurl');
        $ar->mImage = request('arMimage');

        $ar->save();

        return redirect('/autoReply');
    }

    public function getDr()
    {
        $drType = request('drType');
        $userId = Auth::user()->name;
        $res = Defaultreply::where('userId', $userId)->where('type', $drType)->value('content');

        return response()->json(array('data' => $res), 200);
    }

    public function storeDr()
    {
        $drType     = request('drType');
        $drContent  = request('drContent');
        $userId     = Auth::user()->name;

        $num = Defaultreply::where('userId', $userId)->where('type', $drType)->count();

        if($num > 0){
            $res = Defaultreply::where('userId', $userId)->where('type', $drType)->update(['content' => $drContent]);
        }else{
            $dr = new Defaultreply();

            $dr->userId     = $userId;
            $dr->type       = $drType;
            $dr->content    = $drContent;

            $res = $dr->save();
        }

        if($res){
            return response()->json(array('flag' => 'yes'), 200);
        }else{
            return response()->json(array('flag' => 'no'), 200);
        }
    }
}
