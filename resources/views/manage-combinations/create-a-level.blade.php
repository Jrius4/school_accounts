@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('manage-combinations.index')}}">Manage Combinations</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create New Combinations</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated flipInX">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Create New COmbinations</h3>
            </div>
            <div class="card-body">


                    <form id="insert_a_level_data" action="javascript:void(0);" method="post">
                        @csrf


                            <div class="container row d-flex justify-content-center">
                                @include('manage-combinations.form-a-level')
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

@section('style')

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>
@endsection
@section('scripts')

<script type="text/javascript">
$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#first_subject").select2();
    $("#second_subject").select2();
    $("#third_subject").select2();


    // $("#first_subject").select2({
    //     placeholder: "Select first subject",
    //     allowClear: true,
    //     ajax: {
    //         url: "{{url('/api/get-a-level-subjects')}}",
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
    //     templateResult:formatRepoFirst,
    //     templateSelection:formatRepoFirstSelection
    // });

    // function formatRepoFirst(repo){
    //     if(repo.loading){
    //         return repo.text
    //     }

    //     var $container =$("<span>"+repo.name+"</span>");
    //     return $container;
    // }
    // function formatRepoFirstSelection(repo)
    // {
    //     return repo.name;
    // }



    // $("#second_subject").select2({
    //     placeholder: "Select second subject",
    //     allowClear: true,
    //     ajax: {
    //         url: "{{url('/api/get-a-level-subjects')}}",
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
    //     templateResult:formatRepoSecond,
    //     templateSelection:formatRepoSecondSelection
    // });

    // function formatRepoSecond(repo){
    //     if(repo.loading){
    //         return repo.text
    //     }

    //     var $container =$("<span>"+repo.name+"</span>");
    //     return $container;
    // }
    // function formatRepoSecondSelection(repo)
    // {
    //     return repo.name;
    // }



    // $("#third_subject").select2({
    //     placeholder: "Select third subject",
    //     allowClear: true,
    //     ajax: {
    //         url: "{{url('/api/get-a-level-subjects')}}",
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
    //     templateResult:formatRepoThird,
    //     templateSelection:formatRepoThirdSelection
    // });

    // function formatRepoThird(repo){
    //     if(repo.loading){
    //         return repo.text
    //     }

    //     var $container =$("<span>"+repo.name+"</span>");
    //     return $container;
    // }
    // function formatRepoThirdSelection(repo)
    // {
    //     return repo.name;
    // }

    $("#student_name").select2({
        placeholder: "Select Student",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-students')}}",
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
        templateResult:formatRepoThird,
        templateSelection:formatRepoThirdSelection
    });

    function formatRepoThird(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoThirdSelection(repo)
    {
        return repo.name;
    }


    $("#first_o_subject").select2({
        placeholder: "Select first subject",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-o-level-subjects')}}",
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
        templateResult:formatRepoOFirst,
        templateSelection:formatRepoOFirstSelection
    });

    function formatRepoOFirst(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoOFirstSelection(repo)
    {
        return repo.name;
    }



    $("#second_o_subject").select2({
        placeholder: "Select second subject",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-o-level-subjects')}}",
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
        templateResult:formatRepoOSecond,
        templateSelection:formatRepoOSecondSelection
    });

    function formatRepoOSecond(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoOSecondSelection(repo)
    {
        return repo.name;
    }



    $("#third_o_subject").select2({
        placeholder: "Select third subject",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-o-level-subjects')}}",
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
        templateResult:formatRepoOThird,
        templateSelection:formatRepoOThirdSelection
    });

    function formatRepoOThird(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoOThirdSelection(repo)
    {
        return repo.name;
    }



$('#insert_a_level_data').on('submit',function(event){
    var formData = $('#insert_a_level_data').serialize();

    $.ajax({
        dataType:'json',
        data:formData,
        type:'post',
        url:'{{url("/manage-combinations-A-level")}}',
        success:function(data){
            console.log(data)
        if(Object.keys(data)=='errors')
        {
            var html = Object.values(data).map(function(item){
                    return `<p>${(item.first_subject?item.first_subject:'')+"</p><p>"+(item.second_subject?item.second_subject:'')+"</p><p>"+(item.third_subject?item.third_subject:'')+"</p><p>"+(item.combination_name?item.combination_name:'')+"</p><p>"+(item.subsidiary?item.subsidiary:'')}</p>`;
            });

            $('#results').html(`<div class="alert alert-danger col-sm-6">${html}</div>`);
        }
        if(Object.keys(data)=='success'){
            window.location.href = "{{route('manage-combinations.index')}}";

        }

        },
        error:function(data){
            console.log(data)
        },
    });



});

$('#insert_o_level_data').on('submit',function(event){
    var formData = $('#insert_o_level_data').serialize();

    $.ajax({
        dataType:'json',
        data:formData,
        type:'post',
        url:'{{url("/manage-combinations-O-level")}}',
        success:function(data){
            console.log(data)
        if(Object.keys(data)=='errors')
        {
            var html = Object.values(data).map(function(item){
                    return `<p>${(item.first_subject?item.first_subject:'')+"</p><p>"+(item.second_subject?item.second_subject:'')+"</p><p>"+(item.third_subject?item.third_subject:'')+"</p><p>"+(item.combination_name?item.combination_name:'')+"</p><p>"+(item.subsidiary?item.subsidiary:'')}</p>`;
            });
            console.log(html)
            $('#results').html(`<div class="alert alert-danger col-sm-6">${html}</div>`);
        }
        if(Object.keys(data)=='success'){
            // window.location.href = "{{route('manage-combinations.index')}}";
            console.log(data)

        }

        },
        error:function(data){
            console.log(data)
        },
    });



});








});
</script>

@endsection
