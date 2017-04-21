@extends('layouts.votepc')

@section('jsContent')
    <script type="text/javascript" src="{{ asset('/js/pcApply.js') }}"></script>
@endsection

@section('topContent')
    <div class="backDiv">
        <a href="/votes/{{ $vote->voteId }}">&nbsp;<&nbsp;返回</a>
    </div>
@endsection

@section('content')
    <h3 class="voteTitle">详情页</h3>
    <hr>
    <br>
    <div class="oneImg">
        <img src="{{ asset('/storage/voteImages/'.$player->img) }}">
    </div>
    <br>
    <b>姓名：</b>{{ $player->name }}
    <br>
    <b>简介：</b>{{ $player->introduction }}
    <br>
    <br>
    <span class="votesNum">已获投票数：{{ $player->num }}票</span>
    <br>
    <br>
@endsection