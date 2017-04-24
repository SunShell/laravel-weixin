<?php
$js = EasyWeChat::js();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $vote->name }}-铝融网</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/css/detail.css') }}">

    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

    @yield('jsContent')
</head>

<body>
    @if(!session('openid') || session('openid') == 'no')
        <div style="width: 100%;">
            <img src="{{ asset('/storage/topImages/1493021280MMxSk.jpg') }}" style="width: 100%;">
        </div>
    @else
        <div class="phoneBody">
            @yield('topContent')
            <div style="width: 100%;">
                <img src="{{ asset('/storage/topImages/'.$vote->topImg) }}" style="width: 100%;">
            </div>
            <div class="phoneBodyContainer">
                <div class="phoneBodyTitle">
                    活动名称：{{ $vote->name }}
                </div>

                @yield('content')
                <div style="clear: both;"></div>
            </div>
        </div>

        <div class="voteFooter">承办方：铝融网（www.lrw360.com）</div>
    @endif

    @if($res)
        <script type="text/javascript">
            alert('{{ $res }}');
        </script>
    @endif

    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo $js->config(array('onMenuShareTimeline','onMenuShareAppMessage'), false) ?>);

        wx.onMenuShareTimeline({
            title   : '{{ $vote->name }}', // 分享标题
            link    : 'http://www.lvshangwang.com/vote/1493022390JT13lCdFoh', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl  : 'http://www.lvshangwang.com/storage/topImages/14930223905j0mS.jpg', // 分享图标
            success : function () {
                // 用户确认分享后执行的回调函数
                alert('分享成功！');
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });

        wx.onMenuShareAppMessage({
            title   : '{{ $vote->name }}', // 分享标题
            desc    : '',
            link    : 'http://www.lvshangwang.com/vote/1493022390JT13lCdFoh', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl  : 'http://www.lvshangwang.com/storage/topImages/14930223905j0mS.jpg', // 分享图标
            type    : 'link', // 分享类型,music、video或link，不填默认为link
            success : function () {
                // 用户确认分享后执行的回调函数
                alert('分享成功！');
            },
            cancel  : function () {
                // 用户取消分享后执行的回调函数
            }
        });
    </script>
</body>
</html>