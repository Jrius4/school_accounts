@extends('layouts.dashboard')

@section('style')

<style>
    .panel{
        background:transparent !important;
        border:none;
    }
    form{
        padding: 1vw;
    }
    .center-items{
        display: flex;
        justify-items: center;
    }
    p{
        color: #ffff !important
    }
</style>

@endsection


@section('content')

		<!-- Breadcome start-->
		<div class="breadcome-area mg-b-30 small-dn">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="breadcome-list map-mg-t-40-gl shadow-reset">
							<div class="row">
								<div class="col-lg-6">
									<div class="breadcome-heading">
										<h2>Add Student</h2>
									</div>
								</div>
								<div class="col-lg-6">
									<ul class="breadcome-menu">
                                    <li><a href="{{url('/')}}">Home</a> <span class="bread-slash">/</span> </li>
                                    <li><a href="{{route('students.index')}}">Student</a> <span class="bread-slash">/</span> </li>
										<li><span class="bread-blod">add students</span> </li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Breadcome End-->

		<!--		start of tab-->
		<div class="admintab-wrap mg-b-40">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
			<ul class="nav nav-tabs custom-menu-wrap custon-tab-menu-style1">
				<li class="active"><a data-toggle="tab" href="#Alevel"><span class="adminpro-icon adminpro-analytics tab-custon-ic"></span>S.5 &amp; S.6</a>
				</li>
				<li><a data-toggle="tab" href="#Tabs4s3"><span class="adminpro-icon adminpro-analytics-arrow tab-custon-ic"></span>S.4 &amp; S.3</a>
				</li>
				<li><a data-toggle="tab" href="#Tabs2s1"><span class="adminpro-icon adminpro-analytics-bridge tab-custon-ic"></span>S.2 &amp; S.1</a>
				</li>
			</ul>
			<div class="tab-content">
				<div id="Alevel" class="tab-pane in active animated custon-tab-style1">
					<!--										start of a level data-->
				<div class="row">
					<div class="col-lg-3">

					</div>
					<div class="col-lg-6">
						<div class="admin-pro-accordion-wrap mg-b-15 shadow-reset">
                               {{-- errors --}}
							<div class="panel-group adminpro-custon-design" id="accordion">
								<div class="panel panel-default">
									<form action="{{ url("register/student") }}" method="POST" enctype="multipart/form-data">
                                            @csrf
										<div id="form" class="panel-collapse panel-ic collapse in">
											<div class="form admin-panel-content animated bounce">
												<p>Full Names</p>
												<div class="">
													<input type="text" name="name" class="form-control">
												</div>
												<p>Roll Number</p>
												<div class="">
                                                    {{$students = App\Models\Student::get()->count()}}
                                                    {{$students+=1}}
                                                    {{$roll_number1 ='A/'.date('Y').'/'.sprintf('%03s', $students)}}
													<input type="text" value="<?php echo $roll_number1 ?>" class="form-control" disabled>
													<input type="hidden"  name="roll_number" value="<?php echo $roll_number1 ?>" class="form-control" required>
												</div>
												<p>Class</p>
												<div class="">
													<div class="chosen-select-single mg-b-20">
                                                            {!! Form::select('id', App\Schstream::where('id','>=',5)->pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose Class']) !!}
													</div>
												</div>
												<p>Stream</p>
												<div class="">
                                                        <div style="display: none">
                                                                {{$streams1 = App\Schstream::where('student_class_id','>=',5)->get() }}
                                                                {{$classes1 = App\Schstream::where('id','>=',5)->get() }}
                                                            </div>

                                                            <select name="id" id="" class=" form-control" >
                                                                    <option value="">{{'Choose Stream'}}</option>
                                                                @foreach ($streams1 as $stream)
                                                                    <option value="{{$stream->id}}">{{$stream->name.' in '.$classes1->find($stream->student_class_id)->name  }}</option>
                                                                @endforeach
                                                            </select>
												</div>
												<p>Combination</p>
												<div class="">
													<div class="chosen-select-single mg-b-20">
                                                            {!! Form::select('id', App\Routine\Combination::pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose Combination']) !!}
													</div>
												</div>
												<p>Gender</p>
												<div class="">
													<div class="chosen-select-single mg-b-20">
														<select name="gender" class=" form-control">
															<option value="">Select</option>
															<option value="Male">Male</option>
															<option value="Female">Female</option>
														</select>
													</div>
												</div>
												<p>Fees to be paid</p>
												<div class="">
													<input type="text" name="fees" class="form-control">
													<span class="help-block">Eg- 500000,1000000 etc</span>
												</div>
												<p>Image</p>
												<div class="">
													<input type="file" name="profilepic" class="form-control" id="success"> </div>
												<p>Medical form</p>
												<div class="">
													<input type="file" name="medicalform" class="form-control" id="success"> </div>
												<p>Admission form</p>
												<div class="">
													<input type="file" name="admissionform" class="form-control" id="success"> </div>
                                                <p></p>
                                                <input type="hidden" name="password" class="form-control" value="student">
                                                    <input type="hidden" name="password_confirmation" class="form-control" value="student">
												<div class="">
													<div class="login-horizental login-btn-inner">
														<button class="btn btn-sm btn-primary login-submit-cs" name="s56submit" type="submit">Add Student</button>
													</div>
												</div>
											</div>
										</div>
									</form>
									<div class="panel panel-default">

										<div id="collapse2" class="panel-collapse panel-ic collapse">
											<div class="panel-body admin-panel-content animated bounce">

											</div>
										</div>
									</div>
									<div class="panel panel-default">

										<div id="collapse3" class="panel-collapse panel-ic collapse">
											<div class="panel-body admin-panel-content animated bounce">

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
					<!--										end of a level data-->
				</div>
				<div id="Tabs4s3" class="tab-pane animated custon-tab-style1">
					<!--										start of s.4 n s.3 data-->

					<div class="row">
					<div class="col-lg-3">

					</div>
					<div class="col-lg-6">
						<div class="admin-pro-accordion-wrap mg-b-15 shadow-reset">

							<div class="panel-group adminpro-custon-design" id="accordion">
								<div class="panel panel-default">
									<form action="{{ url("register/student") }}" method="POST" enctype="multipart/form-data">
                                        @csrf

										<div id="form" class="panel-collapse panel-ic collapse in">
											<div class="form admin-panel-content animated bounce">
												<p>Full Names</p>
												<div class="">
													<input type="text" name="fullname" class="form-control">
												</div>
												<p>Roll Number</p>
												<div class="">
                                                    {{$students = App\Models\Student::get()->count()}}
                                                    {{$students +=1}}
                                                    {{$roll_number2 ='O/'.date('Y').'/'.sprintf('%03s', $students)}}
													<input type="text" value="<?php echo $roll_number2 ?>" class="form-control" disabled>
													<input type="hidden"  name="rollno" value="<?php echo $roll_number2 ?>" class="form-control">
												</div>
												<p>Class</p>
												<div class="">
													<div class="chosen-select-single mg-b-20">
                                                            {!! Form::select('id', App\Schclass::where('id','>=', 3)->where('id','<=', 4)->pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose Class']) !!}
													</div>
												</div>
												<p>Stream</p>
												<div class="">
													<div class="chosen-select-single mg-b-20">
                                                            {{-- {!! Form::select('id', App\Schstream::where('student_class_id','>=',3)->where('student_class_id','<=', 4)->pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose Stream']) !!} --}}
                                                            <div style="display: none">
                                                                {{$streams = App\Schstream::where('student_class_id','>=',3)->where('student_class_id','<=', 4)->get() }}
                                                                {{$classes = App\Schclass::where('id','>=',3)->where('id','<=', 4)->get() }}
                                                            </div>

                                                            <select name="id" id="" class=" form-control" >
                                                                    <option value="">{{'Choose Stream'}}</option>
                                                                @foreach ($streams as $stream)
                                                                    <option value="{{$stream->id}}">{{$stream->name.' in '.$classes->find($stream->student_class_id)->name  }}</option>
                                                                @endforeach
                                                            </select>

													</div>
												</div>
												<p>Subject One</p>
											<div class="chosen-select-single mg-b-20">
                                                    {!! Form::select('id', App\Routine\Subject::pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose Optional Subject']) !!}

												</div>
											<p>Subject Two</p>
											<div class="chosen-select-single mg-b-20">
                                                    {!! Form::select('id', App\Routine\Subject::pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose Optional Subject']) !!}

												</div>
											<p>Subject Three</p>
											<div class="chosen-select-single mg-b-20">
                                                    {!! Form::select('id', App\Routine\Subject::pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose Optional Subject']) !!}

												</div>
												<p>Gender</p>
												<div class="">
													<div class="chosen-select-single mg-b-20">
														<select name="gender" class=" form-control" required>
															<option value="">Select</option>
															<option value="Male">Male</option>
															<option value="Female">Female</option>
														</select>
													</div>
												</div>
												<p>Fees to be paid</p>
												<div class="">
													<input type="text" name="fees" class="form-control">
													<span class="help-block">Eg- 500000,1000000 etc</span>
												</div>
												<p>Image</p>
												<div class="">
													<input type="file" name="profilepic" class="form-control" id="success"> </div>
												<p>Medical form</p>
												<div class="">
													<input type="file" name="medicalform" class="form-control" id="success"> </div>
												<p>Admission form</p>
												<div class="">
													<input type="file" name="admissionform" class="form-control" id="success"> </div>
                                                <p></p>
                                                <input type="hidden" name="password" class="form-control" value="student">
                                                    <input type="hidden" name="password_confirmation" class="form-control" value="student">
												<div class="">
													<div class="login-horizental login-btn-inner">
														<button class="btn btn-sm btn-primary login-submit-cs" name="s34submit" type="submit">Add Student</button>
													</div>
												</div>
											</div>
										</div>
									</form>
									<div class="panel panel-default">

										<div id="collapse2" class="panel-collapse panel-ic collapse">
											<div class="panel-body admin-panel-content animated bounce">

											</div>
										</div>
									</div>
									<div class="panel panel-default">

										<div id="collapse3" class="panel-collapse panel-ic collapse">
											<div class="panel-body admin-panel-content animated bounce">

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
					<!--										end of s.4 n s.3data-->
				</div>
				<div id="Tabs2s1" class="tab-pane animated custon-tab-style1">
					<!--										start of s2 n s1 data-->

						<div class="row">
					<div class="col-lg-3">

					</div>
					<div class="col-lg-6">
						<div class="admin-pro-accordion-wrap mg-b-15 shadow-reset">

							<div class="panel-group adminpro-custon-design" id="accordion">
								<div class="panel panel-default">
									<form action="{{ url("register/student") }}" method="POST" enctype="multipart/form-data">
                                        @csrf

										<div id="form" class="panel-collapse panel-ic collapse in">
											<div class="form admin-panel-content animated bounce">
												<p>Full Names</p>
												<div class="">
													<input type="text" name="fullname" class="form-control">
												</div>
												<p>Roll Number</p>
												<div class="">
													{{$students = App\Models\Student::get()->count()}}
                                                    {{$students +=1}}
                                                    {{$roll_number ='O/'.date('Y').'/'.sprintf('%03s', $students)}}
													<input type="text" value="<?php echo $roll_number ?>" class="form-control" disabled>
													<input type="hidden"  name="rollno" value="<?php echo $roll_number ?>" class="form-control">
												</div>
												<p>Class</p>
												<div class="">
													<div class="chosen-select-single mg-b-20">
                                                            {!! Form::select('id', App\Schclass::where('id','>=', 1)->where('id','<=', 2)->pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose class']) !!}
													</div>
												</div>
												<p>Stream</p>
												<div class="">
													<div class="chosen-select-single mg-b-20">
                                                            <div style="display: none">
                                                                    {{$streams2 = App\Schstream::where('student_class_id','>=',1)->where('student_class_id','<=', 2)->get() }}
                                                                    {{$classes2 = App\Schclass::where('id','>=',1)->where('id','<=', 3)->get() }}
                                                                </div>

                                                                <select name="id" id="" class=" form-control" >
                                                                        <option value="">{{'Choose Stream'}}</option>
                                                                    @foreach ($streams2 as $stream)
                                                                        <option value="{{$stream->id}}">{{$stream->name.' in '.$classes2->find($stream->student_class_id)->name  }}</option>
                                                                    @endforeach
                                                                </select>
													</div>
												</div>

												<p>Gender</p>
												<div class="">
													<div class="chosen-select-single mg-b-20">
														<select name="gender" class=" form-control" required>
															<option value="">Select</option>
															<option value="Male">Male</option>
															<option value="Female">Female</option>
														</select>
													</div>
												</div>
												<p>Fees to be paid</p>
												<div class="">
													<input type="text" name="fees" class="form-control">
													<span class="help-block">Eg- 500000,1000000 etc</span>
												</div>
												<p>Image</p>
												<div class="">
													<input type="file" name="profilepic" class="form-control" id="success"> </div>
												<p>Medical form</p>
												<div class="">
													<input type="file" name="medicalform" class="form-control" id="success"> </div>
												<p>Admission form</p>
												<div class="">
                                                    <input type="file" name="admissionform" class="form-control" id="success">
                                                    <input type="hidden" name="password" class="form-control" value="student">
                                                    <input type="hidden" name="password_confirmation" class="form-control" value="student">
                                                </div>
												<p></p>
												<div class="">
													<div class="login-horizental login-btn-inner">
														<button class="btn btn-sm btn-primary login-submit-cs" name="s21submit" type="submit">Add Student</button>
													</div>
												</div>
											</div>
										</div>
									</form>
									<div class="panel panel-default">

										<div id="collapse2" class="panel-collapse panel-ic collapse">
											<div class="panel-body admin-panel-content animated bounce">

											</div>
										</div>
									</div>
									<div class="panel panel-default">

										<div id="collapse3" class="panel-collapse panel-ic collapse">
											<div class="panel-body admin-panel-content animated bounce">

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

					<!--										end of s2 n s1 data-->
				</div>
			</div>
			</div>
			</div>
		</div>
    @endsection

    @section('scripts')
	    <script>
function getStream56(val) {
    $.ajax({
    type: "POST",
    url: "get_student.php",
    data:'stream='+val,
    success: function(data){
        $("#streamid").html(data);

    }
    });
}
    </script>
	<script>
function getStream45(val) {
    $.ajax({
    type: "POST",
    url: "get_student.php",
    data:'stream45='+val,
    success: function(data){
        $("#streamid45").html(data);

    }
    });
}
    </script>
	<script>
function getStream21(val) {
    $.ajax({
    type: "POST",
    url: "get_student.php",
    data:'stream21='+val,
    success: function(data){
        $("#streamid21").html(data);

    }
    });
}
    </script>
@endsection
