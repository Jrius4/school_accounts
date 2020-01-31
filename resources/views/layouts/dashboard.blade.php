{{-- some code  --}}
<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Friends academy katende</title>
	<meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- favicon
		============================================ -->
	<link rel="shortcut icon" type="image/x-icon" href="{{asset('schools/img/favicon.ico')}}">
	<!-- Google Fonts
		============================================ -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet">
	<!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('schools/css/bootstrap.min.css')}}">

	<!-- Bootstrap CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/css/font-awesome.min.css')}}">
	<!-- adminpro icon CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/css/adminpro-custon-icon.css')}}">
	<!-- meanmenu icon CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/css/meanmenu.min.css')}}">
	<!-- mCustomScrollbar CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/css/jquery.mCustomScrollbar.min.css')}}">
	<!-- animate CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/css/animate.css')}}">
	<!-- normalize CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/css/normalize.css')}}">
	<!-- form CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/css/form.css')}}">
	<!-- style CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/style.css')}}">
	<!-- responsive CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/css/responsive.css')}}">
	<!-- modernizr JS
		============================================ -->
    <script src="{{asset('schools/js/vendor/modernizr-2.8.3.min.js')}}"></script>
    <script src="{{asset('schools/js/vendor/jquery-1.11.3.min.js')}}"></script>
    <style>
        .center-contents{
            display: block;
            align-content: center;
            padding: 2vw;
            margin: auto 15vw;
        }
        .form-details{
            background: #464343;

        }
        .py{
            padding-bottom: 5px;
        }
        .school-form{
            margin: 5vw 15vw;
            background: #0e0d0d;
            padding: 8pt;
        }
        .panel{
            background: #313131 !important;
            border:#313131 !important;
        }
        .center-form{
            display: flex;
            justify-content: center;
            padding: 2vw
        }
        </style>
    @yield('style')
    @yield('first-scripts')
</head>

<body class="darklayout">
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="{http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
	<!-- Header top area start-->
	<div class="wrapper-pro">
            @yield('content')

<!-- Footer Start-->
		<div class="container-fluid" style="margin-top: 20px;">
			<div class="row">
				<div class="col-lg-12">
					<div class="footer-copy-right">
						<p>Copyright &#169; {{date('Y')}} Ntechnology All rights reserved. Developed by <a href="https://Ntechnology.co.ug"><span style="color: aqua">Ntechnology</span></a>.</p>
					</div>
				</div>
            </div>
		</div>
    <!-- Footer End-->


	</div>

	<!-- jquery
		============================================ -->

	<!-- bootstrap JS
		============================================ -->
	<script src="{{asset('schools/js/bootstrap.min.js')}}"></script>
	<!-- meanmenu JS
		============================================ -->
	<script src="{{asset('schools/js/jquery.meanmenu.js')}}"></script>
	<!-- mCustomScrollbar JS
		============================================ -->
	<script src="{{asset('schools/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
	<!-- sticky JS
		============================================ -->
	<script src="{{asset('schools/js/jquery.sticky.js')}}"></script>
	<!-- scrollUp JS
		============================================ -->
	<script src="{{asset('schools/js/jquery.scrollUp.min.js')}}"></script>
	<!-- form validate JS
		============================================ -->
	<script src="{{asset('schools/js/jquery.form.min.js')}}"></script>
	<script src="{{asset('schools/js/jquery.validate.min.js')}}"></script>
	<script src="{{asset('schools/js/form-active.js')}}"></script>
	<!-- main JS
		============================================ -->
    <script src="{{asset('schools/js/main.js')}}"></script>
    @yield('scripts')
</body>

</html>
