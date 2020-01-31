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
</style>
@endsection
@section('admin-content')


		<!-- Static Table Start -->
		    <div class="row">
                <div id="results"></div>


                <div class="center-contents">
                    <form id="insert_paper_data" action="javascript:void(0);" method="post">
                        @csrf



        <div class="form admin-panel-content animated bounce">



            <div class="container center-form">
                <span id="feature"></span>
            </div>
            <div class="container row  center-form">
                <div class="col-md-8 form-details">
                    <div class="form-group py">
                        <label for="sub_comp">Subject Name</label>
                        <select name="subject_name" id="subject_name" class="form-control col-sm-12" multiple="multiple"></select>
                        <input type="hidden" name="subject_name_hidden" id="subject_name_hidden">
                    </div>


                    <div class="form-group py">
                        <label for="paper_name">Paper Name</label>
                        <input type="text" name="paper_name" id="paper_name" placeholder="Paper Name" class="form-control col-sm-12">
                    </div>



                <div class="col-md-8 py">
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </div>
            </div>
    </div>


<style>
    .center-form{
        display: flex;
        justify-content: center;
        width: 90%;
        margin-left: 5vw;
        margin-right: 5vw;

    }

.chk-class{
display: flex;
flex-wrap: wrap;
padding: 5px;
height: 250x;

}
.checklist{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: start;
}
.chk .input-controls{
    display: flex;
    flex-wrap: wrap;
    color:aliceblue;
}
.checked-styled{
    display: inline;
    height: 15px;
    margin: 0.3vw;
    padding: 0.4vw;
}
.class-div{
    margin: 5px;
    padding-left: 5px;
}

.big-label{
padding-left: 10px;
padding-top:2px;
}
.checked-styled-stream{
padding-left: 25px;
padding-top: 3px

}

</style>




                    </form>
                </div>
                @include('manage-subjects.script')
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
