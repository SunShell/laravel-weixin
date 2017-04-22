@extends('layouts.vote')

@section('jsContent')
    <script type="text/javascript" src="{{ asset('/js/detail.js') }}"></script>
@endsection

@section('content')
    <div class="phoneBodyLine">
        <i class="fa fa-clock-o"></i>&nbsp;活动开始时间：{{ substr($vote->startTime,0,10) }}
    </div>

    <div class="phoneBodyLine">
        <i class="fa fa-clock-o"></i>&nbsp;活动结束时间：{{ substr($vote->endTime,0,10) }}
    </div>

    <div class="phoneBodyLine">
        <i class="fa fa-calendar-check-o"></i>&nbsp;投票规则：每个微信每天能投{{ $vote->dayNum }}票，每天可为同一选手投{{ $vote->playerNum }}票
    </div>

    <div class="phoneBodyLine">
        <i class="fa fa-newspaper-o"></i>&nbsp;活动介绍：&nbsp;&nbsp;&nbsp;&nbsp;<i id="detailOp" class="fa fa-angle-double-down"></i>
    </div>

    <div id="detailDiv" class="noShow">
        {!! $vote->detail !!}
    </div>

    <div class="phoneBodyLine phoneBodyOp">
        <a href="/vote/apply/{{ $vote->voteId }}" style="border-right: 1px solid #ffffff;">
            <i class="fa fa-group"></i>&nbsp;我要报名
        </a>
        <a href="/vote/rank/{{ $vote->voteId }}">
            <i class="fa fa-bar-chart"></i>&nbsp;查看排名
        </a>
    </div>

    <div class="input-group" style="margin: 1rem 0;">
        <form id="searchForm" method="post" action="/vote/{{ $vote->voteId }}" style="display: none;">
            {{ csrf_field() }}
            <input type="hidden" id="queryVal" name="queryVal">
        </form>
        <input type="text" class="form-control" id="searchVal" placeholder="请输入选手名称或编号">
        <span class="input-group-btn">
            <button class="btn btn-primary" id="searchBtn">搜索</button>
        </span>
    </div>

    <div class="voteList">
        <form id="voteOpForm" method="post" action="/vote/voteOp/{{ $vote->voteId }}" style="display: none;">
            {{ csrf_field() }}
            <input type="hidden" id="xsId" name="xsId">
        </form>

        <div class="voteListLeft">

            @for($i=0;$i<count($players);$i+=2)
                <div class="voteOne">
                    <div class="voteOneImg">
                        <img src="{{ asset('/storage/voteImages/'.$players[$i]->img) }}">
                    </div>
                    <div class="voteOneTxt">
                        <a href="/vote/one/{{ $players[$i]->voteId.'<>'.$players[$i]->xsId }}">{{ $players[$i]->xsNum.'.'.$players[$i]->name }}</a>
                    </div>
                    <div class="voteOneOp">
                        <div class="voteOneOpDiv">
                            <button class="voteOpBtn btn btn-sm btn-info" data-id="{{ $players[$i]->xsId }}">
                                <i class="fa fa-thumbs-o-up"></i> 投票
                            </button>
                        </div>
                        <div class="voteOneNums">{{ $players[$i]->num }}票</div>
                    </div>
                </div>
            @endfor

        </div>

        <div class="voteListRight">

            @for($i=1;$i<count($players);$i+=2)
                <div class="voteOne">
                    <div class="voteOneImg">
                        <img src="{{ asset('/storage/voteImages/'.$players[$i]->img) }}">
                    </div>
                    <div class="voteOneTxt">
                        <a href="/vote/one/{{ $players[$i]->voteId.'<>'.$players[$i]->xsId }}">{{ $players[$i]->xsNum.'.'.$players[$i]->name }}</a>
                    </div>
                    <div class="voteOneOp">
                        <div class="voteOneOpDiv">
                            <button class="voteOpBtn btn btn-sm btn-info" data-id="{{ $players[$i]->xsId }}">
                                <i class="fa fa-thumbs-o-up"></i> 投票
                            </button>
                        </div>
                        <div class="voteOneNums">{{ $players[$i]->num }}票</div>
                    </div>
                </div>
            @endfor

        </div>

    </div>
@endsection