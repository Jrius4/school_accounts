@section('first-scripts')
    <link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.css')}}">
    <script src="{{asset('schools/plugins/select2/js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('schools/plugins/multiselect/jquery.lwMultiSelect.js')}}"></script>
    <link rel="stylesheet" href="{{asset('schools/plugins/multiselect/jquery.lwMultiSelect.css')}}" />
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
    });


    $("#optional_subjects").select2({
        placeholder: "Select a Optional Subjects",
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
        templateResult:formatRepoOpt,
        templateSelection:formatRepoOptSelection
    });

    function formatRepoOpt(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoOptSelection(repo)
    {
        return repo.name;
    }




    $("#combination").select2({
        placeholder: "Select a Combination",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-a-level-combination')}}",
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

        var $container =$("<span>"+repo.combination_name+"</span>");
        return $container;
    }
    function formatRepoSelection(repo)
    {
        return repo.combination_name;
    }

    // $('#streams1').lwMultiSelect();
    // $('#streams2').lwMultiSelect();
    // $('#streams3').lwMultiSelect();
    $('.action1').change(function(){
        if($(this).val() !='')
        {
                var action = $(this).attr("id");
                var query = $(this).val();
                var result = '';
                if(action == 'schclasses1')
                {
                    result = 'streams1';
                }

                $.ajax({
                    url:"{{url('/fetch-streams')}}",
                    method:"POST",
                    data:{action:action, query:query},
                    success:function(data)
                    {
                        $('#'+result).html(data);

                        if(result == 'streams1')
                        {
                            // $('#streams1').data('plugin_lwMultiSelect').updateList();
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


    $('.action2').change(function(){
        if($(this).val() !='')
        {
                var action = $(this).attr("id");
                var query = $(this).val();
                var result = '';
                if(action == 'schclasses2')
                {
                    result = 'streams2';
                }

                $.ajax({
                    url:"{{url('/fetch-streams')}}",
                    method:"POST",
                    data:{action:action, query:query},
                    success:function(data)
                    {
                        $('#'+result).html(data);

                        if(result == 'streams2')
                        {
                            // $('#streams2').data('plugin_lwMultiSelect').updateList();
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

    $('.action3').change(function(){
        if($(this).val() !='')
        {
                var action = $(this).attr("id");
                var query = $(this).val();
                var result = '';
                if(action == 'schclasses3')
                {
                    result = 'streams3';
                }

                $.ajax({
                    url:"{{url('/fetch-streams')}}",
                    method:"POST",
                    data:{action:action, query:query},
                    success:function(data)
                    {
                        $('#'+result).html(data);

                        if(result == 'streams3')
                        {
                            // $('#streams3').data('plugin_lwMultiSelect').updateList();
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





    $('#insert_data1').on('submit',function(e){
        e.preventDefault();
        $('#streams_hidden1').val($('#streams1').val())
        var formData = new FormData(this);


        $.ajax({
            contentType:false,
            processData:false,
            cache:false,
            data:formData,
            type:'post',
            url:'{{url("/api/register-students")}}',
            success:function(data){
                console.log(data);
            },
            error:function(data){
                console.log(data);
            },
        })
    });

    $('#insert_data2').on('submit',function(e){
        e.preventDefault();
        $('#hidden_streams2').val($('#streams2').val())
        $('#hidden_optional_subjects').val($('#optional_subjects').val())
        var formData = new FormData(this);



        $.ajax({
            contentType:false,
            processData:false,
            cache:false,
            data:formData,
            type:'post',
            url:'{{url("/api/register-students")}}',
            success:function(data){
                console.log(data);
            },
            error:function(data){
                console.log(data);
            },
        })
    });


    $('#insert_data3').on('submit',function(e){
        e.preventDefault();
        $('#streams_hidden3').val($('#streams3').val())
        console.log(`${$('#streams3').val()}`)
        var formData = new FormData(this);



        $.ajax({
            contentType:false,
            processData:false,
            cache:false,
            data:formData,
            type:'post',
            url:'{{url("/api/register-students")}}',
            success:function(data){
                console.log(data);
            },
            error:function(data){
                console.log(data);
            },
        })
    });










    console.log("ready");

});

</script>

@endsection
