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
    .names{
        color:aliceblue;
    }
    .panel{
        background-color: transparent;
        color: aliceblue
    }
</style>
@endsection
@section('admin-content')
        <div class="row">
            <div class="center-contents">
                <a href="{{route('staffs.create')}}" class="btn btn-info">Add Staff Role</a>
                </div>
        </div>
		<!-- Static Table Start -->
		<div class="data-table-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="">

                                <div class="row names">
                                        <h1>View <span class="table-project-n">Teacher</span> Info</h1>
                                        <h3>Name <span class="table-project-n">{{$user->name}}</span></h3>

                                </div>
                                <div class="container">
                                    <div class="row">
                                        <div class="panel col-md-6">
                                            <h2>Subjects</h2>
                                            <div class="row">
                                                @if ($user->subjects->count() !=0)
                                                    @foreach ($user->subjects as $subject)
                                                        <h4>{{$subject->name}}</h4>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="panel col-md-6">
                                            <h2>Class</h2>
                                            <div class="row">
                                                @if ($user->subjects->count() !=0)
                                                    @foreach ($user->subjects as $subject)
                                                        <h4>{{$subject->name}}</h4>
                                                        @foreach ($subject->schoolclasses as $class)
                                                            <h5>{{$class->name}}</h5>
                                                        @endforeach
                                                    @endforeach
                                                @endif
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
