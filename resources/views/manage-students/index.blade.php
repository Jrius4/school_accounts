@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Students {{$level!==null?$level.' Level':null}}</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage Students {{$level!==null?$level.' Level':null}}</h3>
                <a href="{{route('roles.create')}}" class="btn btn-sm btn-outline-primary">Create New Role</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Roll Number</th>
                        <th>Class</th>
                        <th>Stream</th>

                        <th>view</th>
                    </thead>
                    <tbody>
                        @if ($students->count()==0)
                                <div class="alert alert-danger">No info</div>
                        @else
                            @foreach ($students as $student)
                                <tr>
                                    <td>
                                    {{$student->name}}
                                    </td>
                                    <td>
                                        {{$student->roll_number}}
                                    </td>
                                    <td>
                                        {{$student->schclass->name}}
                                    </td>
                                    <td>
                                        {{$student->schstream->name}}
                                    @if ($student->combination != null)
                                            | {{$student->combination->combination_name}}
                                    @endif
                                    </td>

                                    <td>
                                    <a href="{{route('students.show',$student->id)}}">
                                        <i class="fa fab fa-eye"></i>
                                    </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                    <tfoot>
                        <th>Name</th>
                        <th>Roll Number</th>
                        <th>Class</th>
                        <th>Stream</th>
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
<script src="{{asset('adminlte//plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
    $(function () {
      $('#RoleTable').DataTable({
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
