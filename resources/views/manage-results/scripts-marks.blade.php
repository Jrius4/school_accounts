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
    var set_id ='';
    var term_id ='';
    var subject_id ='';
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
                result = '';
                subject_id = query;
            }
            if(action === 'examset')
            {
                result = ''
                set_id = query;

            }
            if(action === 'term')
            {
                result ='resultz';
                term_id=query
            }
            console.log('action:'+action+' query:'+query+' class_id:'+class_id+' subject_id:'+subject_id+' set_id:'+set_id+' term_id:'+term_id)

            console.log(result)
            $.ajax({
                url:"{{url('/manage-marks')}}",
                method:"POST",
                data:{action:action, query:query,class_id:class_id,subject_id:subject_id,set_id:set_id,term_id:term_id},
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
    $('#schclass').select2({
        placeholder: "Select Class",
    });
    $('#examset').select2({
        placeholder: "Select Set",
    });
    $('#term').select2({
        placeholder: "Select Term",
    });



});

</script>

@endsection
