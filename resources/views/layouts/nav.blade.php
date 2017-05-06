<div class="blog-masthead">
    <div class="container">
        <nav class="nav blog-nav">
            @if($activeVal == 'voteList')
                <a class="nav-link active" href="/">投票列表</a>
                <a class="nav-link" href="/create">创建投票</a>
                <a class="nav-link" href="/autoReply">自动回复</a>
                <a class="nav-link" href="/menuList">自定义菜单</a>
            @elseif($activeVal == 'voteForm')
                <a class="nav-link" href="/">投票列表</a>
                <a class="nav-link active" href="/create">创建投票</a>
                <a class="nav-link" href="/autoReply">自动回复</a>
                <a class="nav-link" href="/menuList">自定义菜单</a>
            @elseif($activeVal == 'arList')
                <a class="nav-link" href="/">投票列表</a>
                <a class="nav-link" href="/create">创建投票</a>
                <a class="nav-link active" href="/autoReply">自动回复</a>
                <a class="nav-link" href="/menuList">自定义菜单</a>
            @else
                <a class="nav-link" href="/">投票列表</a>
                <a class="nav-link" href="/create">创建投票</a>
                <a class="nav-link" href="/autoReply">自动回复</a>
                <a class="nav-link active" href="/menuList">自定义菜单</a>
            @endif

            <a class="nav-link ml-auto" href="#">欢迎您：{{ Auth::user()->name }}</a>
            <a class="nav-link" href="/logout">[&nbsp;退出&nbsp;]</a>
        </nav>
    </div>
</div>