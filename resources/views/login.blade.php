
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>登录</title>
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
					<form action="/login_sub" method="post" class="fh5co-form animate-box" data-animate-effect="fadeInRight">
						{{ csrf_field() }}
						<h2>登录</h2>
						<div class="form-group">
							<label for="username" class="sr-only">用户邮箱</label>
							<input name="email" type="text" class="form-control" id="email" placeholder="email" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">密码</label>
							<input name="password" type="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
						</div>
						<div class="form-group">
							<label name="remember" for="remember"><input type="checkbox" id="remember"> 记住我</label>
						</div>
						<div class="form-group">
							<p>噢！还没注册？<a href="/registered">注册</a></p>
						</div>
						<div class="form-group">
							<input type="submit" value="Sign In" class="btn btn-primary">
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

