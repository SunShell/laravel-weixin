<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>公众号投票系统-天德网络</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        .menuAddForm {
            padding: 1rem;
        }

        .notShow {
            display: none;
        }
    </style>

    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('/lib/layer/layer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/menuAdd.js') }}"></script>
</head>

<body>
<form class="menuAddForm" method="post" action="/menuList/store">
    {{ csrf_field() }}

    <div class="form-group row menuType-all">
        <label for="menuName" class="col-3 col-form-label">菜单名称：</label>
        <div class="col-9">
            <input class="form-control" type="text" placeholder="菜单名称" id="menuName" name="menuName">
        </div>
    </div>

    <div class="form-group row menuType-all">
        <label for="menuLevel" class="col-3 col-form-label">菜单等级：</label>
        <div class="col-9">
            <select class="custom-select" id="menuLevel" name="menuLevel" tip="菜单等级">
                <option value="1">一级</option>
                <option value="2">二级</option>
            </select>
        </div>
    </div>

    <div class="form-group row menuType-all menuLevelOne notShow">
        <label for="levelOne" class="col-3 col-form-label">所属菜单：</label>
        <div class="col-9">
            <select class="custom-select" id="levelOne" name="levelOne" tip="所属菜单">
                @if(count($levelOnes))
                    @foreach($levelOnes as $levelOne)
                        <option value="{{ $levelOne->nodeId }}">{{ $levelOne->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="form-group row menuType-all">
        <label for="menuType" class="col-3 col-form-label">菜单类型：</label>
        <div class="col-9">
            <select class="custom-select" id="menuType" name="menuType" tip="菜单类型">
                <option value="parent">父菜单</option>
                <option value="view">URL</option>
                <option value="click">自动回复</option>
            </select>
        </div>
    </div>

    <div class="form-group row menuType-view arType-all notShow">
        <label for="menuContent" class="col-3 col-form-label">URL：</label>
        <div class="col-9">
            <input class="form-control" type="text" placeholder="URL" id="menuContent" name="menuContent">
        </div>
    </div>

    <div class="form-group row menuType-click arType-all notShow">
        <label for="arType" class="col-3 col-form-label">回复类型：</label>
        <div class="col-9">
            <select class="custom-select" id="arType" name="arType" tip="回复类型">
                <option value="0">文字</option>
                <option value="1">素材图片</option>
                <option value="2">素材文章</option>
                <option value="3">投票</option>
                <option value="4">图文消息</option>
            </select>
        </div>
    </div>

    <div class="form-group row arType-0 notShow">
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
</body>
</html>