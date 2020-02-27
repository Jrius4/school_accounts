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
    bsCustomFileInput.init();
    $("#roles").select2({
        placeholder:"Select a Staff"
    });

    $('#roles').change(function(){
        var query = $(this).val()
        $('#hidden_roles').val(query)
    })


    // $('#createUserForm').on('submit',(function(e){
    //     e.preventDefault();

    //     var roles= $('#roles').val();
    //     $('#hidden_roles').val(roles);
    //     var formData = new FormData(this);


        // $.ajax({
        //     type:"POST",
        //     url:"{{route('users.store')}}",
        //     data:formData,
        //     cache:false,
        //     contentType: false,
        //     processData: false,
        //     success:function(data){

            //    console.log(data)
            // window.location.href = "{{route('users.index')}}";
            // alert(`${data.message}`);

            // },

            // error: function(data){

            //     console.log(data);

            // }

        // });
    // }));


});

</script>

@endsection
