
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Minimal and Clean Sign up / Login and Forgot Form by FreeHTML5.co</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FreeHTML5.co" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	

  

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{asset('login/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('login/css/animate.css')}}">
	<link rel="stylesheet" href="{{asset('login/css/style.css')}}">

	<script src="{{asset('login/js/modernizr-2.6.2.min.js')}}"></script>


	</head>
	<body class="style-3">

		<div class="container">
			<div class="row">
				<div class="col-md-4 col-md-push-8">
					<!-- Start Sign In Form -->
					<form action="/registered/sub" method="POST" class="fh5co-form animate-box" data-animate-effect="fadeInRight">
						{{ csrf_field() }}
						<h2>注册</h2>
						<div class="form-group">
							<div class="alert alert-success" role="alert">Your info has been saved.</div>
						</div>
						<div class="form-group">
							<label for="name" class="sr-only">昵称</label>
							<input name="name" type="text" class="form-control" id="name" placeholder="Name" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="email" class="sr-only">邮箱</label>
							<input name="email" type="email" class="form-control" id="email" placeholder="Email" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">密码</label>
							<input name="password" type="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="re-password" class="sr-only">再次输入密码</label>
							<input name="repassword" type="password" class="form-control" id="re-password" placeholder="Re-type Password" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="remember"><input type="checkbox" name="remember" id="remember"> 记住我</label>
						</div>
						<div class="form-group">
							<p>已经有账号？ <a href="/loginUser">登录</a></p>
						</div>
						<div class="form-group">
							<input type="submit" value="注册" class="btn btn-primary">
						</div>
					</form>
					<!-- END Sign In Form -->
				</div>
			</div>
		</div>
	
	<!-- jQuery -->
	<script src="{{asset('login/js/jquery.min.js')}}"></script>
	<!-- Bootstrap -->
	<script src="{{asset('login/js/bootstrap.min.js')}}"></script>
	<!-- Placeholder -->
	<script src="{{asset('login/js/jquery.placeholder.min.js')}}"></script>
	<!-- Waypoints -->
	<script src="{{asset('login/js/jquery.waypoints.min.js')}}"></script>
	<!-- Main JS -->
	<script src="{{asset('login/js/main.js')}}"></script>

	</body>
</html>

