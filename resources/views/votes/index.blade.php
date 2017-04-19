@extends('layouts.master')

@section('content')
    <div class="container votesList">
        <div class="container votesListTop">
            <form method="post" action="/delete" class="form-inline" id="delForm" style="float: left;">
                {{ csrf_field() }}

                <input type="hidden" id="voteIds" name="voteIds">

                <button type="button" class="btn btn-danger" id="batchDel"><i class="fa fa-times"></i>&nbsp;删除</button>
            </form>

            <form method="post" action="/" class="form-inline" style="float: right;">
                <div class="form-group">
                    {{ csrf_field() }}

                    <input type="text" class="form-control" id="voteName" name="voteName" placeholder="请输入活动名称" value="{{ $voteName }}">
                </div>
                &nbsp;&nbsp;
                <button type="submit" class="btn btn-primary">查询</button>
            </form>
        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                <th class="text-center" width="5%"><input type="checkbox" class="checkAll"></th>
                <th class="text-center" width="30%">活动名称</th>
                <th class="text-center" width="25%">开始时间</th>
                <th class="text-center" width="25%">结束时间</th>
                <th class="text-center">操作</th>
            </tr>
            </thead>

            <tbody>
            @foreach($votes as $vote)
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="checkOne" data-id="{{ $vote->voteId }}">
                </td>
                <td>
                    <a class="voteLink" href="/votes/{{ $vote->voteId }}" target="_blank">{{ $vote->name }}</a>
                </td>
                <td class="text-center">
                    {{ substr($vote->startTime,0,10) }}
                </td>
                <td class="text-center">
                    {{ substr($vote->endTime,0,10) }}
                </td>
                <td class="text-center votesOperation">
                    <i class="fa fa-pencil" title="修改" data-id="{{ $vote->voteId }}"></i>
                    &nbsp;
                    <i class="fa fa-times" title="删除" data-id="{{ $vote->voteId }}"></i>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('jsContent')
    <script type="text/javascript" src="js/voteList.js"></script>
@endsection