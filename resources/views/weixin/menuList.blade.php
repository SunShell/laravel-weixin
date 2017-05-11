@extends('layouts.master')

@section('content')
    <div class="container votesList">
        {{ csrf_field() }}
        <div class="menuContainerLeft">
            <div class="menuContainerLeftOp">
                <button id="menuAdd" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 添加</button>&nbsp;
                <button id="menuClear" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> 清空</button>
            </div>

            <div id="menuTree" class="ztree"></div>
        </div>

        <div class="menuContainerRight">
        </div>

        <div class="text-center menuContainerBottom">
            <button id="dropMenu" class="btn btn-danger">删 除 菜 单</button>&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="updateMenu" class="btn btn-primary">更 新 菜 单</button>
            <p style="padding-top: 10px;">上次更新时间：<span id="updateTime">{{ $mut ? $mut : '尚未进行菜单更新操作' }}</span></p>
        </div>
    </div>
@endsection

@section('jsContent')
    @if(session('v_menuMsg'))
        <script type="text/javascript">
            alert({{ session('v_menuMsg') }});
        </script>
    @endif
    <script type="text/javascript" src="js/menuList.js"></script>
@endsection