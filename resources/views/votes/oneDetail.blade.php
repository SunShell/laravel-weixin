@extends('layouts.vote')

@section('jsContent')
    <script type="text/javascript" src="{{ asset('/js/oneDetail.js') }}"></script>
@endsection

@section('topContent')
    <div class="backDiv">
        <a href="/vote/{{ $vote->voteId }}">&nbsp;<&nbsp;返回投票页</a>
    </div>
@endsection

@section('content')
    <form id="voteOpForm" method="post" action="/vote/voteOp/{{ $vote->voteId }}" style="display: none;">
        {{ csrf_field() }}
        <input type="hidden" id="xsId" name="xsId">
        <input type="hidden" id="isOne" name="isOne" value="yes">
    </form>

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
    <button class="voteOpBtn btn btn-sm btn-info" data-id="{{ $player->xsId }}">
        <i class="fa fa-thumbs-o-up"></i> 为TA投票
    </button>
    <br>
    <br>
@endsection