@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Assigned Subject To Teacher</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounceIn">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage Assigned Subject To Teacher</h3>
                <a href="{{url('/assign-subject-to-teacher')}}" class="btn btn-sm btn-outline-primary">Assigned Subject To Teacher</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="TeacherTable" class="table table-bordered table-striped">
                    <thead>
                        <th colspan="2">Name</th>
                        <th>Number Of Subjects</th>
                        <th>view</th>
                    </thead>
                    <tbody>
                                            @if ($teachers->count()==0)
                                                <div class="alert alert-danger">No info</div>
                                            @else
                                                @foreach ($teachers as $teacher)
                                                    <tr>
                                                        <td colspan="2">

                                                        <p class="name">{{$teacher->name}}</p>
                                                        </td>
                                                        <td>
                                                            @if($teacher->subjects->count()>0)
                                                                @foreach ($teacher->subjects as $subject)

                                                                <p class="subjects">{{$subject->name}}</p>

                                                                @endforeach
                                                            @else
                                                                <p>No Subject Assigned</p>
                                                            @endif
                                                        </td>

                                                        <td>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif



                    </tbody>
                    <tfoot>
                        <th colspan="2">Name</th>
                        <th>Number Of Subject(s)</th>
                        <th>view</th>
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
    .subjects{
        display: inline-flex;
        color: azure;
        background: #143f73;
        border: azure 1px inset;
    }
    .name{
        display: inline-flex;}
</style>
@endsection
@section('script')
  <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection
@section('scripts')

<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
    $(function () {
      $('#TeacherTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
      });
    });
  </script>
@endsection
