<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/img/favicon.ico">

    <title>LENACastle</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/cyborg.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- Wrap all page content here -->
<div id="wrap">
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">LENACastle</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul id="myNav" class="nav navbar-nav">
                    <li id="nav1"><a href="/account/payment.php">支出</a></li>
					<li id="nav4"><a href="/account/receipt.php">收入</a></li>
					<li id="nav5"><a href="#">理财</a></li>
                    <li id="nav2"><a href="#">统计</a></li>
                    <li id="nav3" class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">系统管理 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/system/codegroup.php">编码组</a></li>
                            <li><a href="/system/code.php">编码</a></li>
                            <li class="divider"></li>
                            <li><a href="#">设置</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a><?php echo $_SESSION['username']; ?></a></li>
                    <li><a href="/logout.php">退出</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>