


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
    .panel{
        color:whitesmoke
    }
</style>
@endsection
@section('admin-content')
		<!-- Static Table Start -->
		<div class="data-table-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sparkline13-list shadow-reset">
                                <div class="sparkline13-hd">
                                    <div class="main-sparkline13-hd">
                                        <h1>View <span class="table-project-n">Assigned
                                                {{substr($student->roll_number, 0,1)}} Level Student</span> Info</h1>
                                        <div class="sparkline13-outline-icon">
                                            <span class="sparkline13-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                            <span class="sparkline13-collapse-close"><i class="fa fa-times"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sparkline13-graph">
                                   <div class="row">
                                        <div class="col-md-12 panel panel-default bg-transparent">
                                            <h2 class="">
                                                {{$student->name}} | {{$student->roll_number}}
                                            </h2>
                                            <p>
                                                <table class="table table-striped table-hover">

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
                                            </p>
                                        </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Static Table End -->

@endsection
@section('scripts')
            	<!-- scrollUp JS
         ============================================ -->
	<script src="{{ asset('schools/js/jquery.scrollUp.min.js')}}"></script>
	<!-- counterup JS
		============================================ -->
	<script src="{{ asset('schools/js/counterup/jquery.counterup.min.js')}}"></script>
	<script src="{{ asset('schools/js/counterup/waypoints.min.js')}}"></script>
	<!-- peity JS
		============================================ -->
	<script src="{{ asset('schools/js/peity/jquery.peity.min.js')}}"></script>
	<script src="{{ asset('schools/js/peity/peity-active.js')}}"></script>
	<!-- sparkline JS
		============================================ -->
	<script src="{{ asset('schools/js/sparkline/jquery.sparkline.min.js')}}"></script>
	<script src="{{ asset('schools/js/sparkline/sparkline-active.js')}}"></script>
	<!-- data table JS
		============================================ -->
	<script src="{{ asset('schools/js/data-table/bootstrap-table.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/tableExport.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/data-table-active.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/bootstrap-table-editable.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/bootstrap-editable.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/bootstrap-table-resizable.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/colResizable-1.5.source.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/bootstrap-table-export.js')}}"></script>
	<!-- main JS
         ============================================ -->
	<script src="{{ asset('schools/js/main.js')}}"></script>
@endsection
