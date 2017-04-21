<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $vote->name }}-天德网络</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('/css/pcDetail.css') }}">

    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>

    @yield('jsContent')
</head>

<body>
    <div class="topDiv">
        <div class="phoneDiv">
            <div class="phoneHeader"></div>
            <div class="phoneStatus">03:45 PM</div>
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
                </div>
            </div>
            <div class="phoneFooter"></div>
        </div>
    </div>
</body>
</html>