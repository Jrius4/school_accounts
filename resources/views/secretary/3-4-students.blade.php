@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Students Senior 3-4</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage Students Senior 1 - 2</h3>
                <a href="{{url('/')}}" class="btn btn-sm btn-outline-primary">Register New Student</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped no-wrap">
                    <thead>
                        <th>Pic</th>
                        <th>Name</th>

                        <th>Roll Number</th>
                        <th>Class</th>
                        <th>Balance</th>
                        <th>Stream</th>

                        {{-- <th>Action</th> --}}
                    </thead>
                    <tbody>
                        @if ($students->count()==0)
                                <div class="alert alert-danger">No info</div>
                        @else
                            @foreach ($students as $student)
                                <tr>
                                    <td>
                                        @if (isset($student->image))
                                            <img  class="profile-pic img-fluid" src="{{asset('images/'.$student->image)}}" style="max-height:75px;max-width:75px" alt="" srcset="">
                                        @endif
                                    </td>
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
                                        <span class="d-none">
                                            {{$balance = $student->fees_to_be_paid - $student->amount_paid }}
                                        </span>
                                        {{$balance}}
                                    </td>
                                    <td>
                                        {{$student->schstream->name}}
                                    @if ($student->combination != null)
                                            | {{$student->combination->combination_name}}
                                    @endif
                                    </td>

                                    {{-- <td>
                                    <a href="{{route('students.show',$student->id)}}">
                                        <i class="fa fab fa-eye"></i>
                                    </a>|<a href="{{route('students.edit',$student->id)}}"><i class="fa fab fa-edit"></i></a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                    <tfoot>
                        <th>Pic</th>
                        <th>Name</th>

                        <th>Roll Number</th>
                        <th>Class</th>
                        <th>Balance</th>
                        <th>Stream</th>
                        {{-- <th>view</th> --}}
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
