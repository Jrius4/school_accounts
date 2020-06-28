<div class="left-sidebar-pro">
	<nav id="sidebar">
		<div class="sidebar-header">
			<a href="#"><img src="{{asset('schools/img/message/1.jpg')}}" alt="" />
                    </a>
			<h4>We Achieve<br> Because<br> We Believe We Can</h4>
		</div>
		<div class="left-custom-menu-adp-wrap">
			<ul class="nav navbar-nav left-sidebar-menu-pro">

				<li class="nav-item">
					<a href="{{url('/')}}"  class="nav-link "><i class="fa big-icon fa-dashboard"></i> <span class="mini-dn">Dashboard</span></a>
                </li>
                @if (Auth::user()->hasRole('head_teacher'))
                    @include('layouts.staff-navs.headmaster')
                @endif
                @if (Auth::user()->hasRole('academic'))
                    @include('layouts.staff-navs.academics')
                @endif
                @if (Auth::user()->hasRole('teacher'))
                    @include('layouts.staff-navs.teacher')
                @endif

                @if (false)


				<li class="nav-item">
					<a href="{{route('expenses.index')}}" class="nav-link dropdown-toggle"><i class="fa big-icon fa-file-text-o"></i> <span class="mini-dn">Manage Expenses</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-money"></i> <span class="mini-dn">Account</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                        <a href="{{route('accounts.school-accounts.create')}}" class="dropdown-item">Create Account</a>
                    <a href="{{route('accounts.school-accounts.index')}}" class="dropdown-item">Manage Account</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-money"></i> <span class="mini-dn">Students</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                        <a href="{{route('register.student')}}" class="dropdown-item">Register Student</a>
                    <a href="{{url('student/a-level')}}" class="dropdown-item">Manage A-levels Students</a>
                    <a href="{{url('student/o-level')}}" class="dropdown-item">Manage O-levels Students</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-money"></i> <span class="mini-dn">Inflows</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                        <a href="{{route('accounts.inflows.create')}}" class="dropdown-item">Add Inflow</a>
                    <a href="{{route('accounts.inflows.index')}}" class="dropdown-item">Manage Infows</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-money"></i> <span class="mini-dn">Outflows</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                        <a href="{{route('accounts.outflows.create')}}" class="dropdown-item">Add Outflow</a>
                    <a href="{{route('accounts.outflows.index')}}" class="dropdown-item">Manage Outflow</a>
                    </div>
                </li>



                @endif
                <li class="nav-item">
                    <a href="#"  class="nav-link "><i class="fa big-icon fa-key"></i> <span class="mini-dn">My Account</span></a>
                </li>
                <li class="nav-item">
                    <a href="#"  class="nav-link "><i class="fa big-icon fa-key"></i> <span class="mini-dn">My Account</span></a>
                </li>


			</ul>
		</div>
	</nav>
</div>
<!-- Header top area start-->
<div class="content-inner-all">
	<div class="header-top-area">
		<div class="fixed-header-top">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-1 col-md-6 col-sm-6 col-xs-12">
						<button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                    <i class="fa fa-bars"></i>
                                </button>




						<div class="admin-logo logo-wrap-pro">
							<a href="#"><img src="{{asset('schools/img/logo/log.png')}}" alt="" />
                                    </a>
						</div>
					</div>
					<!--					middle part of the top menu-->
					<div class="col-lg-6 col-md-1 col-sm-1 col-xs-12">
						<div class="header-top-menu tabl-d-n">
							<ul class="nav navbar-nav mai-top-nav">
								<li class="nav-item"><a href="#" class="nav-link"></a>
								</li>
								<li class="nav-item"><a href="#" class="nav-link"></a>
								</li>
							</ul>
						</div>
					</div>
					<!--					end of middle part of the top menu-->
					<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
						<div class="header-right-info">
							<ul class="nav navbar-nav mai-top-nav header-right-menu">

								<li class="nav-item">
									<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa fa-bell-o" aria-hidden="true"></i><span class="indicator-nt"></span></a>
									<div role="menu" class="notification-author dropdown-menu animated flipInX">
										<div class="notification-single-top">
											<h1>Notifications</h1>
										</div>
										<ul class="notification-menu">
											<li>
												<a href="#">
													<div class="notification-icon">
														<span class="adminpro-icon adminpro-checked-pro"></span>
													</div>
													<div class="notification-content">
														<span class="notification-date">27 Sept</span>
														<h2>System</h2>
														<p>Welcome to friends academy katende academic system.</p>
													</div>
												</a>
											</li>


										</ul>
										<div class="notification-view">
											<a href="#">(1) Notifications found</a>
										</div>
									</div>
								</li>
								<li class="nav-item">
									<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                <span class="adminpro-icon adminpro-user-rounded header-riht-inf"></span>
                                                <span class="admin-name">{{Auth::user()->name}}</span>
                                                <span class="author-project-icon adminpro-icon adminpro-down-arrow"></span>
                                            </a>




									<ul role="menu" class="dropdown-header-top author-log dropdown-menu animated flipInX">
										<li><a href="#"><span class="adminpro-icon adminpro-user-rounded author-log-ic"></span>My Profile</a>
										</li>
                                        <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                          document.getElementById('logout-form').submit();"><span class="adminpro-icon adminpro-locked author-log-ic"></span>
                                             {{ __('Logout') }}

                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
										</li>
									</ul>
								</li>

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Header top area end-->

	<!-- Mobile Menu start -->
	<div class="mobile-menu-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="mobile-menu">
						<nav id="dropdown">
							<ul class="mobile-menu-nav">
								<li>
									<a data-toggle="collapse" data-target="#Charts" href="#">Home <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
									<ul class="collapse dropdown-header-top">
										<li><a href="dashboard.html">Dashboard v.1</a>
										</li>
										<li><a href="dashboard-2.html">Dashboard v.2</a>
										</li>
										<li><a href="analytics.html">Analytics</a>
										</li>
										<li><a href="widgets.html">Widgets</a>
										</li>
									</ul>
								</li>
								<li>
									<a data-toggle="collapse" data-target="#demo" href="#">Mailbox <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
									<ul id="demo" class="collapse dropdown-header-top">
										<li><a href="inbox.html">Inbox</a>
										</li>
										<li><a href="view-mail.html">View Mail</a>
										</li>
										<li><a href="compose-mail.html">Compose Mail</a>
										</li>
									</ul>
								</li>
								<li>
									<a data-toggle="collapse" data-target="#others" href="#">Miscellaneous <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
									<ul id="others" class="collapse dropdown-header-top">
										<li><a href="profile.html">Profile</a>
										</li>
										<li><a href="contact-client.html">Contact Client</a>
										</li>
										<li><a href="contact-client-v.1.html">Contact Client v.1</a>
										</li>
										<li><a href="project-list.html">Project List</a>
										</li>
										<li><a href="project-details.html">Project Details</a>
										</li>
									</ul>
								</li>
								<li>
									<a data-toggle="collapse" data-target="#Miscellaneousmob" href="#">Interface <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
									<ul id="Miscellaneousmob" class="collapse dropdown-header-top">
										<li><a href="google-map.html">Google Map</a>
										</li>
										<li><a href="data-maps.html">Data Maps</a>
										</li>
										<li><a href="pdf-viewer.html">Pdf Viewer</a>
										</li>
										<li><a href="x-editable.html">X-Editable</a>
										</li>
										<li><a href="code-editor.html">Code Editor</a>
										</li>
										<li><a href="tree-view.html">Tree View</a>
										</li>
										<li><a href="preloader.html">Preloader</a>
										</li>
										<li><a href="images-cropper.html">Images Cropper</a>
										</li>
									</ul>
								</li>
								<li>
									<a data-toggle="collapse" data-target="#Chartsmob" href="#">Charts <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
									<ul id="Chartsmob" class="collapse dropdown-header-top">
										<li><a href="bar-charts.html">Bar Charts</a>
										</li>
										<li><a href="line-charts.html">Line Charts</a>
										</li>
										<li><a href="area-charts.html">Area Charts</a>
										</li>
										<li><a href="rounded-chart.html">Rounded Charts</a>
										</li>
										<li><a href="c3.html">C3 Charts</a>
										</li>
										<li><a href="sparkline.html">Sparkline Charts</a>
										</li>
										<li><a href="peity.html">Peity Charts</a>
										</li>
									</ul>
								</li>
								<li>
									<a data-toggle="collapse" data-target="#Tablesmob" href="#">Tables <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
									<ul id="Tablesmob" class="collapse dropdown-header-top">
										<li><a href="static-table.html">Static Table</a>
										</li>
										<li><a href="data-table.html">Data Table</a>
										</li>
									</ul>
								</li>
								<li>
									<a data-toggle="collapse" data-target="#formsmob" href="#">Forms <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
									<ul id="formsmob" class="collapse dropdown-header-top">
										<li><a href="basic-form-element.html">Basic Form Elements</a>
										</li>
										<li><a href="advance-form-element.html">Advanced Form Elements</a>
										</li>
										<li><a href="password-meter.html">Password Meter</a>
										</li>
										<li><a href="multi-upload.html">Multi Upload</a>
										</li>
										<li><a href="tinymc.html">Text Editor</a>
										</li>
										<li><a href="dual-list-box.html">Dual List Box</a>
										</li>
									</ul>
								</li>
								<li>
									<a data-toggle="collapse" data-target="#Appviewsmob" href="#">App views <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
									<ul id="Appviewsmob" class="collapse dropdown-header-top">
										<li><a href="basic-form-element.html">Basic Form Elements</a>
										</li>
										<li><a href="advance-form-element.html">Advanced Form Elements</a>
										</li>
										<li><a href="password-meter.html">Password Meter</a>
										</li>
										<li><a href="multi-upload.html">Multi Upload</a>
										</li>
										<li><a href="tinymc.html">Text Editor</a>
										</li>
										<li><a href="dual-list-box.html">Dual List Box</a>
										</li>
									</ul>
								</li>
								<li>
									<a data-toggle="collapse" data-target="#Pagemob" href="#">Pages <span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
									<ul id="Pagemob" class="collapse dropdown-header-top">
										<li><a href="login.html">Login</a>
										</li>
										<li><a href="register.html">Register</a>
										</li>
										<li><a href="captcha.html">Captcha</a>
										</li>
										<li><a href="checkout.html">Checkout</a>
										</li>
										<li><a href="contact.html">Contacts</a>
										</li>
										<li><a href="review.html">Review</a>
										</li>
										<li><a href="order.html">Order</a>
										</li>
										<li><a href="comment.html">Comment</a>
										</li>
									</ul>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Mobile Menu end -->
	<!-- Breadcome start-->
	<div class="breadcome-area mg-b-30 des-none">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="breadcome-list map-mg-t-40-gl shadow-reset">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Breadcome End-->
