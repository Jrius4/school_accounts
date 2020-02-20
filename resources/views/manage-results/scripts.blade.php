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
