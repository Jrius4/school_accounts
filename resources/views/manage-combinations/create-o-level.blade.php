@extends('layouts.admin-dashboard')
@section('style')
<style>
    .bg-transparent{
        background:transparent !important;
        border:none
    }
    .center-items{
        display: flex;
        justify-items: center;
    }
    label{
        color: aliceblue !important;
    }
</style>
@endsection
@section('admin-content')

<div class="breadcome-area mg-b-30 small-dn">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcome-list map-mg-t-40-gl shadow-reset">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="breadcome-heading">
                                <h2>O-Level</h2>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="breadcome-menu">
                                <li><a href="#">Home</a> <span class="bread-slash">/</span> </li>
                                <li><a href="#">Subjects</a> <span class="bread-slash">/</span> </li>
                                <li><span class="bread-blod">Assign subjects to students</span> </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


		<!-- accordion start-->
		<div class="adminpro-accordion-area">
			<div class="container-fluid">
                <div id="results"></div>
				<div class="row">
					<div class="col-lg-12"> </div>
				</div>
				<div class="row">
					<div class="col-lg-3">

						</div>
					<div class="col-lg-6">
						<div class="sparkline11-list shadow-reset mg-t-30">
                                <div class="sparkline11-hd">
                                    <div class="main-sparkline11-hd">
                                        <h1>S.3 &amp;  <span class="basic-ds-n">S.4</span></h1>
                                        <div class="sparkline11-outline-icon">
                                            <span class="sparkline11-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                            <span class="sparkline11-collapse-close"><i class="fa fa-times"></i></span>
                                        </div>
                                    </div>
                                </div>
							 <div class="sparkline11-graph">
                                    <div class="basic-login-form-ad">

						<div class="admin-pro-accordion-wrap mg-b-15 bg-transparent">
							<div class="panel-group adminpro-custon-design" id="accordion">
								<div class="panel panel-default bg-transparent">
									<form id="insert_o_level_data" action="javascript:void(0);" method="post">
                                        @csrf

									<div id="form" class="panel-collapse panel-ic collapse in bg-transparent">
										<div class="form admin-panel-content animated bounce bg-transparent">
                                            <label>Student Name</label>
                                            <input type="hidden" name="level" value="Ordinary Level">
											<div class="">
												<div class="chosen-select-single mg-b-20">
													<select name="student_name" id="student_name" class="select2_demo_3 form-control"></select>
												</div>
												 </div>
											<label>Subject One</label>
											<div class="chosen-select-single mg-b-20">
													<select name="first_o_subject" id="first_o_subject" class="select2_demo_3 form-control"></select>
												</div>
											<label>Subject Two</label>
											<div class="chosen-select-single mg-b-20">
													<select name="second_o_subject" id="second_o_subject"  class="select2_demo_3 form-control">
													</select>
												</div>
											<label>Subject Three</label>
											<div class="chosen-select-single mg-b-20">
													<select name="third_o_subject" id="third_o_subject"  class="select2_demo_3 form-control"></select>
												</div>

											<div class="">
												<div class="login-horizental login-btn-inner">
													<button class="btn btn-sm btn-primary login-submit-cs" type="submit" name="submit">Set Combination</button>
												</div>
											</div>
										</div>
									</div>
									</form>
									<div class="panel panel-default">

										<div id="collapse2" class="panel-collapse panel-ic collapse  bg-transparent">
											<div class="panel-body admin-panel-content animated bounce  bg-transparent">

											</div>
										</div>
									</div>
									<div class="panel panel-default bg-transparent">

										<div id="collapse3" class="panel-collapse panel-ic collapse bg-transparent">
											<div class="panel-body admin-panel-content animated bounce bg-transparent">

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
							</div>
						</div>
					</div>
					</div>
					<div class="col-lg-3">
					</div>
					</div>
				</div>
            </div>
            @include('manage-combinations.scripts')

@endsection
