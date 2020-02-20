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

    $("#subject_name").select2();


    // $("#subject_name").select2({
    //     placeholder: "Select subject(s)",
    //     allowClear: true,
    //     ajax: {
    //         url: "{{url('/api/get-subjects')}}",
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

// $('#insert_data').on('submit',function(event){
//     var formData = $('#insert_data').serialize();

//     $.ajax({
//         dataType:'json',
//         data:formData,
//         type:'post',
//         url:'{{route("subjects.store")}}',
//         success:function(data){
//             console.log(data)
//         if(Object.keys(data)=='errors')
//         {
//             var html = Object.values(data).map(function(item){
//                     return `<p>${(item.level?item.level:'')+"</p><p>"+(item.name?item.name:'')+"</p><p>"+(item.subject_code?item.subject_code:'')+"</p><p>"+(item.subject_compulsory?item.subject_compulsory:'')}</p>`;
//             });
//             console.log(html)
//             $('#results').html(`<div class="alert alert-danger col-sm-6">${html}</div>`);
//         }
//         if(data== 'success'){
//             window.location.href = "{{route('subjects.index')}}";

//         }

//         },
//         error:function(data){
//             console.log(data)
//         },
//     });



// });


// $('#insert_paper_data').on('submit',function(event){
//    var subjects = $('#subject_name').val()
//    $('#subject_name_hidden').val(subjects)
//     var formData = $('#insert_paper_data').serialize();
//     console.log(formData);

//     $.ajax({
//         dataType:'json',
//         data:formData,
//         type:'post',
//         url:'{{url("/assign_paper_subjects")}}',
//         success:function(data){

//         if(Object.keys(data)=='errors')
//         {
//             var html = Object.values(data).map(function(item){
//                     return `<p>${(item.subject_name?item.subject_name:'')+"</p><p>"+(item.paper_name?item.paper_name:'')}</p>`;
//             });

//             $('#results').html(`<div class="alert alert-danger col-sm-6">${html}</div>`);
//         }
//         if(Object.keys(data) == 'success'){
//             window.location.href = "{{route('subjects.index')}}";
//             // console.log(Object.values(data))
//             // var html = Object.values(data).map(function(item){
//             //         return `<p>${(item.subject_name?item.subject_name:'')+"</p><p>"+(item.name?item.name:'')}</p>`;
//             // });

//             // $('#results').html(`<div class="alert alert-danger col-sm-6">${html}</div>`);

//             // $('#results').html(`<div class="alert alert-success col-sm-6">${html}</div>`);

//         }

//         },
//         error:function(data){
//             console.log(data)
//         },
//     });
// });



});
</script>

@endsection
