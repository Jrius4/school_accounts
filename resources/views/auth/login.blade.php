@extends('layouts.dashboard')
@section('content')

		<!-- Breadcome start-->
		<div class="breadcome-area mg-b-30 small-dn">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="breadcome-list shadow-reset">
							<div class="row">
								<div class="col-lg-6">
									<div class="breadcome-heading">
										<h2>WELCOME TO FRIENDS ACADEMY KATENDE</h2>
									</div>
								</div>
								<div class="col-lg-6">
									<ul class="breadcome-menu">
										<li>Home<span class="bread-slash">/</span>
										</li>
										<li>Login</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcome End-->
		<!--            Mobile view start-->
		<!-- Breadcome start-->
		<div class="breadcome-area mg-b-30 des-none">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="breadcome-list map-mg-t-40-gl shadow-reset">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div class="breadcome-heading">
										<h2>FRIENDS ACADEMY KATENDE</h2>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<ul class="breadcome-menu">
										<li><a href="#">Home</a> <span class="bread-slash">/</span>
										</li>
										<li><span class="bread-blod">Login</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcome End-->
		<!--            mobile view end-->
		<!-- login Start-->
		<div class="login-form-area mg-t-30 mg-b-1000">
			<div class="form admin-panel-content animated bounce tab-pane fade in animated zoomInDown shadow-reset active">
				<div class="row">
					<div class="col-lg-2">

					</div>

					<div class="col-lg-4">
						<div class="login-bg">
							<div class="row">
								<div class="col-lg-12">
									<div class="logo">
										<a href="#"><img src="{{asset('schools/img/logo/log.png')}}" alt="" />
                                                </a>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="login-title">
										<h1>Student/Parent</h1>

									    {{-- some code --}}
									</div>
								</div>
							</div>
							<form method="post" action="{{ route("login.student") }}" class="adminpro-form">
                                    @csrf
							<div class="row">
								<div class="col-lg-4">
									<div class="login-input-head">
										<p>Roll No.</p>
									</div>
								</div>
								<div class="col-lg-8">
									<div class="login-input-area">
										<input type="text" autocomplete="off" name="roll_number" required/>
										<i class="fa fa-credit-card login-user" aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <input type="hidden" name="password" value="student">
                                    </div>
									<div class="row">
										<div class="col-lg-12">
											<div class="forgot-password">
												<a href="#"></a>
											</div>
										</div>
									</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="login-keep-me">
													<label class="checkbox">
                                                            <input type="checkbox" name="remember" ><i></i>Remember Me
                                                        </label>

												</div>
											</div>
										</div>
								</div>

								<div class="col-lg-4">

								</div>
								<div class="col-lg-8">
									<div class="login-button-pro">
										<button type="submit" class="login-button login-button-lg">Login</button>
									</div>
								</div>
							</div>
							</form>
						</div>

					</div>


						<div class="col-lg-4">
							<div class="login-bg">
								<div class="row">
									<div class="col-lg-12">
										<div class="logo">
											<a href="#"><img src="{{asset('schools/img/logo/log.png')}}" alt="" />
                                                </a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<div class="login-title">
											<h1>Administration</h1>
                                              {{-- some code --}}
                                              {{-- <h3 style="color:white">{{ isset($url) ? ucwords($url) : ""}} {{ __('Login') }}</h3> --}}
										</div>
									</div>
                                </div>
                                {{-- @isset($url)
                                    <form class="adminpro-form" method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
                                @else
                                    <form class="adminpro-form" method="POST" action='{{ url("login") }}' aria-label="{{ __('Login') }}">
                                @endisset --}}
                                <form class="adminpro-form" method="POST" action='{{ url("/") }}' aria-label="{{ __('Login') }}">

                                    @csrf
								<div class="row">
									<div class="col-lg-4">
										<div class="login-input-head">
											<p>{{_('Username')}}</p>
										</div>
									</div>
									<div class="col-lg-8">

                                            <div class="login-input-area col-12">
                                                    <input id="username" type="text" class="@error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus/>
                                                <i class="fa fa-user login-user" aria-hidden="true"></i>
                                            </div>

                                        <div class="col-12">
                                            @error('username')
                                                <span class="invalid-feedback text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="login-input-head">
											<p>Password</p>
										</div>
									</div>
									<div class="col-lg-8">
										<div class="login-input-area">
											<input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>
											<i class="fa fa-lock login-user"></i>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback  text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
										<div class="row">
											<div class="col-lg-12">
												<div class="forgot-password">
													<a href="#">Forgot password?</a>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="login-keep-me">
													<label class="checkbox">
                                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} ><i></i>Keep me logged in
                                                        </label>

												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">

									</div>
									<div class="col-lg-8">
										<div class="login-button-pro">
											<button name="adminsubmit" class="login-button login-button-lg" type="submit">Log in</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="col-lg-2">
					</div>
				</div>
			</div>
		</div>
		<!-- login End-->

@endsection
