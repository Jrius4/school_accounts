


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
        margin: 5vw 15vw;
    }
</style>
@endsection
@section('admin-content')
		<!-- Static Table Start -->
		<div class="data-table-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="center-items">
                            <form id="createClassForm" action="javascript:void(0)" method="post">

                                <div class="form-group">
                                    <label for='name'>Class Name</label>
                                    <input type="text" name="name" id="nameInput" placeholder="Class Name" class="form-control text-success bg-transparent col-sm-12"/>
                                    <span><small class="text-muted">e.g Senior One</small></span>
                                </div>
                                <div class="form-group">
                                    <label for="roles[]">Level</label>

                                    <select id="level" name="level" class="form-control" class="col-sm-12" style="color:aliceblue!important">
                                        <option value="Not Assigned">Select level</option>
                                        <option value="Ordinary level">Ordinary level</option>
                                        <option value="Advanced level">Advanced level</option>
                                    </select>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info">Create Class</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Static Table End -->

@endsection
@section('scripts')
<script type="text/javascript">
    $(function(){
        $.ajaxSetup({

                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            }

                    });

        $('#createClassForm').on('submit',(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:"POST",
                url:"{{url('/create-classes')}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){

                   console.log(data)
                //    if(err)
                //    {

                //    }
                // window.location.href = "{{route('classes.index')}}";
                // alert(`${data.message}`);

                },

                error: function(data){

                    console.log(data);

                }
                })


        }));
    });
</script>
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
