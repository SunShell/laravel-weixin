@extends('layouts.vote')

@section('topContent')
    <div class="backDiv">
        <a href="/vote/{{ $vote->voteId }}">&nbsp;<&nbsp;返回投票页</a>
    </div>
@endsection

@section('content')
    <h3 class="voteTitle">查看排名</h3>
    <hr>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>排名</th>
            <th>编号</th>
            <th>选手名称</th>
            <th>票数</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($players);$i++)
            <tr>
                <th>{{ $i+1 }}</th>
                <td>{{ $players[$i]->xsNum }}</td>
                <td>{{ $players[$i]->name }}</td>
                <td>{{ $players[$i]->num }}</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection