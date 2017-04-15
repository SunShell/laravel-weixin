@extends('layouts.master')

@section('content')
    <div class="container">
        <form class="voteForm" method="post" action="/create">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">活动名称</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="活动名称" required>
            </div>

            <div class="form-group">
                <label for="startTime">开始时间</label>
                <input type="text" class="form-control" id="startTime" name="startTime" placeholder="开始时间" required>
            </div>

            <div class="form-group">
                <label for="endTime">结束时间</label>
                <input type="text" class="form-control" id="endTime" name="endTime" placeholder="结束时间" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">提交</button>
            </div>

            @include('layouts.errors')
        </form>
    </div>
@endsection

@section('jsContent')
    <script type="text/javascript" src="js/addVote.js"></script>
@endsection