@extends('layouts.admin-dashboard')
@section('style')
<style>
    .bg-transparent{
        background:transparent !important;
        border:none
    }
    label{
        color: white !important;
        padding: 5pt;
    }

</style>
@endsection
@section('admin-content')

            {{-- start --}}
        <div class="row center-form">
            <div class="" style="min-width:45vw">
                <div class="admin-pro-accordion-wrap mg-b-15 shadow-reset">

                    <div class="panel-group adminpro-custon-design" id="accordion">
                        <div class="panel panel-default">
                            <form action="javascript:void(0)" id="insert_data">

                                <div id="form" class="panel-collapse panel-ic collapse in">
                                    <div class="form admin-panel-content animated bounce">

                                        <div style="display:none">
                                        <input type="hidden" name="term" value={{request()->term}}><input type="hidden" value={{request()->set}} name="set"><input type="hidden" name="teacher_id" value="{{Auth::user()->id}}">
                                        </div>
                                        <label>Class</label>
                                        <div class="">
                                            <div class="chosen-select-single mg-b-20">
                                                <select name="schclass" id="schclass" class="action form-control">
                                                    <option value="">Select Class</option>
                                                    @foreach ($schclasses as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <label>Subject</label>
                                        <div class="">
                                            <div class="chosen-select-single mg-b-20">
                                                <select name="subject" id="subject" class="action form-control">
                                                </select>
                                            </div>
                                        </div>
                                        <label>Exam Set</label>
                                        <div class="">
                                            <div class="chosen-select-single mg-b-20">
                                                  <select name="examset" class="action form-control" id="examset">
                                                        <option value="">Select Class</option>
                                                        @foreach ($sets as $row)
                                                            <option value="{{$row->id}}">{{$row->set_name}}</option>
                                                        @endforeach
                                                    </select>

                                            </div>
                                        </div>

                                        <label>Term</label>
                                        <div class="">
                                            <div class="chosen-select-single mg-b-20">
                                                  <select name="term" class="action form-control" id="term">
                                                    <option value="">Select Class</option>
                                                    @foreach ($term as $row)
                                                        <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                  </select>
                                            </div>
                                        </div>

                                        <label></label>
                                        {{-- <div class="">
                                            <div class="login-horizental login-btn-inner">
                                                <button class="btn btn-sm btn-primary login-submit-cs" name="submit" type="submit">Add Marks</button>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>
                            <div class="panel panel-default">

                                <div id="collapse2" class="panel-collapse panel-ic collapse">
                                    <div class="panel-body admin-panel-content animated bounce">

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">

                                <div id="collapse3" class="panel-collapse panel-ic collapse">
                                    <div class="panel-body admin-panel-content animated bounce">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 bg-danger" style="min-height:400pt">
            @include('manage-results.table')
            </div>
        </div>
        @include('manage-results.scripts-marks')

            {{-- end --}}


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
