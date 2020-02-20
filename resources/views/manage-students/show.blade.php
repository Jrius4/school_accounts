@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('students.index')}}">Manage Students</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$student->name}} {{$student->schclass->name}}</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">{{$student->name}}</h3>
                <a href="javascript:void(0)" class="btn btn-sm btn-outline-success">{{$student->schclass->name}}</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable2" class="table table-bordered table-striped">

                                                    <thead>
                                                        <td>Name</td>
                                                        <td>Roll Number</td>
                                                        <td>Level</td>
                                                        <td>Combination</td>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{$student->name}}</td>
                                                            <td>{{$student->roll_number}}</td>
                                                            <td>{{substr($student->roll_number, 0,1)=='O'?'O level':'A level'}}</td>
                                                            <td>{{'PMTD/ICT'}}</td>
                                                        </tr>
                                                    </tbody>
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
