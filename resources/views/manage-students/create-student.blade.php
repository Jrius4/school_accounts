

<section style="min-height:100vh;">


    <!-- /.card -->
    <div class="card card-dark card-tabs elevation-2 animated flipInX">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-content-above-senior-1-2-tab" data-toggle="pill" href="#custom-content-above-senior-1-2" role="tab" aria-controls="custom-content-above-senior-1-2" aria-selected="true">S.1 & S.2</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-content-above-senior-3-4-tab" data-toggle="pill" href="#custom-content-above-senior-3-4" role="tab" aria-controls="custom-content-above-senior-3-4" aria-selected="false">S.3 & S.4</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-content-above-senior-5-6-tab" data-toggle="pill" href="#custom-content-above-senior-5-6" role="tab" aria-controls="custom-content-above-senior-5-6" aria-selected="false">S.5 & S.6</a>
                </li>
              </ul>
        </div>
        <div class="card-body">

          <div class="mb-1">
            <p class="lead mb-0"><i class="fas fa-user-plus"></i> Register New Student</p>
          </div>
          <div class="tab-content" id="custom-content-above-tabContent">
            <div class="tab-pane fade show active" id="custom-content-above-senior-1-2" role="tabpanel" aria-labelledby="custom-content-above-senior-1-2-tab">


               <form action="javascript:void(0)" id="insertdata12" method="POST" enctype="multipart/form-data">
                   @csrf
                   <div class="row d-flex justify-content-center">
                        <div class="col-md-10 elevation-2" style="min-height:200px;">
                            <div class="form-group col-12 d-block py-2 my-1">
                                <label for="student_name">Student Name</label>
                                <input type="text" name="student_name" class="form-control">
                            </div>
                            <div class="form-group col-12 d-block py-2 my-1">
                                <label for="rollno">Roll Number</label>

                                <div style="display:none">
                                    {{$students = App\Models\Student::where('created_at','LIKE','%'.date('Y').'%')->get()->count()}}
                                    {{$students+=1}}
                                    {{$roll_number2 ='O/'.date('Y').'/'.sprintf('%03s', $students)}}
                                </div>
                                <input type="text" value="<?php echo $roll_number2 ?>" class="form-control" disabled>
                                <input type="hidden"  name="rollno" value="<?php echo $roll_number2 ?>" class="form-control">
                            </div>
                            <div class="form-group col-12 d-block py-2 my-1">
                                <label for="class_id">Class</label>
                                {!! Form::select('class', App\Schclass::where('id','<=', 2)->pluck('name', 'id'), null, ['class' => 'form-control action12','id'=>'schclasses12', 'placeholder' => 'Choose Class']) !!}
                            </div>
                            <div class="form-group col-12 d-block py-2 my-1">
                                <label for="stream12">Select Stream</label>
                                <select name="stream" id="stream12" class="form-control col-12">
                                    <option value="">Select a stream</option>
                                </select>
                            </div>
                            <div class="form-group col-12 d-block py-2 my-1">
                                <label for="gender">Gender</label>
                                <select name="gender" class=" form-control">
                                    <option value="">Select a gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group col-12 d-block py-2 my-1">
                                <label for="fees_to_be_paid">Fees To be Paid</label>
                                <input type="text" name="paid_to_be_fees" class="form-control"/>
                                <span class="text-muted">for example; 500000</span>
                            </div>
                            <div class="form-group col-12 d-block py-2 my-1">
                                <label for="fees_paid">Fees Paid</label>
                                <input type="text" name="paid_fees" class="form-control"/>
                                <span class="text-muted">for example; 500000</span>
                            </div>
                            <div class="form-group col-12 d-block my-1 py-2">
                                <label for="passport_photo">Profile Picture</label>
                                <div class="custom-file">
                                    <input type="file" name="passport_photo" id="passport_photo" class="form-control custom-file-input" placeholder="Browser Profile Picture">
                                    <label class="custom-file-label" for="passport_photo">Browser Profile Image</label>
                                </div>
                            </div>

                            <div class="form-group col-12 d-block my-1 py-2">
                                <label for="medical_form">Student Medical Form</label>
                                <div class="custom-file">
                                    <input type="file" name="medical_form" id="medical_form" class="form-control custom-file-input" placeholder="Browser Medical Form">
                                    <label class="custom-file-label" for="profile_pic">Browser Student Medical Form</label>
                                </div>
                            </div>

                            <div class="form-group col-12 d-block my-1 py-2">
                                <label for="admission_form">Student Admission Form</label>
                                <div class="custom-file">
                                    <input type="file" name="admission_form" id="admission_form" class="form-control custom-file-input" placeholder="Browser Profile Picture">
                                    <label class="custom-file-label" for="admission_form">Student Admission Form</label>
                                </div>
                            </div>
                            <input type="hidden" name="password" class="form-control" value="student">
                            <input type="hidden" name="password_confirmation" class="form-control" value="student">

                            <div class="form-group col-12 d-block my-1 py-2">
                                <input type="submit" value="Register Student" class="btn btn-md btn-outline-dark col-12 elevation-2">
                            </div>
                        </div>
                   </div>
               </form>


            </div>
            <div class="tab-pane fade" id="custom-content-above-senior-3-4" role="tabpanel" aria-labelledby="custom-content-above-senior-3-4-tab">


                <form action="javascript:void(0)" id="insertdata34" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row d-flex justify-content-center">
                         <div class="col-md-10 elevation-2" style="min-height:200px;">
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="student_name">Student Name</label>
                                 <input type="text" name="student_name" class="form-control">
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="rollno">Roll Number</label>

                                 <div style="display:none">
                                     {{$students = App\Models\Student::where('created_at','LIKE','%'.date('Y').'%')->get()->count()}}
                                     {{$students+=1}}
                                     {{$roll_number2 ='O/'.date('Y').'/'.sprintf('%03s', $students)}}
                                 </div>
                                 <input type="text" value="<?php echo $roll_number2 ?>" class="form-control" disabled>
                                 <input type="hidden"  name="rollno" value="<?php echo $roll_number2 ?>" class="form-control">
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="class_id">Class</label>
                                 {!! Form::select('class', App\Schclass::orderBy('id','asc')->where('id','>=', 3)->where('id','<=', 4)->pluck('name', 'id'), null, ['class' => 'form-control action12','id'=>'schclasses34', 'placeholder' => 'Choose Class']) !!}
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="stream12">Select Stream</label>
                                 <select name="stream" id="stream34" class="form-control col-12">
                                     <option value="">Select a stream</option>
                                 </select>
                             </div>
                             <div class="form col-12 d-block py-2 my-2">
                                <label for="optional_subjects">Optional Subjects</label><br>
                                <select id="optional_subjects" name="optional_subjects" class="form-control col-md-12" style="width:100% !important" multiple="multiple"></select>
                                <input type="hidden" name="hidden_optional_subjects" id="hidden_optional_subjects">
                                <small class="text-info">select 3 optional subjects</small>

                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="gender">Gender</label>
                                 <select name="gender" class=" form-control">
                                     <option value="">Select a gender</option>
                                     <option value="Male">Male</option>
                                     <option value="Female">Female</option>
                                 </select>
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="fees_to_be_paid">Fees To be Paid</label>
                                 <input type="text" name="paid_to_be_fees" class="form-control"/>
                                 <span class="text-muted">for example; 500000</span>
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="fees_paid">Fees Paid</label>
                                 <input type="text" name="paid_fees" class="form-control"/>
                                 <span class="text-muted">for example; 500000</span>
                             </div>
                             <div class="form-group col-12 d-block my-1 py-2">
                                 <label for="passport_photo">Profile Picture</label>
                                 <div class="custom-file">
                                     <input type="file" name="passport_photo" id="passport_photo" class="form-control custom-file-input" placeholder="Browser Profile Picture">
                                     <label class="custom-file-label" for="passport_photo">Browser Profile Image</label>
                                 </div>
                             </div>

                             <div class="form-group col-12 d-block my-1 py-2">
                                 <label for="medical_form">Student Medical Form</label>
                                 <div class="custom-file">
                                     <input type="file" name="medical_form" id="medical_form" class="form-control custom-file-input" placeholder="Browser Medical Form">
                                     <label class="custom-file-label" for="profile_pic">Browser Student Medical Form</label>
                                 </div>
                             </div>

                             <div class="form-group col-12 d-block my-1 py-2">
                                 <label for="admission_form">Student Admission Form</label>
                                 <div class="custom-file">
                                     <input type="file" name="admission_form" id="admission_form" class="form-control custom-file-input" placeholder="Browser Profile Picture">
                                     <label class="custom-file-label" for="admission_form">Student Admission Form</label>
                                 </div>
                             </div>
                             <input type="hidden" name="password" class="form-control" value="student">
                             <input type="hidden" name="password_confirmation" class="form-control" value="student">

                             <div class="form-group col-12 d-block my-1 py-2">
                                 <input type="submit" value="Register Student" class="btn btn-md btn-outline-dark col-12 elevation-2">
                             </div>
                         </div>
                    </div>
                </form>


            </div>
            <div class="tab-pane fade" id="custom-content-above-senior-5-6" role="tabpanel" aria-labelledby="custom-content-above-senior-5-6-tab">


                <form action="javascript:void(0)" id="insertdata56" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row d-flex justify-content-center">
                         <div class="col-md-10 elevation-2" style="min-height:200px;">
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="student_name">Student Name</label>
                                 <input type="text" name="student_name" class="form-control">
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="rollno">Roll Number</label>

                                 <div style="display:none">
                                     {{$students = App\Models\Student::where('created_at','LIKE','%'.date('Y').'%')->get()->count()}}
                                     {{$students+=1}}
                                     {{$roll_number2 ='A/'.date('Y').'/'.sprintf('%03s', $students)}}
                                 </div>
                                 <input type="text" value="<?php echo $roll_number2 ?>" class="form-control" disabled>
                                 <input type="hidden"  name="rollno" value="<?php echo $roll_number2 ?>" class="form-control">
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="class_id">Class</label>
                                 {!! Form::select('class', App\Schclass::orderBy('id','asc')->where('id','>=',5)->where('id','<=',6)->pluck('name', 'id'), null, ['class' => 'form-control action12','id'=>'schclasses56', 'placeholder' => 'Choose Class']) !!}
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="stream12">Select Stream</label>
                                 <select name="stream" id="stream56" class="form-control col-12">
                                     <option value="">Select a stream</option>
                                 </select>
                             </div>
                             <div class="form col-12 d-block py-2 my-2">
                                <label for="optional_subjects">Select Combination Subjects</label><br>
                                <select name="combination" id="combination" class="form-control col-12" style="width:100% !important"></select>

                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="gender">Gender</label>
                                 <select name="gender" class=" form-control">
                                     <option value="">Select a gender</option>
                                     <option value="Male">Male</option>
                                     <option value="Female">Female</option>
                                 </select>
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="fees_to_be_paid">Fees To be Paid</label>
                                 <input type="text" name="paid_to_be_fees" class="form-control"/>
                                 <span class="text-muted">for example; 500000</span>
                             </div>
                             <div class="form-group col-12 d-block py-2 my-1">
                                 <label for="fees_paid">Fees Paid</label>
                                 <input type="text" name="paid_fees" class="form-control"/>
                                 <span class="text-muted">for example; 500000</span>
                             </div>
                             <div class="form-group col-12 d-block my-1 py-2">
                                 <label for="passport_photo">Profile Picture</label>
                                 <div class="custom-file">
                                     <input type="file" name="passport_photo" id="passport_photo" class="form-control custom-file-input" placeholder="Browser Profile Picture">
                                     <label class="custom-file-label" for="passport_photo">Browser Profile Image</label>
                                 </div>
                             </div>

                             <div class="form-group col-12 d-block my-1 py-2">
                                 <label for="medical_form">Student Medical Form</label>
                                 <div class="custom-file">
                                     <input type="file" name="medical_form" id="medical_form" class="form-control custom-file-input" placeholder="Browser Medical Form">
                                     <label class="custom-file-label" for="profile_pic">Browser Student Medical Form</label>
                                 </div>
                             </div>

                             <div class="form-group col-12 d-block my-1 py-2">
                                 <label for="admission_form">Student Admission Form</label>
                                 <div class="custom-file">
                                     <input type="file" name="admission_form" id="admission_form" class="form-control custom-file-input" placeholder="Browser Profile Picture">
                                     <label class="custom-file-label" for="admission_form">Student Admission Form</label>
                                 </div>
                             </div>
                             <input type="hidden" name="password" class="form-control" value="student">
                             <input type="hidden" name="password_confirmation" class="form-control" value="student">

                             <div class="form-group col-12 d-block my-1 py-2">
                                 <input type="submit" value="Register Student" class="btn btn-md btn-outline-dark col-12 elevation-2">
                             </div>
                         </div>
                    </div>
                </form>


            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.card -->


</section>
@include('dashboards.scripts')
