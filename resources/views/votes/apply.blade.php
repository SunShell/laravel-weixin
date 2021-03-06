@extends('layouts.vote')

@section('jsContent')
    <script type="text/javascript" src="{{ asset('/js/apply.js') }}"></script>
@endsection

@section('topContent')
    <div class="backDiv">
        <a href="/vote/{{ $vote->voteId }}">&nbsp;<&nbsp;返回投票页</a>
    </div>
@endsection

@section('content')
    @if($flag == '0')
        <form class="voteApply" method="post" enctype="multipart/form-data" action="/vote/apply/{{ $vote->voteId }}">
            {{ csrf_field() }}

            <h3 class="voteTitle">我要报名</h3>
            <hr>

            <div class="form-group">
                <label for="name">{{ $vote->playerName }}名称</label>
                <input type="text" class="form-control" id="name" name="name" tip="{{ $vote->playerName }}名称">
            </div>

            <div class="form-group">
                <label for="introduction">一句话介绍</label>
                <input type="text" class="form-control" id="introduction" name="introduction" tip="一句话介绍">
            </div>

            <div class="form-group">
                <label>上传{{ $vote->playerName }}照片</label>
                <div>
                    <input type="file" class="form-control" id="img" name="img" tip="{{ $vote->playerName }}照片">
                </div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-success btn-block" id="saveBtn">报名</button>
            </div>
        </form>
    @else
        <div style="margin-top: 1rem;">
            @if($flag == '1')
                <div class="alert alert-info">您已经成功报名，审核通过之后将在投票页展示！</div>
            @elseif($flag == '2')
                <div class="alert alert-success">恭喜您，报名成功，赶紧点击右上角分享给好友来给您投票吧！</div>
            @elseif($flag == '3')
                <div class="alert alert-danger">活动尚未开始！</div>
            @else
                <div class="alert alert-danger">活动已经结束！</div>
            @endif
        </div>
    @endif
@endsection