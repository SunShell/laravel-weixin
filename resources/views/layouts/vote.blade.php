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
</body>
</html>