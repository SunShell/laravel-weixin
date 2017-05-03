@extends('layouts.master')

@section('content')
    <div class="container votesList">
        <input type="hidden" id="theToken" value="{{ csrf_token() }}">
        <div class="container votesListTop">
            <input type="text" class="form-control col-4" id="keyword" style="float: left;" placeholder="请输入关键词">&nbsp;&nbsp;
            <button type="button" class="btn btn-primary" id="kwdQuery"><i class="fa fa-search"></i> 查询</button>&nbsp;&nbsp;
            <button type="button" class="btn btn-success" id="kwdAdd"><i class="fa fa-plus"></i> 添加</button>&nbsp;
            <button type="button" class="btn btn-danger" id="batchDel"><i class="fa fa-times"></i> 删除</button>&nbsp;
            <button type="button" class="btn btn-info" id="mrOp"><i class="fa fa-mail-forward"></i> 默认回复</button>&nbsp;
            <button type="button" class="btn btn-info" id="gzOp"><i class="fa fa-info-circle"></i> 关注回复</button>

        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center" width="5%"><input type="checkbox" class="checkAll"></th>
                    <th class="text-center" width="20%">关键词</th>
                    <th class="text-center" width="20%">回复类型</th>
                    <th class="text-center" width="40%">回复内容</th>
                    <th class="text-center">操作</th>
                </tr>
            </thead>

            <tbody></tbody>
        </table>

        <div class="container pageBar"></div>
    </div>

    <div id="addDiv" class="notShow">
    <form class="arAddForm" method="post" action="/autoReply/store">
        {{ csrf_field() }}

        <div class="form-group row arType-all">
            <label for="arKeyword" class="col-3 col-form-label">关键词：</label>
            <div class="col-9">
                <input class="form-control" type="text" placeholder="关键词" id="arKeyword" name="arKeyword">
            </div>
        </div>

        <div class="form-group row arType-all">
            <label for="arType" class="col-3 col-form-label">回复类型：</label>
            <div class="col-9">
                <select class="custom-select" id="arType" name="arType">
                    <option value="0">文字</option>
                    <option value="1">素材图片</option>
                    <option value="2">素材文章</option>
                    <option value="3">投票</option>
                    <option value="4">图文消息</option>
                </select>
            </div>
        </div>

        <div class="form-group row arType-0">
            <label for="arContent" class="col-3 col-form-label">回复内容：</label>
            <div class="col-9">
                <textarea id="arContent" name="arContent" class="form-control" rows="5" placeholder="回复内容"></textarea>
            </div>
        </div>

        <div class="form-group row arType-1 arType-2 arType-3 notShow">
            <label for="arSelect" class="col-3 col-form-label">素材选择：</label>
            <div class="col-9">
                <input class="form-control col-8" type="text" placeholder="请选择" id="arSelect" name="arSelect" style="float: left;" readonly>
                <button type="button" class="btn btn-success" id="arSelectBtn" style="float: left; margin-left: 10px;">选择</button>
            </div>
        </div>

        <div class="form-group row arType-3 arType-4 notShow">
            <label for="arMtitle" class="col-3 col-form-label">消息标题：</label>
            <div class="col-9">
                <input class="form-control" type="text" placeholder="消息标题" id="arMtitle" name="arMtitle">
            </div>
        </div>

        <div class="form-group row arType-3 arType-4 notShow">
            <label for="arMdescription" class="col-3 col-form-label">消息描述：</label>
            <div class="col-9">
                <input class="form-control" type="text" placeholder="消息描述" id="arMdescription" name="arMdescription">
            </div>
        </div>

        <div class="form-group row arType-4 notShow">
            <label for="arMurl" class="col-3 col-form-label">消息URL：</label>
            <div class="col-9">
                <input class="form-control" type="text" placeholder="消息URL" id="arMurl" name="arMurl">
            </div>
        </div>

        <div class="form-group row arType-4 notShow">
            <label for="arMimage" class="col-3 col-form-label">消息图片：</label>
            <div class="col-9">
                <input class="form-control" type="text" placeholder="消息图片地址" id="arMimage" name="arMimage">
            </div>
        </div>

        <button type="button" class="btn btn-block btn-primary" id="addBtn">添 加</button>
    </form>
    </div>
@endsection

@section('jsContent')
    <script type="text/javascript" src="js/arList.js"></script>
@endsection