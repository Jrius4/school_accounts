@section('first-scripts')
 <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.min.css')}}">
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

    $('#subjects').select2({
        placeholder:"Select optional subjects",
    })

    $('#combination').select2({
        placeholder:"Select combination",
    })

    $('.action').change(function(e){
        e.preventDefault();
        var opt = $('.action').val()
        // $('#opt_id').val() = opt
        $('#opt_id').val(opt);
        var tt = $('#opt_id').val()
        console.log(tt)
    });

    // $().submit(function(){

    // })




});

</script>

@endsection
