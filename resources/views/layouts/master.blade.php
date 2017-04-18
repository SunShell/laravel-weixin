<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>公众号投票系统-天德网络</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">

    @if($activeVal == 'voteForm')
        <link rel="stylesheet" href="css/calendar.css">
        <link rel="stylesheet" href="lib/umeditor/themes/default/css/umeditor.css">
    @endif

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/votes.css">

    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    @if($activeVal == 'voteForm')
        <script src="js/calendar.js"></script>
        <script type="text/javascript" src="lib/umeditor/third-party/template.min.js"></script>
        <script type="text/javascript" src="lib/umeditor/umeditor.config.js"></script>
        <script type="text/javascript" src="lib/umeditor/umeditor.js"></script>
        <script type="text/javascript" src="lib/umeditor/lang/zh-cn/zh-cn.js"></script>
    @endif
</head>

<body>
    @include('layouts.nav')

    <div class="blog-header">
        <div class="container">
            <h1 class="blog-title">公众号投票系统</h1>
            <p class="lead blog-description">适用于微信公众号关注后的投票。</p>
        </div>
    </div>

    @yield('content')

    @include('layouts.footer')

    @yield('jsContent')
</body>
</html>