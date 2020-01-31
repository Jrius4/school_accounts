


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
                                    <label for="schclasses">Choose Class(es)</label>


                                    <div class="row">
                                        <select id="schclasses" name="schclasses" class="form-control" class="col-sm-12" style="color:aliceblue!important" multiple="multiple">
                                        </select>
                                    </div>
                                    <input type="hidden" name="schclasses_hidden" id="schclasses_hidden">

                                </div>
                                <div class="form-group">
                                    <label for='name'>Stream Name</label>
                                    <input type="text" name="name" id="nameInput" placeholder="Class Name" class="form-control text-success bg-transparent col-sm-12"/>
                                    <span><small class="text-muted">e.g Senior One</small></span>
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
@section('first-scripts')
    <link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.css')}}">
    <script src="{{asset('schools/plugins/select2/js/select2.full.min.js')}}"></script>

@endsection
@section('scripts')
<script type="text/javascript">
    $(function(){
        $.ajaxSetup({

                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            }

                    });

    $("#schclasses").select2({
        placeholder: "Select a class",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-classes')}}",
            dataType: 'json',
            delay:250,
            data:function(params){
                var query = {
                    q:params.term,
                    page:params.page
                };
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page||1;

                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 10) < data.total
                    }
                };
            },
            success:function(data)
            {
                console.log(data.data);
            },
            error:function(data)
            {
                console.log(data);
            },
            cache:true,


        },
        minimumInputLength:1,
        templateResult:formatRepo,
        templateSelection:formatRepoSelection
    });

    function formatRepo(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoSelection(repo)
    {
        return repo.name;
    }

        $('#createClassForm').on('submit',(function(e){
            e.preventDefault();
            var classes= $('#schclasses').val();
            $('#schclasses_hidden').val(classes);
            var formData = new FormData(this);
            $.ajax({
                type:"POST",
                url:"{{url('/create-streams')}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){

                   console.log(data)
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
