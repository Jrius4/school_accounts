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

    $("#first_subject").select2({
        placeholder: "Select first subject",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-a-level-subjects')}}",
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
        templateResult:formatRepoFirst,
        templateSelection:formatRepoFirstSelection
    });

    function formatRepoFirst(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoFirstSelection(repo)
    {
        return repo.name;
    }



    $("#second_subject").select2({
        placeholder: "Select second subject",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-a-level-subjects')}}",
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
        templateResult:formatRepoSecond,
        templateSelection:formatRepoSecondSelection
    });

    function formatRepoSecond(repo){
        if(repo.loading){
            return repo.text
        }

        var $container =$("<span>"+repo.name+"</span>");
        return $container;
    }
    function formatRepoSecondSelection(repo)
    {
        return repo.name;
    }



    $("#third_subject").select2({
        placeholder: "Select third subject",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-a-level-subjects')}}",
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
