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
    <script type="text/javascript" src="{{ asset('/js/pcDetail.js') }}"></script>
</head>

<body>
    <div class="topDiv">
        <div class="phoneDiv">
            <div class="phoneHeader"></div>
            <div class="phoneStatus">03:45 PM</div>
            <div class="phoneBody">
                <div style="width: 100%;">
                    <img src="{{ asset('/storage/topImages/'.$vote->topImg) }}" style="width: 100%;">
                </div>
                <div class="phoneBodyContainer">
                    <div class="phoneBodyTitle">
                        活动名称：{{ $vote->name }}
                    </div>

                    <div class="phoneBodyLine">
                        <i class="fa fa-clock-o"></i>&nbsp;活动开始时间：{{ substr($vote->startTime,0,10) }}
                    </div>

                    <div class="phoneBodyLine">
                        <i class="fa fa-clock-o"></i>&nbsp;活动结束时间：{{ substr($vote->endTime,0,10) }}
                    </div>

                    <div class="phoneBodyLine">
                        <i class="fa fa-calendar-check-o"></i>&nbsp;投票规则：每个微信每天能投{{ $vote->dayNum }}票，每天可为同一{{ $vote->playerName }}投{{ $vote->playerNum }}票
                    </div>

                    <div class="phoneBodyLine">
                        <i class="fa fa-newspaper-o"></i>&nbsp;活动介绍：&nbsp;&nbsp;&nbsp;&nbsp;<i id="detailOp" class="fa fa-angle-double-down"></i>
                    </div>

                    <div id="detailDiv" class="noShow">
                        {!! $vote->detail !!}
                    </div>
                </div>
            </div>
            <div class="phoneFooter"></div>
        </div>
    </div>
</body>
</html>