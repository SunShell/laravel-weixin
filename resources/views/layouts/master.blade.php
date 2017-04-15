<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>公众号投票系统-天德网络</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/votes.css">

    <script src="https://cdn.bootcss.com/jquery/3.1.1/jquery.slim.min.js"></script>
    <script src="https://cdn.bootcss.com/tether/1.4.0/js/tether.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
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