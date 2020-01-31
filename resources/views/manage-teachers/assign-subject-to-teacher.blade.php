


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
        background: #0e0d0d;
        padding: 8pt;
    }
</style>
@endsection
@section('admin-content')
		<!-- Static Table Start -->
		<div class="data-table-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="center-items animated flipInX">
                            <form id="createClassForm" action="javascript:void(0)" method="post">
                                <div class="form-group col-sm-12">
                                    <label for="schclasses">Choose Level</label>


                                    <div class="row">
                                        <select id="level" name="level" class="form-control action col-sm-12" style="color:aliceblue!important">
                                            <option value="">Select Level ...</option>
                                            <option value="Both">Both</option>
                                            <option value="Advanced Level">Advanced Level</option>
                                            <option value="Ordinary Level">Ordinary Level</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group col-sm-12">
                                    <label for='subjects'>Select Stream(s)</label>

                                    <br />
                                    <select name="subjects" id="subjects" multiple class="form-control col-sm-12">
                                    </select>
                                    <br />
                                    <input type="hidden" name="hidden_subjects" id="hidden_subjects" />
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="teacher">Teacher</label>
                                    <div class="row">
                                        <select id="teacher" name="teacher" class="col-sm-12 form-control" style="color:aliceblue!important">
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group col-sm-12">
                                    <button type="submit" class="btn btn-info">Save</button>
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
    <script type="text/javascript" src="{{asset('schools/plugins/multiselect/jquery.lwMultiSelect.js')}}"></script>
   <link rel="stylesheet" href="{{asset('schools/plugins/multiselect/jquery.lwMultiSelect.css')}}" />

@endsection
@section('scripts')
<script type="text/javascript">
    $(function(){
        $.ajaxSetup({

                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            }

                    });
    $('#subjects').lwMultiSelect();
    $('.action').change(function(){
        var samp = $(this).val();
        var samp2 = $(this).attr("id");
        console.log(samp,samp2)
        if($(this).val() !='')
        {
                var action = $(this).attr("id");
                var query = $(this).val();
                var result = '';
                if(action == 'level')
                {
                    result = 'subjects';
                }

                $.ajax({
                    url:"{{url('/fetch-subjects')}}",
                    method:"POST",
                    data:{action:action, query:query},
                    success:function(data)
                    {

                        $('#'+result).html(data);

                        if(result == 'subjects')
                        {
                            $('#subjects').data('plugin_lwMultiSelect').updateList();
                        }

                    },
                    error:function(data)
                    {
                        console.log(data)
                    }

                })

        }

    });


    $("#teacher").select2({
        placeholder: "Select a class teacher",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-teachers')}}",
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
        templateResult:formatRepoTeacher,
        templateSelection:formatRepoTeacherSelection
    });

    function formatRepoTeacher(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoTeacherSelection(repo)
    {
        return repo.name;
    }



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
            var subjects= $('#subjects').val();
            $('#hidden_subjects').val(subjects);
            var formData = new FormData(this);
            $.ajax({
                type:"POST",
                url:"{{url('/assign-subject-to-teacher')}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    console.log(data);
                    $('#subjects').html('');
                    $('#subjects').data('plugin_lwMultiSelect').updateList();
                    $('#subjects').data('plugin_lwMultiSelect').removeAll();
                    $('#createClassForm')[0].reset();
                    // alert('Data Inserted');
                    if(Object.keys(data) == 'errors')
                    {
                        console.log(data)
                    }
                    if(data == 'done')
                    {
                        window.location.href = "{{route('classes.index')}}";
                    }

                // console.log(Object.keys(data))

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
