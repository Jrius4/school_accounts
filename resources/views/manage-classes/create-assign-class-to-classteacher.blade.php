@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('classes.index')}}">Manage Classes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Assign Class To Class Teacher</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated flipInX">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Create Assign Class To Class Teacher</h3>
            </div>
            <div class="card-body">

                            <form id="createClassForm" action="javascript:void(0)" method="post">
                                <div class="container row d-flex justify-content-center">
                                <div class="form-group col-sm-12">
                                    <label for="schclasses">Choose Class(es)</label>


                                        <select id="schclasses" name="schclasses" class="form-control action form-control-lg">
                                            <option value="">Select a class</option>
                                            @foreach ($schclasses as $class)
                                                <option value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                        </select>


                                </div>
                                <div class="form-group col-sm-12">
                                    <label for='name'>Select Stream(s)</label>

                                    <br />
                                    <select name="streams" id="streams" multiple class="form-control">
                                    </select>
                                    <br />
                                    <input type="hidden" name="hidden_streams" id="hidden_streams" />
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="teacher">Class Teacher</label>
                                    <div class="row">
                                        <select id="teacher" name="teacher" class="col-sm-12 form-control">
                                            <option value="">Select a Teacher</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="is_class_teacher" value="1">
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <button type="submit" class="btn btn-info d-block col-sm-12">Save</button>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            </section>
@endsection
@section('first-scripts')
 <!-- jQuery -->
 <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.min.css')}}">
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
            $("#schclasses").select2();

    $('#streams').lwMultiSelect();
    $('.action').change(function(){
        if($(this).val() !='')
        {
                var action = $(this).attr("id");
                var query = $(this).val();
                var result = '';
                if(action == 'schclasses')
                {
                    result = 'streams';
                }

                $.ajax({
                    url:"{{url('/fetch-streams')}}",
                    method:"POST",
                    data:{action:action, query:query},
                    success:function(data)
                    {
                        $('#'+result).html(data);

                        if(result == 'streams')
                        {
                            $('#streams').data('plugin_lwMultiSelect').updateList();
                        }
                        // console.log(data)
                    },
                    error:function(data)
                    {
                        console.log(data)
                    }

                })

        }

    });

    $("#teacher").select2();


    // $("#teacher").select2({
    //     placeholder: "Select a class teacher",
    //     allowClear: true,
    //     ajax: {
    //         url: "{{url('/api/get-teachers')}}",
    //         dataType: 'json',
    //         delay:250,
    //         data:function(params){
    //             var query = {
    //                 q:params.term,
    //                 page:params.page
    //             };
    //             return query;
    //         },
    //         processResults: function (data, params) {
    //             params.page = params.page||1;

    //             return {
    //                 results: data.data,
    //                 pagination: {
    //                     more: (params.page * 10) < data.total
    //                 }
    //             };
    //         },
    //         success:function(data)
    //         {
    //             console.log(data.data);
    //         },
    //         error:function(data)
    //         {
    //             console.log(data);
    //         },
    //         cache:true,


    //     },
    //     minimumInputLength:1,
    //     templateResult:formatRepoTeacher,
    //     templateSelection:formatRepoTeacherSelection
    // });

    // function formatRepoTeacher(repo){
    //     if(repo.loading){
    //         return repo.text
    //     }

    //     var $container =$("<span>"+repo.name+"</span>");
    //     return $container;
    // }
    // function formatRepoTeacherSelection(repo)
    // {
    //     return repo.name;
    // }



        $('#createClassForm').on('submit',(function(e){
            e.preventDefault();
            var classes= $('#schclasses').val();
            $('#schclasses_hidden').val(classes);
            var streams= $('#streams').val();
            $('#hidden_streams').val(streams);
            var formData = new FormData(this);
            $.ajax({
                type:"POST",
                url:"{{url('/assign-class-to-classteacher')}}",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){

                    // alert('Data Inserted');
                    if(Object.keys(data) == 'errors')
                    {
                        var html = Object.values(data).map(function(item){
                                return `<p>${(item.streams?item.streams:'')+"</p><p>"+(item.schclasses?item.schclasses:'')+"</p><p>"+(item.teacher?item.teacher:'')+"</p><p>"+(item.Info?item.Info:'')}</p>`;

                        });

                        $('#info').html(`<div class="alert alert-danger col-sm-6">${html}</div>`);
                        console.log(html)
                        console.log(data)
                    }
                    if(data == 'done')
                    {
                        window.location.href = "{{route('classes.index')}}";
                    }
                    $('#streams').html('');
                    $('#streams').data('plugin_lwMultiSelect').updateList();
                    $('#streams').data('plugin_lwMultiSelect').removeAll();
                    $('#createClassForm')[0].reset();

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
