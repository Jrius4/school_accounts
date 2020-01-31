@extends('layouts.dashboard')
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
    .clear-fix{
        clear: both;
    }
</style>
@endsection
@section('content')
    @include('layouts.navbar')

		<!-- Static Table Start -->
		<div class="data-table-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sparkline13-list shadow-reset">
                                <div class="sparkline13-hd">
                                    <div class="main-sparkline13-hd">
                                        <h1>View <span class="table-project-n">
                                                {{substr(Auth::guard('students')->user()->roll_number, 0,1)}} Level | Class: {{Auth::guard('students')->user()->schclass->name}} Student</span> Info</h1>
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
                                               <img width="75" height="75"  src={{asset('images/'.Auth::guard('students')->user()->image)}}/> {{Auth::guard('students')->user()->name}} | {{Auth::guard('students')->user()->roll_number}}
                                            </h2>
                                            <p>
                                                <table class="table table-striped table-hover text-left">

                                                    <thead>
                                                        <th>Name</th>
                                                        <th>Roll Number</th>
                                                        <th>Level</th>
                                                        @if (substr(Auth::guard('students')->user()->roll_number, 0,1)=='O' && Auth::guard('students')->user()->schclass_id > 2 )
                                                        <th>Optional Subjects</th>
                                                        @elseif(substr(Auth::guard('students')->user()->roll_number, 0,1)=='A')
                                                        <th>Combination</th>
                                                        @endif

                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{Auth::guard('students')->user()->name}}</td>
                                                            <td>{{Auth::guard('students')->user()->roll_number}}</td>
                                                            <td>{{substr(Auth::guard('students')->user()->roll_number, 0,1)=='O'?'O level':'A level'}}</td>
                                                            @if (substr(Auth::guard('students')->user()->roll_number, 0,1)=='O' && Auth::guard('students')->user()->schclass_id > 2 )
                                                            <td>
                                                                @if (Auth::guard('students')->user()->subjects->count() > 0)

                                                                    @foreach (Auth::guard('students')->user()->subjects as $subject)
                                                                    <p>{{$subject->name}}</p>
                                                                    @endforeach
                                                                @else
                                                                    <p>Not Yet Assigned</p>
                                                                @endif
                                                            </td>
                                                            @elseif(substr(Auth::guard('students')->user()->roll_number, 0,1)=='A')
                                                            <td>{{Auth::guard('students')->user()->combination()->first()->combination_name."/".Auth::guard('students')->user()->combination()->first()->subsidiary}}</td>
                                                            @endif
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </p>
                                            <div class="row ">

                                                <div class="">
                                                    <h4 class="text-left">Admission Form</h4>
                                                    <iframe class="col-md-6" style="min-height:450pt" src={{asset('documents/'.Auth::guard('students')->user()->admission_form)}} type="file"></iframe>
                                                </div>
                                                <div class="clear-fix"></div>
                                                <div class="">
                                                    <h4 class="text-left">Medical Form</h4>
                                                    <iframe class="col-md-6" style="min-height:450pt" src={{asset('documents/'.Auth::guard('students')->user()->medical_form)}} type="file"></iframe>
                                                </div>
                                            </div>
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

