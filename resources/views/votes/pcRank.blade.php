@extends('layouts.votepc')

@section('topContent')
    <div class="backDiv">
        <a href="/votes/{{ $vote->voteId }}">&nbsp;<&nbsp;返回</a>
    </div>
@endsection

@section('content')
    <h3 class="voteTitle">查看排名</h3>
    <hr>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>排名</th>
            <th>微信昵称</th>
            <th>选手名称</th>
            <th>票数</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($players);$i++)
        <tr>
            <th>{{ $i+1 }}</th>
            <td>{{ session('v_userInfo')[$players[$i]->xsId] }}</td>
            <td>{{ $players[$i]->name }}</td>
            <td>{{ $players[$i]->num }}</td>
        </tr>
        @endfor
        </tbody>
    </table>
@endsection