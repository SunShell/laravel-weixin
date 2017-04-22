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
    <form class="voteApply" method="post" enctype="multipart/form-data" action="/votes/apply/{{ $vote->voteId }}">
        {{ csrf_field() }}

        <h3 class="voteTitle">我要报名</h3>
        <hr>

        <div class="form-group">
            <label for="name">选手名称</label>
            <input type="text" class="form-control" id="name" name="name" tip="选手名称">
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
@endsection