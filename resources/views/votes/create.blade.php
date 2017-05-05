@extends('layouts.master')

@section('content')
    <div id="startTimeDiv"></div>
    <div id="endTimeDiv"></div>

    <div class="container">
        <form class="voteForm" method="post" enctype="multipart/form-data" action="/create">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">活动名称</label>
                <input type="text" class="form-control col-6" id="name" name="name" tip="活动名称">
            </div>

            <div class="form-group">
                <label for="startTime">开始时间</label>
                <input type="text" class="form-control col-6" id="startTime" name="startTime" tip="开始时间" readonly>
            </div>

            <div class="form-group">
                <label for="endTime">结束时间</label>
                <input type="text" class="form-control col-6" id="endTime" name="endTime" tip="结束时间" readonly>
            </div>

            <div class="form-group">
                <label for="playerName">选手称谓</label>
                <input type="text" class="form-control col-6" id="playerName" name="playerName" tip="选手称谓">
            </div>

            <div class="form-group">
                <label>投票类型</label>

                <div>
                    <label>
                        <input type="radio" name="voteType" id="voteType1" value="0" checked>
                        单选
                    </label>
                    &nbsp;&nbsp;
                    <label>
                        <input type="radio" name="voteType" id="voteType2" value="1">
                        多选
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="dayNum">每个微信可投票数</label>
                <input type="text" class="form-control col-6" id="dayNum" name="dayNum" tip="每个微信可投票数">
            </div>

            <div class="form-group">
                <label for="playerNum">每个微信可为同一选手投票数</label>
                <input type="text" class="form-control col-6" id="playerNum" name="playerNum" tip="每个微信可为同一选手投票数">
            </div>

            <div class="form-group">
                <label>每天投票</label>

                <div>
                    <label>
                        <input type="radio" name="isDaily" id="isDaily1" value="1" checked>
                        启用
                    </label>
                    &nbsp;&nbsp;
                    <label>
                        <input type="radio" name="isDaily" id="isDaily2" value="0">
                        禁用
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>选手报名</label>

                <div>
                    <label>
                        <input type="radio" name="isPublic" id="isPublic1" value="1" checked>
                        启用
                    </label>
                    &nbsp;&nbsp;
                    <label>
                        <input type="radio" name="isPublic" id="isPublic2" value="0">
                        禁用
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>宣传图片</label>

                <div>
                    <input type="file" class="form-control col-6" id="topImg" name="topImg" tip="宣传图片">
                </div>
            </div>

            <div class="form-group">
                <label>未关注显示图片</label>

                <div>
                    <input type="file" class="form-control col-6" id="followImg" name="followImg" tip="未关注显示图片">
                </div>
            </div>

            <div class="form-group">
                <label>活动介绍</label>

                <div style="width: 100%; height: 300px;">
                    <script id="detail" name="detail" type="text/plain"></script>
                </div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-success" id="saveBtn">提交</button>
            </div>

            @include('layouts.errors')
        </form>
    </div>
@endsection

@section('jsContent')
    <script type="text/javascript" src="js/addVote.js"></script>
@endsection