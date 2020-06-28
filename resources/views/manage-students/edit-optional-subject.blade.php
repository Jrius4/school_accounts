@extends('layouts.main-dashboard')

@section('dashboard')


<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('students.index')}}">Manage Students</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit {{$student->name}} {{$student->schclass->name}}</li>
    </ol>
</nav>




    <section class="content">

        <section class="container-fluid">
            <section style="min-height:100vh;">

                <div class="row d-flex justify-content-center">
                    <div class="card card-dark col-md-8 mx-auto p-0 animated flipInX">
                        <div class="card-header">
                            Edit Student
                        </div>
                        <form action="{{route('students.update',$student->id)}}" id="update-form" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="student_id" value="{{$student->id}}">
                            <input type="hidden" name="opt_id" id="opt_id">
                            <div class="form-group d-block col-12">
                                <label for="student">Student Name</label>
                                <input type="text" name="student" id="student" class="form-control" value="{{$student->name}}" disabled>
                            </div>
                            @if($student->schclass_id >=3 && $student->schclass_id <=4)
                            <div class="form-group d-block col-12">
                                <label for="subjects">Optional Subjects</label>
                                <select name="subjects" class="form-control col-12 action" multiple id="subjects">
                                    <option value="">Select Optional Subject</option>
                                    @foreach ($subjects->where('level','Ordinary Level')->where('subject_compulsory',0) as $row)
                                        <option value="{{$row->id}}" @if($studentSubject->where('id',$row->id)->count()>0) selected @endif>{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            @if($student->schclass_id >=5 && $student->schclass_id <=6)
                            <div class="form-group d-block col-12">
                                <label for="combination">Select Combination</label>
                                <select name="combination" class="form-control col-12" id="combination">
                                    <option value="">Select Combination</option>
                                    @foreach ($combinations->where('level','Advanced Level') as $row)
                                        <option value="{{$row->id}}" @if($student->where('combination_id',$row->id)->count()>0) selected @endif >{{$row->combination_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="form-group d-block col-12">
                                <input type="submit" value="Update" class="btn btn-dark btn-md btn-block col-12">
                            </div>

                        </form>

                    </div>
                </div>

                @include('manage-students.scripts')


            </section>
        </section>
    </section>

@endsection




@section('style')

    <style>
        .breadcrumb{

            background: #fdffffc7;
        }
    </style>

@endsection
{{-- @section('script')
  <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection --}}

