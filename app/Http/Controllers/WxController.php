<?php

namespace App\Http\Controllers;

use App\Vote;
use App\Autoreply;
use App\Defaultreply;
use App\Menuconfig;
use App\Menulog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use EasyWeChat\Foundation\Application;

class WxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //自动回复列表页
    public function autoReply()
    {
        $activeVal = 'arList';

        return view('weixin.arList', compact('activeVal'));
    }

    //获取自动回复分页详情
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

    //自动回复列表翻页
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

    //删除自动回复
    public function del()
    {
        $delIds = request('delIds');
        $deleted = DB::delete("delete from autoreplies where id in (".$delIds.")");

        return response()->json(array('delRes' => $deleted), 200);
    }

    //获取素材
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
                $userId = Auth::user()->name;
                $lists = Vote::where('userId', $userId)->orderBy('created_at','desc')->skip($pageId)->take($pageNum)->get();
                $totalNum = Vote::where('userId', $userId)->count();
                break;
        }

        return view('weixin.arSel', compact('mType', 'lists', 'totalNum', 'pageNum'));
    }

    //保存自动回复
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

    //获取默认自动回复内容
    public function getDr()
    {
        $drType = request('drType');
        $userId = Auth::user()->name;
        $res = Defaultreply::where('userId', $userId)->where('type', $drType)->value('content');

        return response()->json(array('data' => $res), 200);
    }

    //保存默认自动回复内容
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

    public function menuList()
    {
        $activeVal = 'menuList';

        $mut = Menulog::where('userId', Auth::user()->name)->value('updateTime');

        return view('weixin.menuList', compact('activeVal', 'mut'));
    }

    public function menuAdd()
    {
        $userId = Auth::user()->name;

        $levelOnes = Menuconfig::where('userId', $userId)->where('parentId', 'root')->where('type', 'parent')->get();

        $menuMsg = session('v_menuMsg');

        return view('weixin.menuAdd', compact('levelOnes', 'menuMsg'));
    }

    public function menuStore()
    {
        $mc = new Menuconfig();

        $userId     = Auth::user()->name;
        $nodeId     = time().str_random(5);
        $parentId   = request('menuLevel') == '1' ? 'root' : request('levelOne');
        $arType     = request('arType');
        $menuType   = request('menuType') == 'click' ? (($arType == '1' || $arType == '2') ? 'media_id' : request('menuType')) : request('menuType');

        $levelNum = Menuconfig::where('userId', $userId)->where('parentId', $parentId)->count();

        if($parentId == 'root') {
            if($levelNum >= 3) return response()->json(array('data' => '一级菜单已满，无法添加！'), 200);
        }else{
            if($levelNum >= 5) return response()->json(array('data' => '该菜单下的二级菜单已满，无法添加！'), 200);
        }

        $mc->userId         = $userId;
        $mc->nodeId         = $nodeId;
        $mc->parentId       = $parentId;
        $mc->name           = request('menuName');
        $mc->type           = $menuType;
        $mc->arType         = $arType;
        $mc->content        = $menuType == 'click' ? $nodeId : request('menuContent');
        $mc->mContent       = request('arContent');
        $mc->mTitle         = ($menuType == 'click' && $arType == '0') ? substr(request('arMtitle'),0, 10) : request('arMtitle');
        $mc->mDescription   = request('arMdescription');
        $mc->mUrl           = request('arMurl');
        $mc->mImage         = request('arMimage');

        $res = $mc->save();

        if($res){
            return response()->json(array('data' => '添加成功！'), 200);
        }else{
            return response()->json(array('data' => '添加失败！'), 200);
        }
    }

    public function getMenu()
    {
        $res = Menuconfig::where('userId', Auth::user()->name)->orderBy('created_at', 'asc')->get();

        return response()->json(array('data' => $res), 200);
    }

    public function clearMenu()
    {
        $res = Menuconfig::where('userId', Auth::user()->name)->delete();

        $rel = '失败';
        if($res) $rel = '成功';

        return response()->json(array('data' => $rel), 200);
    }

    public function getOneMenu()
    {
        $res = Menuconfig::where('nodeId', request('nodeId'))->first();

        return response()->json(array('data' => $res), 200);
    }

    public function delOneMenu()
    {
        $nodeId = request('nodeId');

        $res = Menuconfig::where(function ($query) use ($nodeId) {
            $query->where('nodeId', '=', $nodeId)
                ->orWhere('parentId', '=', $nodeId);
        })->delete();

        return response()->json(array('data' => $res), 200);
    }

    public function dropMenu()
    {
        $wcc = new WechatconfigsController();
        $options = $wcc->getOptions();
        $app = new Application($options);
        $menu = $app->menu;

        $delRes = $menu->destroy();
        $delObj = json_decode($delRes);

        if($delObj->errmsg && $delObj->errmsg == 'ok') {
            $userId = Auth::user()->name;
            $nowTime = Carbon::now()->toDateTimeString();
            $num = Menulog::where('userId', $userId)->count();

            if ($num > 0) {
                Menulog::where('userId', $userId)->update(['updateTime' => $nowTime]);
            } else {
                $ml = new Menulog();

                $ml->userId = $userId;
                $ml->updateTime = $nowTime;

                $ml->save();
            }

            return response()->json(array('data' => '成功', 'updateTime' => $nowTime), 200);
        }else{
            return response()->json(array('data' => '失败'), 200);
        }
    }

    public function updateMenu()
    {
        $buttons = $this->getButtons();

        $wcc = new WechatconfigsController();
        $options = $wcc->getOptions();
        $app = new Application($options);
        $menu = $app->menu;

        //先删除
        $delRes = $menu->destroy();
        $delObj = json_decode($delRes);

        if($delObj->errmsg && $delObj->errmsg == 'ok') {
            //再添加
            $addRes = $menu->add($buttons);
            $addObj = json_decode($addRes);

            if($addObj->errmsg && $addObj->errmsg == 'ok') {
                $userId = Auth::user()->name;
                $nowTime = Carbon::now()->toDateTimeString();
                $num = Menulog::where('userId', $userId)->count();

                if ($num > 0) {
                    Menulog::where('userId', $userId)->update(['updateTime' => $nowTime]);
                } else {
                    $ml = new Menulog();

                    $ml->userId = $userId;
                    $ml->updateTime = $nowTime;

                    $ml->save();
                }

                return response()->json(array('data' => '成功', 'updateTime' => $nowTime), 200);
            }else{
                return response()->json(array('data' => '失败'), 200);
            }
        }else{
            return response()->json(array('data' => '失败'), 200);
        }
    }

    private function getButtons()
    {
        $userId  = Auth::user()->name;
        $buttons = array();

        $lists = Menuconfig::where('userId', $userId)->where('parentId', 'root')->orderBy('created_at','asc')->get();

        foreach ($lists as $list){
            if($list->type == 'parent'){
                array_push($buttons, array(
                    "name" => $list->name,
                    "sub_button" => $this->getSubs($list->nodeId)
                ));
            }else {
                $key = $this->getKey($list->type);

                array_push($buttons, array(
                    "type"  => $list->type,
                    "name"  => $list->name,
                    $key    => $list->content
                ));
            }
        }

        return $buttons;
    }

    private function getSubs($pId)
    {
        $userId  = Auth::user()->name;

        $ones = Menuconfig::where('userId', $userId)->where('parentId', $pId)->orderBy('created_at','asc')->get();
        $arr = array();

        foreach ($ones as $one){
            $key = $this->getKey($one->type);

            array_push($arr, array(
                "type"  => $one->type,
                "name"  => $one->name,
                $key    => $one->content
            ));
        }

        return $arr;
    }

    private function getKey($aType)
    {
        switch ($aType){
            case 'view':
                return 'url';
                break;
            case 'media_id':
                return 'media_id';
                break;
            case 'click':
                return 'key';
                break;
        }
    }
}
