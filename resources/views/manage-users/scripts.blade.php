@section('other-scripts')
        <!-- jQuery -->
    <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.min.css')}}">
    <script src="{{asset('schools/plugins/select2/js/select2.full.min.js')}}"></script>

{{-- @endsection

@section('others-scripts') --}}

<script src="{{asset('adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>

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

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })

    // $('#editdata').submit(function(e){
    //     e.preventDefault();
    //     var formData = $('#editdata').serialize()
    //     console.log(formData)
    // });


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
