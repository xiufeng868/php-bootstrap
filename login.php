<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/img/favicon.ico">

    <title>LENACastle - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/css/login.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div id="fullscreen_post_bg" class="fullscreen_post_bg">
</div>

<div class="form-signin">
    <h1 class="form-signin-heading">LENACastle</h1>
    <input id="username" type="text" class="form-control" placeholder="账户" autofocus>
    <input id="password" type="password" class="form-control" placeholder="密码">
    <div id="alert" class="alert alert-dismissable alert-danger"><span></span></div>
    <a id="btn_submit" class="btn btn-primary btn-block" role="button">登 陆</a>
</div>

<!-- Bootstrap core JavaScript -->
<script src="http://cdn.bootcss.com/jquery/2.0.3/jquery.min.js"></script>
<!-- Placed at the end of the document so the pages load faster -->
</body>
</html>

<script type="text/javascript">
    $(function() {
        $("#btn_submit").click(function() {
            signin();
        });

        $("body").bind('keyup', function(event) {
            if (event.keyCode == 13) {
                signin();
            }
        });
    });

    function checkform() {
        var username = $("#username");
        if (username.val() == '') {
            username.focus();
            myAlert("请输入账户.");
            return false;
        }
        var password = $("#password");
        if (password.val() == '') {
            password.focus();
            myAlert("请输入密码.");
            return false;
        }
        return true;
    }

    function myAlert(msg) {
        $("#alert span").html(msg);
        $("#alert").slideDown("fast");
        setTimeout('$("#alert").slideUp("fast");', 3000);
    }

    function signin() {
        if (!checkform()) return false;
        $.post("/ajax/ajax_login.php",
            {
                username: $("#username").val(),
                password: $("#password").val()
            },
            function(result) {
                if (1 == result) {
                    location.href = "/";
                } else if (0 == result) {
                    myAlert("用户名或密码错误.");
                } else {
                    myAlert(result);
                }
            }
        );
    }
</script>

