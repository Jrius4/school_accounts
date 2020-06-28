@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Declare Results</li>
    </ol>
</nav>


<section class="content">

    <div class="row d-flex justify-content-center">
        <div class="mx-auto my-2 w-45 h-45">
            <div class="info-outcome"></div>
            {{-- <a href="javascript:void(0)" id="entry" class="btn btn-block bg-gradient-warning btn-md">Switch</a> --}}
            <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Result Entry Permission</h3>
                </div>
                <div class="card-body d-flex justify-content-center">
                  {{-- <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch> --}}
                  <div class="mx-auto">
                      <form action="javascript:void(0)" id="inputData">
                        @csrf

                        <div class="form-group d-block justify-content-center col-12">
                            <label for="resultEntry" class="col-12"><span id="entry">Allow</span> Results Entry</label>
                            <input type="checkbox" name="resultEntry" id="entryResult" @if($entryStatus) checked  @endif data-bootstrap-switch data-off-color="danger" data-on-color="success" class="entryaction form-control d-block col-12">

                        </div>
                        <div class="form-group">
                            <input type="submit" value="submit" class="btn btn-block bg-gradient-secondary btn-md mb-1 col-12">
                        </div>


                      </form>

                </div>

                </div>
              </div>
        </div>
    </div>

<div class="row d-flex justify-content-center">
    <div class="col-md-10">
        <form class="card elevation-2 col-12" action={{route('declares.store')}} method="POST">
            @csrf

            <div class="form-group">
                <label for="year">Year</label>
                {{-- <input type="text" name="year" value="{{ old('year') }}" class="form-control col-12 @error('year') is-invalid @enderror"> --}}
                <select name="year" id="year" class="form-control col-12 @error('year') is-invalid @enderror">
                    <option value="">select year</option>

                    @foreach ($years as $year)
                        <option value="{{$year['year']}}" @if(old('year')==$year['year']) selected @endif>{{$year['year']}}</option>
                    @endforeach
                </select>
                @error('year')
                    <span class="invalid-feedback text-danger">{{$message}}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="term">Term</label>
                <select name="term_id" id="term_id" class="form-control col-12 @error('term_id') is-invalid @enderror">
                    <option value="">select term</option>

                    @foreach ($terms as $term)
                        <option value="{{$term->id}}" @if(old('term_id')==$term->id) selected @endif>{{$term->name}}</option>
                    @endforeach
                    <option value="all">All Terms</option>
                </select>
                @error('term_id')
                    <span class="invalid-feedback text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="set">set</label>
                <select name="exmset_id" id="exmset_id" class="form-control col-12 @error('exmset_id') is-invalid @enderror">
                    <option value="">select set</option>

                    @foreach ($sets as $set)
                        <option value="{{$set->id}}" @if(old('exmset_id')==$set->id) selected @endif>{{$set->set_name}}</option>

                    @endforeach
                    <option value="all">All sets</option>
                </select>
                @error('exmset_id')
                    <span class="invalid-feedback text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Search By ??</label>
                {{-- <input type="text" name="student" value="{{ old('student') }}" class="form-control col-12 @error('student') is-invalid @enderror"> --}}
                <select name="" id="" class="form-control col-12 action1">
                    <option value="">Choose ...</option>

                    <option value="student">Student</option>
                    <option value="class">class</option>
                </select>

            </div>

            <div class="form-group student_id">
                <label for="student_id">Student</label>
                {{-- <input type="text" name="student" value="{{ old('student') }}" class="form-control col-12 @error('student') is-invalid @enderror"> --}}
                <select name="student_id" id="student_id" class="form-control col-12 @error('student_id') is-invalid @enderror">
                    <option value="">select student</option>

                    @foreach ($students as $student)
                        <option value="{{$student->id}}" @if(old('student_id')==$student->id) selected @endif>{{$student->name.', '.$student->schclass->name}}</option>
                    @endforeach
                </select>
                @error('student_id')
                    <span class="invalid-feedback text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group schclass_id">
                <label for="schclass_id">Class</label>
                {{-- <input type="text" name="schclass" value="{{ old('schclass') }}" class="form-control col-12 @error('schclass') is-invalid @enderror"> --}}
                <select name="schclass_id" id="schclass_id" class="form-control col-12 @error('schclass_id') is-invalid @enderror">
                    <option value="">select class</option>

                    @foreach ($classes as $class)
                        <option value="{{$class->id}}" @if(old('schclass_id')==$class->id) selected @endif>{{$class->name}}</option>
                    @endforeach
                </select>
                @error('schclass_id')
                    <span class="invalid-feedback text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                {{-- <input type="text" name="status" value="{{ old('status') }}" class="form-control col-12 @error('status') is-invalid @enderror"> --}}
                <select name="status" id="status" class="form-control col-12 @error('status') is-invalid @enderror">
                    <option value="">select status</option>
                    <option value="Hold Results">Hold Results</option>
                    <option value="Undeclare Results">Undeclare Results</option>
                    <option value="Declare Results">Declare Results</option>
                </select>
                @error('status')
                    <span class="invalid-feedback text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="message">Reason</label>
                <textarea name="message" id="message" class="form-control" placeholder="State the reason" cols="30" rows="10"></textarea>
            </div>

            <input type="submit" value="submit" class="btn btn-block bg-gradient-secondary btn-md col-12 d-block mb-2 elevation-2"/>


        </form>
    </div>

</div>

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Declare Status Class</h3>
                <a href="javascript:void()" class="btn btn-sm btn-outline-primary">Declare Result</a>
            </div>
            <div class="card-body table-responsive p-2" style="min-height:350px">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped">
                    <thead>
                        <th>Year</th>
                        <th>term</th>
                        <th>Set</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Status</th>
                        <th>reason</th>
                        <th>Action</th>
                    </thead>
                    <tbody>

                        @if ($declares->count()==0)

                        @elseif($declares->count()>1)
                        @foreach($declares as $row)
                            <tr>
                                <td>{{$row->year!=null?$row->year:''}}</td>
                                {{-- <td>{{$row->term_id!=null?$terms->where('id',$row->term_id)->first()->name:''}}</td> --}}
                                <td>
                                    @if($row->term_id== 'all')
                                        <span>All terms</span>
                                    @elseif($row->term_id!=null && $row->term_id!= 'all')
                                    <span>{{$sets->where('id',$row->term_id)->first()->set_name}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($row->exmset_id== 'all')
                                        <span>All terms</span>
                                    @elseif($row->exmset_id!=null && $row->exmset_id!= 'all')
                                    <span>{{$sets->where('id',$row->exmset_id)->first()->set_name}}</span>
                                    @endif
                                </td>
                                <td>{{$row->student_id!=null?$students->where('id',$row->student_id)->first()->name.'-'.$students->where('id',$row->student_id)->first()->schclass->name:''}}</td>
                                <td>{{$row->schclass_id!=null?$classes->where('id',$row->schclass_id)->first()->name:''}}</td>
                                <td>{{$row->status!=null?$row->status:''}}</td>
                                <td><p>{{$row->message!=null?$row->message:''}}</p></td>
                                <td></td>
                            </tr>
                        @endforeach

                        @endif
{{--
                        @if ($combinations->count()==0)
                                <div class="alert alert-danger">No info</div>
                        @else
                            @foreach ($combinations as $comb)
                                <tr>
                                    <td>
                                    {{$comb->combination_name}}
                                    </td>

                                    <td>
                                        {{$comb->first_subject}}
                                    </td>
                                    <td>{{$comb->second_subject}}</td>
                                    <td>{{$comb->third_subject}}</td>
                                    <td>{{$comb->subsidiary}}</td>
                                    <td>{{$comb->level}}</td>
                                    <td>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['manage-combinations.destroy', $comb->id]]) !!}
                                        <a href="{{route('manage-combinations.edit',$comb->id)}}" class="btn btn-xs btn-info"><i class="fa fas fa-edit"></i></a>|<button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-xs btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            {{-- @endif
                                        {!! Form::close() !!}

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                         --}}


                    </tbody>
                    <tfoot>
                        <th>Year</th>
                        <th>term</th>
                        <th>Set</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Status</th>
                        <th>message</th>
                        <th>Action</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


</section>



@endsection

@section('style')
 <!-- DataTables -->
 <link rel="stylesheet" href="src="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>
@endsection
@section('script')
  <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection
@section('scripts')
<!-- Bootstrap Switch -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
    $(document).ready(function(){

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".action1").change(function(){
        if($(".action1").val()=="class"){
            $('.student_id').addClass('d-none');
            $('.schclass_id').removeClass('d-none');
        }
        if($(".action1").val()=="student"){
            $('.schclass_id').addClass('d-none');
            $('.student_id').removeClass('d-none');
        }

    });

      $('#RoleTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
      });
      $('#inputData').submit(function(){

        var formData = $('#inputData').serialize()
        console.log(formData)
        $.ajax({
            url:"{{url('/entry-status')}}",
            method:"POST",
            data:formData,
            success:function(data){
                if(data!==null){
                    // var html = alert(data.status);
                    var html = `<div class="alert alert-${data.status=="results entry disabled"?"danger":"success"} alert-dismissible fade show" role="alert">
                                    ${data.status}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>`;
                    $('.info-outcome').html(html)
                    console.log(data)

                }
            },
            error:function(data){
                console.log(data)
            }

        })
    });

      $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));

    });



    });
  </script>
@endsection
