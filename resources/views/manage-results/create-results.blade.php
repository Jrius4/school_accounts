@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('roles.index')}}">Manage Roles</a></li>
        <li class="breadcrumb-item active" aria-current="page">Enter Term @if(request()->term == 'term-1'){{'One'}}@elseif(request()->term == 'term-2'){{'Two'}}@elseif(request()->term == 'term-3'){{'Three'}}@endif @if(request()->set == 'b-o-t'){{'Beginning Of Term'}}@elseif(request()->set == 'm-o-t'){{'Mid Of Term'}}@elseif(request()->set == 'e-o-t'){{'End Of Term'}}@endif Results</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated flipInX">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Enter Term @if(request()->term == 'term-1'){{'One'}}@elseif(request()->term == 'term-2'){{'Two'}}@elseif(request()->term == 'term-3'){{'Three'}}@else <script type="text/javascript">$(document).ready(function(){
                    window.location.href = "{{url('/')}}"
                })</script> @endif @if(request()->set == 'b-o-t'){{'Beginning Of Term'}}@elseif(request()->set == 'm-o-t'){{'Mid Of Term'}}@elseif(request()->set == 'e-o-t'){{'End Of Term'}}@else <script type="text/javascript">$(document).ready(function(){
                    window.location.href = "{{url('/')}}"
                })</script>@endif Results</h3>
            </div>
            <div class="card-body">
                            <form action="javascript:void(0)" id="insert_data">

                                <div class="container row d-flex justify-content-center">
                                        <div style="display:none">
                                        <input type="hidden" name="term" value={{request()->term}}><input type="hidden" value={{request()->set}} name="set"><input type="hidden" name="teacher_id" value="{{Auth::user()->id}}">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Class</label>
                                                <select name="schclass" id="schclass" class="action form-control col-12 d-block">
                                                    <option value="">select a class</option>
                                                    @if ($schclasses->count()>0)
                                                        @foreach ($schclasses as $class)
                                                        <option value="{{$class->id}}">{{$class->name}}</option>

                                                        @endforeach
                                                       @else
                                                       <option value="">Your have no class</option>
                                                    @endif
                                                </select>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Subject</label>
                                            <select name="subject" id="subject" class="action form-control col-12 d-block">
                                            </select>
                                        </div>

                                        <div class="form-group col-md-8">
                                           <label>Student</label>

                                            <select name="student" class="action form-control col-12 d-block" id="student"></select>
                                        </div>




                                        <div class="form-group col-md-8">
                                            <label>Does Subject Contain More than One Paper?</label>

                                            <select name="has_papers" class="action form-control col-12 d-block" id="has_papers">
                                                <option value="">Choose either Yes Or No</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-8">
                                            <label>Papers</label>
                                            <div id="papers"></div>
                                            <input type="hidden" name="hidden_marks" id='hidden_marks'>
                                        </div>



                                            <div class="form-group col-md-8">
                                                <button class="btn btn-sm btn-info d-block col-12" name="submit" type="submit">Add Marks</button>
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
    var actionInput =null;
    var class_id ='';
    var subject_id ='';
    var student_id ='';
    var has_papers =null;
    var paper_marks = new Array();


    $('.action').change(function(){
        if($(this).val()!=''){
            var action = $(this).attr('id');
            var query = $(this).val();
            var resuit ='';
            console.log('action:'+action+' query:'+query+' class_id:'+class_id)
            if(action === 'schclass')
            {
                result = 'subject';
                class_id = query;
            }
            if(action === 'subject')
            {
                result = 'student';
                subject_id = query;
            }
            if(action === 'student')
            {
                result = ''
                student_id = query;

            }
            if(action === 'has_papers')
            {
                result ='papers'
            }
            console.log('action:'+action+' query:'+query+' class_id:'+class_id+' subject_id:'+subject_id+' student_id:'+student_id)

            console.log(result)
            $.ajax({
                url:"{{url('/fetch-papers')}}",
                method:"POST",
                data:{action:action, query:query,class_id:class_id,subject_id:subject_id},
                success:function(data)
                {
                    $('#'+result).html(data);
                    console.log(data)

                },
                error:function(data)
                {
                    console.log(data)
                }

            });
        }

    });

    $('#subject').select2({
        placeholder: "Select subject",
    });
    $('#student').select2({
        placeholder: "Select student",
    });


    $("#schclass").select2();
    // $("#schclass").select2({
    //     placeholder: "Select second subject",
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




    // $("#student").select2({
    //     placeholder: "Select Student",
    //     allowClear: true,
    //     ajax: {
    //         url: "{{url('/api/get-students')}}",
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




    // $("#subject").select2({
    //     placeholder: "Select second subject",
    //     allowClear: true,
    //     ajax: {
    //         url: "{{url('/api/get-o-level-subjects')}}",
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
    //     templateResult:formatRepoOSecond,
    //     templateSelection:formatRepoOSecondSelection
    // });

    // function formatRepoOSecond(repo){
    //     if(repo.loading){
    //         return repo.text
    //     }

    //     var $container =$("<span>"+repo.name+"</span>");
    //     return $container;
    // }
    // function formatRepoOSecondSelection(repo)
    // {
    //     return repo.name;
    // }


    $('.marks').on('change',function(e){
        var mark_2 = $('.mark').value;
        paper_marks.push(mark_2);
    });

$('#insert_data').on('submit',function(event){
    var formData = $('#insert_data').serialize();
    // if(||)
    console.log($('.marks').val())
    // var marks = paper_marks.toString();
    // $('#hidden_marks').val(marks)
    console.log(paper_marks)

    $.ajax({
        dataType:'json',
        data:formData,
        type:'post',
        url:'{{url("/store-student-marks")}}',
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


});
</script>

@endsection
