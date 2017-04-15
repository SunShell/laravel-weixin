<!doctype html>
<html>
<he>
    <meta charset="utf-8">
    <title>登录-天德网络</title>

    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container col-lg-3 loginTop">
        <h1>公众号投票系统</h1>

        <form method="post" action="/login">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">用户名</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="用户名" autofocus required>
            </div>

            <div class="form-group">
                <label for="password">密码</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="密码" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-success btn-block">登&nbsp;录</button>
            </div>

            @include('layouts.errors')
        </form>
    </div>

    <img class="logoImg" src="images/logo.png">
</body>
</html>