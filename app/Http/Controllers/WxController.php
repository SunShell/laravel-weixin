<?php

namespace App\Http\Controllers;

use App\Vote;
use EasyWeChat;
use App\Autoreply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                $material = EasyWeChat::material();
                $json = $material->lists('image', $pageId, $pageNum);
                $obj = json_decode($json);
                $lists = $obj->item;
                $totalNum = $obj->total_count;
                break;
            case '2':
                $material = EasyWeChat::material();
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
        $ar->mTitle = request('arMtitle');
        $ar->mDescription = request('arMdescription');
        $ar->mUrl = request('arMurl');
        $ar->mImage = request('arMimage');

        $ar->save();

        return redirect('/autoReply');
    }
}
