<?php
$pageArr = explode('<@>', $mType);
$pageId = $pageArr[1];

$totalPage = ceil($totalNum/$pageNum) + ($totalNum === 0 ? 1 : 0);

$pNum = $pageId - 1;
if($pNum < 1) $pNum = 1;

$nNum = $pageId + 1;
if($nNum > $totalPage) $nNum = $totalPage;

$pI = $pageId - 2;
if($pI < 1) $pI = 1;

$nI = $pageId + 2;
if($nI > $totalPage) $nI = $totalPage;
?>
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
        .nowPage {
            border-color: #229ffd;
            background: #229ffd;
        }
    </style>

    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('/js/arSel.js') }}"></script>
</head>

<body>
    <!--表格-->
    <table class="table table-hover">
        <thead style="background-color: #faebcc;">
        <tr>
            <th class="text-center" width="75%">标题</th>
            <th class="text-center">操作</th>
        </tr>
        </thead>

        <tbody>
        @foreach($lists as $list)
        <tr>
            @if($pageArr[0] == '1')
                <td>{{ $list->name }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary btnSel" data-str="{{ $list->name.chr(2).$list->media_id }}">选择</button>
                </td>
            @elseif($pageArr[0] == '2')
                <td>{{ $list->content->news_item[0]->title }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary btnSel" data-str="{{ $list->content->news_item[0]->title.chr(2).$list->media_id }}">选择</button>
                </td>
            @else
                <td>{{ $list->name }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-primary btnSel" data-str="{{ $list->name.chr(2).$list->voteId.chr(2).$list->topImg }}">选择</button>
                </td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>

    <!--翻页工具条-->
    <div class="container text-center">
        <a href="/autoReply/sel/{{ $pageArr[0].'<@>1' }}" class="btn btn-sm btn-primary" title="首页"><i class="fa fa-angle-double-left"></i></a>&nbsp;
        <a href="/autoReply/sel/{{ $pageArr[0].'<@>'.$pNum }}" class="btn btn-sm btn-primary" title="上一页"><i class="fa fa-angle-left"></i></a>&nbsp;
        @for($i=$pI;$i<=$nI;$i++)
            @if($i == $pageId)
                <a href="/autoReply/sel/{{ $pageArr[0].'<@>'.$i }}" class="btn btn-sm btn-primary nowPage">{{ $i }}</a>&nbsp;
            @else
                <a href="/autoReply/sel/{{ $pageArr[0].'<@>'.$i }}" class="btn btn-sm btn-primary">{{ $i }}</a>&nbsp;
            @endif
        @endfor
        <a href="/autoReply/sel/{{ $pageArr[0].'<@>'.$nNum }}" class="btn btn-sm btn-primary" title="下一页"><i class="fa fa-angle-right"></i></a>&nbsp;
        <a href="/autoReply/sel/{{ $pageArr[0].'<@>'.$totalPage }}" class="btn btn-sm btn-primary" title="末页"><i class="fa fa-angle-double-right"></i></a>
    </div>
</body>
</html>