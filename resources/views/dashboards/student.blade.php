<div class="container">

    <div class="card card-dark card-tabs evation-2 animated slideInDown">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active"
                    id="custom-content-above-senior-1-2-tab"
                    data-toggle="pill" href="#custom-content-above-senior-1-2" role="tab" aria-controls="custom-content-above-senior-1-2"
                    aria-selected="true">S.1 & S.2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                    id="custom-content-above-senior-3-4-tab"
                    data-toggle="pill"
                    href="#custom-content-above-senior-3-4"
                    role="tab" aria-controls="custom-content-above-senior-3-4"
                    aria-selected="false">S.3 & S.4</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                    id="custom-content-above-senior-5-6-tab"
                    data-toggle="pill"
                    href="#custom-content-above-senior-5-6"
                    role="tab" aria-controls="custom-content-above-senior-5-6"
                    aria-selected="false">S.5 & S.6</a>
                  </li>
            </ul>
        </div>
        <div class="d-none">
            <form action="javascript:void(0)" id="unseen">
                <input type="hidden" name="unseen-tab" id="unseen-tab" @if($errors->first('fails56')) value="fails56" @endif @if($errors->first('fails34')) value="fails34" @endif @if($errors->first('fails12')) value="fails12" @endif>
            </form>
        </div>

        <div class="card-body">
            <div class="mb-1">
                <p class="lead mb-0"><i class="fas fa-user-plus"></i> Register New Student</p>
            </div>



                @if(session('message'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <p>
                            {{ session('message') }}
                        </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif


            <div class="tab-content" id="custom-content-above-tabContent">
                <div class="tab-pane fade show active @if($errors->first('fails12')) show active @endif" id="custom-content-above-senior-1-2" role="tabpanel" aria-labelledby="custom-content-above-senior-1-2-tab">


                    <form action="{{route('student.join')}}" method="POST" enctype="multipart/form-data">
                        @csrf




                        <div class="form-group col-md-12 d-block">
                            <label>Student Name</label>
                            <input type="text" name="student_name" class="form-control col-12  @error('student_name') is-invalid @enderror"/>
                            @error('student_name')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label>Roll Number</label>
                            <div style="display:none">
                                {{$students = App\Models\Student::where('created_at','LIKE','%'.date('Y').'%')->get()->count()}}
                                {{$students+=1}}
                                {{$roll_number2 ='O/'.date('Y').'/'.sprintf('%03s', $students)}}
                            </div>
                            <input type="text" value="<?php echo $roll_number2 ?>" class="form-control col-12" disabled>
                            <input type="hidden"  name="rollno" value="<?php echo $roll_number2 ?>" class="form-control col-12">
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="class">Class</label>
                            {!! Form::select('class', App\Schclass::where('id','<=', 2)->pluck('name', 'id'), null, ['class' => 'form-control action12 col-12','id'=>'schclasses12', 'placeholder' => 'Choose Class']) !!}

                            @error('class')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="stream12">Select Stream</label>
                            <select name="stream" id="stream12" class="form-control col-12  @error('stream') is-invalid @enderror">
                                <option value="">Select a stream</option>
                            </select>
                            @error('stream')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="">Select a gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('gender')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>


                        <div class="form-group col-md-12 d-block">
                            <label for="fees_to_be_paid">Fees To be Paid</label>
                            <input type="text" name="fees_to_be_paid" class="form-control col-12 @error('fees_to_be_paid') is-invalid @enderror"/>
                            <span class="text-muted">for example; 500000</span>
                            @error('fees_to_be_paid')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="fees_paid">Fees Paid</label>
                                    <input type="text" name="paid_fees" class="form-control col-12 @error('paid_fees') is-invalid @enderror"/>
                                    <span class="text-muted">for example; 500000</span>

                                    @error('paid_fees')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <p>
                                                {{$message}}
                                            </p>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @enderror
                        </div>



                        <div class="form-group col-12 d-block my-1 py-2">
                            <label for="passport_photo">Profile Picture</label>
                            <div class="custom-file">
                                <input type="file" name="passport_photo"  accept="image/jpg, image/jpeg, image/png" id="passport_photo" class="form-control custom-file-input @old('passport_photo')  @error('passport_photo') is-invalid @enderror" placeholder="Browser Profile Picture">
                                <label class="custom-file-label" for="passport_photo">Browser Profile Image</label>
                            </div>
                            @error('passport_photo')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 d-block my-1 py-2">
                            <label for="medical_form">Student Medical Form</label>
                            <div class="custom-file">
                                <input type="file" name="medical_form" id="medical_form" class="form-control custom-file-input @error('medical_form') is-invalid @enderror" placeholder="Browser Medical Form">
                                <label class="custom-file-label" for="profile_pic">Browser Student Medical Form</label>
                            </div>
                            @error('medical_form')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 d-block my-1 py-2">
                            <label for="admission_form">Student Admission Form</label>
                            <div class="custom-file">
                                <input type="file" name="admission_form" id="admission_form" class="form-control custom-file-input @error('admission_form') is-invalid @enderror" placeholder="Browser Profile Picture">
                                <label class="custom-file-label" for="admission_form">Student Admission Form</label>
                            </div>
                            @error('admission_form')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <input type="hidden" name="password" class="form-control" value="student">
                        <input type="hidden" name="password_confirmation" class="form-control" value="student">





                        <div class="form-group col-md-12 d-block" dismissable>
                            <input type="submit" value="Submit" name="submit12" class="btn btn-block btn-dark col-sm-12">
                        </div>

                    </form>




                </div>

                <div class="tab-pane fade" id="custom-content-above-senior-3-4" role="tabpanel" aria-labelledby="custom-content-above-senior-3-4-tab">
                    <form action="{{route('student.join')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group col-md-12 d-block">
                            <label>Student Name</label>
                            <input type="text" name="student_name" class="form-control col-12  @error('student_name') is-invalid @enderror"/>
                            @error('student_name')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 d-block">
                            <label>Roll Number</label>
                            <div style="display:none">
                                {{$students = App\Models\Student::where('created_at','LIKE','%'.date('Y').'%')->get()->count()}}
                                {{$students+=1}}
                                {{$roll_number2 ='O/'.date('Y').'/'.sprintf('%03s', $students)}}
                            </div>
                            <input type="text" value="<?php echo $roll_number2 ?>" class="form-control col-12" disabled>
                            <input type="hidden"  name="rollno" value="<?php echo $roll_number2 ?>" class="form-control col-12">
                        </div>
                        <div class="form-group col-md-12 d-block">
                            <label for="class">Class</label>
                            {!! Form::select('class', App\Schclass::orderBy('id','asc')->where('id','>=', 3)->where('id','<=', 4)->pluck('name', 'id'), null, ['class' => 'form-control action12 col-12','id'=>'schclasses34', 'placeholder' => 'Choose Class']) !!}

                            @error('class')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="stream34
                            ">Select Stream</label>
                            <select name="stream" id="stream34" class="form-control col-12  @error('stream') is-invalid @enderror">
                                <option value="">Select a stream</option>
                            </select>
                            @error('stream')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="optional_subjects">Optional Subjects</label><br>
                                    <select id="optional_subjects" name="optional_subjects" class="form-control col-12" style="width:100% !important" multiple="multiple"></select>
                                    <input type="hidden" name="hidden_optional_subjects" id="hidden_optional_subjects">
                                    <small class="text-info">select 3 optional subjects</small>

                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="">Select a gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('gender')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>



                        <div class="form-group col-md-12 d-block">
                            <label for="fees_to_be_paid">Fees To be Paid</label>
                            <input type="text" name="fees_to_be_paid" class="form-control col-12 @error('fees_to_be_paid') is-invalid @enderror"/>
                            <span class="text-muted">for example; 500000</span>
                            @error('fees_to_be_paid')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="fees_paid">Fees Paid</label>
                                    <input type="text" name="paid_fees" class="form-control col-12 @error('paid_fees') is-invalid @enderror"/>
                                    <span class="text-muted">for example; 500000</span>

                                    @error('paid_fees')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <p>
                                                {{$message}}
                                            </p>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @enderror
                        </div>



                        <div class="form-group col-12 d-block my-1 py-2">
                            <label for="passport_photo">Profile Picture</label>
                            <div class="custom-file">
                                <input type="file" name="passport_photo"  accept="image/jpg, image/jpeg, image/png" id="passport_photo" class="form-control custom-file-input @old('passport_photo')  @error('passport_photo') is-invalid @enderror" placeholder="Browser Profile Picture">
                                <label class="custom-file-label" for="passport_photo">Browser Profile Image</label>
                            </div>
                            @error('passport_photo')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 d-block my-1 py-2">
                            <label for="medical_form">Student Medical Form</label>
                            <div class="custom-file">
                                <input type="file" name="medical_form" id="medical_form" class="form-control custom-file-input @error('medical_form') is-invalid @enderror" placeholder="Browser Medical Form">
                                <label class="custom-file-label" for="profile_pic">Browser Student Medical Form</label>
                            </div>
                            @error('medical_form')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 d-block my-1 py-2">
                            <label for="admission_form">Student Admission Form</label>
                            <div class="custom-file">
                                <input type="file" name="admission_form" id="admission_form" class="form-control custom-file-input @error('admission_form') is-invalid @enderror" placeholder="Browser Profile Picture">
                                <label class="custom-file-label" for="admission_form">Student Admission Form</label>
                            </div>
                            @error('admission_form')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <input type="hidden" name="password" class="form-control" value="student">
                        <input type="hidden" name="password_confirmation" class="form-control" value="student">





                        <div class="form-group col-md-12 d-block" dismissable>
                            <input type="submit" name="submit34" value="Submit" class="btn btn-block btn-dark col-sm-12">
                        </div>

                    </form>

                </div>

                <div class="tab-pane fade" id="custom-content-above-senior-5-6" role="tabpanel" aria-labelledby="custom-content-above-senior-5-6-tab">
                    <form action="{{route('student.join')}}" method="POST"  enctype="multipart/form-data">
                        @csrf




                        <div class="form-group col-md-12 d-block">
                            <label>Student Name</label>
                            <input type="text" name="student_name" class="form-control col-12  @error('student_name') is-invalid @enderror"/>
                            @error('student_name')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label>Roll Number</label>
                            <div style="display:none">
                                {{$students = App\Models\Student::where('created_at','LIKE','%'.date('Y').'%')->get()->count()}}
                                {{$students+=1}}
                                {{$roll_number2 ='O/'.date('Y').'/'.sprintf('%03s', $students)}}
                            </div>
                            <input type="text" value="<?php echo $roll_number2 ?>" class="form-control col-12" disabled>
                            <input type="hidden"  name="rollno" value="<?php echo $roll_number2 ?>" class="form-control col-12">
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="gender">Gender</label>
                            <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="">Select a gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('gender')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="class">Class</label>
                            {!! Form::select('class', App\Schclass::orderBy('id','asc')->where('id','>=', 5)->pluck('name', 'id'), null, ['class' => 'form-control action12 col-12','id'=>'schclasses56', 'placeholder' => 'Choose Class']) !!}

                            @error('class')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>



                        <div class="form-group col-md-12 d-block">
                            <label for="stream12">Select Stream</label>
                            <select name="stream" id="stream56" class="form-control col-12  @error('stream') is-invalid @enderror">
                                <option value="">Select a stream</option>
                            </select>
                            @error('stream')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="combination">Class</label>
                            <select name="combination" id="combination" class="form-control col-12" style="width:100% !important"></select>

                            @error('combination')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="fees_to_be_paid">Fees To be Paid</label>
                            <input type="text" name="fees_to_be_paid" class="form-control col-12 @error('fees_to_be_paid') is-invalid @enderror"/>
                            <span class="text-muted">for example; 500000</span>
                            @error('fees_to_be_paid')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 d-block">
                            <label for="fees_paid">Fees Paid</label>
                                    <input type="text" name="paid_fees" class="form-control col-12 @error('paid_fees') is-invalid @enderror"/>
                                    <span class="text-muted">for example; 500000</span>

                                    @error('paid_fees')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <p>
                                                {{$message}}
                                            </p>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @enderror
                        </div>



                        <div class="form-group col-12 d-block my-1 py-2">
                            <label for="passport_photo">Profile Picture</label>
                            <div class="custom-file">
                                <input type="file" name="passport_photo"  accept="image/jpg, image/jpeg, image/png" id="passport_photo" class="form-control custom-file-input @old('passport_photo')  @error('passport_photo') is-invalid @enderror" placeholder="Browser Profile Picture">
                                <label class="custom-file-label" for="passport_photo">Browser Profile Image</label>
                            </div>
                            @error('passport_photo')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group col-12 d-block my-1 py-2">
                            <label for="medical_form">Student Medical Form</label>
                            <div class="custom-file">
                                <input type="file" name="medical_form" id="medical_form" class="form-control custom-file-input @error('medical_form') is-invalid @enderror" placeholder="Browser Medical Form">
                                <label class="custom-file-label" for="profile_pic">Browser Student Medical Form</label>
                            </div>
                            @error('medical_form')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>





                        <div class="form-group col-12 d-block my-1 py-2">
                            <label for="admission_form">Student Admission Form</label>
                            <div class="custom-file">
                                <input type="file" name="admission_form" id="admission_form" class="form-control custom-file-input @error('admission_form') is-invalid @enderror" placeholder="Browser Profile Picture">
                                <label class="custom-file-label" for="admission_form">Student Admission Form</label>
                            </div>
                            @error('admission_form')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <p>
                                        {{$message}}
                                    </p>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @enderror
                        </div>


                        <input type="hidden" name="password" class="form-control" value="student">
                        <input type="hidden" name="password_confirmation" class="form-control" value="student">


                        <div class="form-group col-md-12 d-block" dismissable>
                            <input type="submit" value="Submit" name="submit56" class="btn btn-block btn-dark col-sm-12">
                        </div>





                    </form>
                </div>

            </div>
        </div>
    </div>

{{--
    <form action="{{route('student.join')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group col-md-12 d-block">
            <label>Student Name</label>
            <input type="text" name="student_name" class="form-control col-12"/>
            @error('student_name')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>
                    {{$message}}
                </p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @enderror
        </div>

        <div class="form-group col-md-12 d-block" dismissable>
            <input type="submit" value="Submit" class="btn btn-block btn-dark col-sm-12">
        </div>

    </form> --}}



</div>



@section('first-scripts')
 <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.min.css')}}">
    <script src="{{asset('schools/plugins/select2/js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('schools/plugins/multiselect/jquery.lwMultiSelect.js')}}"></script>
    <link rel="stylesheet" href="{{asset('schools/plugins/multiselect/jquery.lwMultiSelect.css')}}" />
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#something').html(`
        <div>
            <p>Stop! okay continue..</p>
        </div>
        `)

        $.ajaxSetup({
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
        });

        var unseen = $('#unseen-tab').val();
        if(unseen !== '')
        {
            if(unseen === 'fails34')
            {
                $("#custom-content-above-senior-1-2").removeClass('show');
                $("#custom-content-above-senior-1-2").removeClass('active');
                $("#custom-content-above-senior-1-2-tab").removeClass('active');

                $("#custom-content-above-senior-3-4").addClass('show');
                $("#custom-content-above-senior-3-4").addClass('active');
                $("#custom-content-above-senior-3-4-tab").addClass('active');

            }

            if(unseen === 'fails56')
            {
                $("#custom-content-above-senior-1-2").removeClass('show');
                $("#custom-content-above-senior-1-2").removeClass('active');
                $("#custom-content-above-senior-1-2-tab").removeClass('active');

                $("#custom-content-above-senior-5-6").addClass('show');
                $("#custom-content-above-senior-5-6").addClass('active');
                $("#custom-content-above-senior-5-6-tab").addClass('active');

            }
            console.log(unseen);
        }

        $('#optional_subjects').change(function(){
            var optionals = $('#optional_subjects').val()
            $('#hidden_optional_subjects').val(optionals);
            console.log(optionals);
        })


        bsCustomFileInput.init();

        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 15000
        });

        $('.swalDefaultSuccess').click(function() {
        Toast.fire({
            type: 'success',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
        });

        $('.toastrDefaultSuccess').click(function() {
        toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
        });
        $('.toastsDefaultBottomRight').click(function() {
        $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Toast Title',
            position: 'bottomRight',
            autohide: true,
            delay: 750,
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
        });


        $("#optional_subjects").select2({
            placeholder: "Select a Optional Subjects",
            allowClear: true,
            ajax: {
                url: "{{url('/api/get-o-level-subjects')}}",
                dataType: 'json',
                delay:250,
                data:function(params){
                    var query = {
                        q:params.term,
                        page:params.page
                    };
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page||1;

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * 10) < data.total
                        }
                    };
                },
                success:function(data)
                {
                    console.log(data.data);
                },
                error:function(data)
                {
                    console.log(data);
                },
                cache:true,


            },
            minimumInputLength:1,
            templateResult:formatRepoOpt,
            templateSelection:formatRepoOptSelection
        });

        function formatRepoOpt(repo){
            if(repo.loading){
                return repo.text
            }

            var $container =$("<span>"+repo.name+"</span>");
            return $container;
        }
        function formatRepoOptSelection(repo)
        {
            return repo.name;
        }




        $("#combination").select2({
            placeholder: "Select a Combination",
            allowClear: true,
            ajax: {
                url: "{{url('/api/get-a-level-combination')}}",
                dataType: 'json',
                delay:250,
                data:function(params){
                    var query = {
                        q:params.term,
                        page:params.page
                    };
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page||1;

                    return {
                        results: data.data,
                        pagination: {
                            more: (params.page * 10) < data.total
                        }
                    };
                },
                success:function(data)
                {
                    console.log(data.data);
                },
                error:function(data)
                {
                    console.log(data);
                },
                cache:true,


            },
            minimumInputLength:1,
            templateResult:formatRepo,
            templateSelection:formatRepoSelection
        });

        function formatRepo(repo){
            if(repo.loading){
                return repo.text
            }

            var $container =$("<span>"+repo.combination_name+"</span>");
            return $container;
        }
        function formatRepoSelection(repo)
        {
            return repo.combination_name;
        }

        // $('#streams1').lwMultiSelect();
        // $('#streams2').lwMultiSelect();
        // $('#streams3').lwMultiSelect();
        $('.action1').change(function(){
            if($(this).val() !='')
            {
                    var action = $(this).attr("id");
                    var query = $(this).val();
                    var result = '';
                    if(action == 'schclasses1')
                    {
                        result = 'streams1';
                    }

                    $.ajax({
                        url:"{{url('/fetch-streams')}}",
                        method:"POST",
                        data:{action:action, query:query},
                        success:function(data)
                        {
                            console.log(data)
                            $('#'+result).html(data);

                            if(result == 'streams1')
                            {
                                // $('#streams1').data('plugin_lwMultiSelect').updateList();
                            }
                            // console.log(data)
                        },
                        error:function(data)
                        {
                            console.log(data)
                        }

                    })

            }

        });


        $('.action2').change(function(){
            if($(this).val() !='')
            {
                    var action = $(this).attr("id");
                    var query = $(this).val();
                    var result = '';
                    if(action == 'schclasses2')
                    {
                        result = 'streams2';
                    }

                    $.ajax({
                        url:"{{url('/fetch-streams')}}",
                        method:"POST",
                        data:{action:action, query:query},
                        success:function(data)
                        {
                            $('#'+result).html(data);

                            if(result == 'streams2')
                            {
                                // $('#streams2').data('plugin_lwMultiSelect').updateList();
                            }
                            // console.log(data)
                        },
                        error:function(data)
                        {
                            console.log(data)
                        }

                    })

            }

        });

        $('.action3').change(function(){
            if($(this).val() !='')
            {
                    var action = $(this).attr("id");
                    var query = $(this).val();
                    var result = '';
                    if(action == 'schclasses3')
                    {
                        result = 'streams3';
                    }

                    $.ajax({
                        url:"{{url('/fetch-streams')}}",
                        method:"POST",
                        data:{action:action, query:query},
                        success:function(data)
                        {
                            $('#'+result).html(data);

                            if(result == 'streams3')
                            {
                                // $('#streams3').data('plugin_lwMultiSelect').updateList();
                            }
                            // console.log(data)
                        },
                        error:function(data)
                        {
                            console.log(data)
                        }

                    })

            }

        });




        $('.action12').change(function(e)
        {
            e.preventDefault();
            if($(this).val() !== '')
            {
                var action = $(this).attr("id");
                var query = $(this).val();
                var result = null;

                console.log(`action:${action} ,query:${query}`)
                if(action === 'schclasses12')
                {
                    result='stream12';
                }
                if(action === 'schclasses34')
                {
                    result='stream34';
                }
                if(action === 'schclasses56')
                {
                    result='stream56';
                }
                $.ajax({
                    url:"{{url('/fetch-streams')}}",
                    method:"POST",
                    data:{action:action,query:query},
                    success:function(data){
                        console.log(data);
                        $(`#${result}`).html(data)
                    },
                    error:function(data){
                        console.log(data);
                    }
                });

            }

        });




        console.log("ready");

    });

</script>
@endsection
