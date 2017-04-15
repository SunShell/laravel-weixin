<div class="blog-masthead">
    <div class="container">
        <nav class="nav blog-nav">
            @if($activeVal == 'voteList')
                <a class="nav-link active" href="/">投票列表</a>
                <a class="nav-link" href="/create">创建投票</a>
            @else
                <a class="nav-link" href="/">投票列表</a>
                <a class="nav-link active" href="/create">创建投票</a>
            @endif

            <a class="nav-link ml-auto" href="#">欢迎您：{{ Auth::user()->name }}</a>
            <a class="nav-link" href="/logout">[&nbsp;退出&nbsp;]</a>
        </nav>
    </div>
</div>