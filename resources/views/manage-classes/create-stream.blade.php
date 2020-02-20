


@extends('layouts.main-dashboard')

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
@section('dashboard')


<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{url('/all-streams')}}">Manage Streams</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create New Stream</li>
    </ol>
</nav>

<section class="content">

    <div class="row">
        <div class="col-12">
            <div class="card elevation-2 animated flipInX">
                <div class="card-header row">
                    <h3 class="card-title mr-auto">Create New Stream</h3>
                </div>
                <div class="card-body">

                            <form id="createClassForm" action="javascript:void(0)" method="post">

                            <div class="container row d-flex justify-content-center">
                                <div class="col-md-12 mb-1">
                                    <div id="results"></div>
                                </div>

                                <div class="form-group py-2 col-md-8">
                                    <label for="schclasses">Choose Class(es)</label>


                                    <div class="row">
                                        <select id="schclasses" name="classes" class="form-control bg-transparent d-block" class="col-sm-12" style="color:aliceblue!important" multiple="multiple">
                                            @foreach ($schclasses as $class)
                                            <option value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="schclasses_hidden" id="schclasses_hidden">

                                </div>
                                <div class="form-group py-2 col-md-8">
                                    <label for='name'>Stream Name</label>
                                    <input type="text" name="name" id="nameInput" placeholder="Class Name" class="form-control bg-transparent d-block"/>
                                    <span><small class="text-muted">e.g Stream Name</small></span>
                                </div>
                                <div class="form-group py-2 col-md-8">
                                    <button type="submit" class="btn btn-info col-md-12 d-block">Create Class</button>
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
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.min.css')}}">
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
        placeholder:'Select a Class'
    })

    // $("#schclasses").select2({
    //     placeholder: "Select a class",
    //     allowClear: true,
    //     ajax: {
    //         url: "{{url('/api/get-classes')}}",
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
    //     templateResult:formatRepo,
    //     templateSelection:formatRepoSelection
    // });

    // function formatRepo(repo){
    //     if(repo.loading){
    //         return repo.text
    //     }

    //     var $container =$("<span>"+repo.name+"</span>");
    //     return $container;
    // }
    // function formatRepoSelection(repo)
    // {
    //     return repo.name;
    // }

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

                //    console.log(data)
                // window.location.href = "{{route('classes.index')}}";
                // alert(`${data.message}`);
                if(data !== null)
                {
                    if(data === 'success')
                    {
                        window.location.href = "{{route('classes.index')}}";

                    }
                    if(Object.keys(data)[0]==='errors'){
                        var html = Object.values(data).map(function(item){
                        return `<span class='mx-1'>${(item.name?item.name:'')+"</span><span class='mx-1'>"+(item.classes?item.classes:'')}</span>`;
                            });
                            // console.log(html)
                            $('#results').html(`<div class="alert alert-danger col-sm-6">${html}</div>`);
                    }
                }

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
