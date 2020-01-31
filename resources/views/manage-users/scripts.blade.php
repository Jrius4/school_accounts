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

    $("#roles").select2({
        placeholder: "Select a staff",
        allowClear: true,
        ajax: {
            url: "{{url('/api/get-roles')}}",
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

        var $container =$("<span>"+repo.display_name+"</span>");
        return $container;
    }
    function formatRepoSelection(repo)
    {
        return repo.display_name;
    }
    $('#createUserForm').on('submit',(function(e){
        e.preventDefault();

        var roles= $('#roles').val();
        $('#hidden_roles').val(roles);
        var formData = new FormData(this);


        $.ajax({
            type:"POST",
            url:"{{route('users.store')}}",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){

            //    console.log(data)
            window.location.href = "{{route('users.index')}}";
            // alert(`${data.message}`);

            },

            error: function(data){

                console.log(data);

            }

        });
    }));


});

</script>

@endsection
