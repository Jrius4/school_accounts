@section('scripts')

<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var html = '';
    html = "<h2>Feature Test</h2>"
$('#feauture').html(html);
$('#roles').lwMultiSelect();
$('#subjects').lwMultiSelect();

// var rootNode = [
//         {
//             "id": "1",
//             "title": "Senior 6",
//             "value": 1,
//             "children": [
//                             {
//                                 "id": "0-1",
//                                 "title": "Physical",
//                                 "value": "Physical",
//                             },
//                             {
//                                 "id": "0-2",
//                                 "title": "Chemical",
//                                 "value": 12,
//                             },
//                             {
//                                 "id": "0-3",
//                                 "title": "Biological",
//                                 "value": 13,

//                             }
//                         ]
//         },
//         {
//             "id": "2",
//             "title": "Senior 5",
//             value: 2,
//             "children": [
//                             {
//                                 "id": "0-1",
//                                 "title": "Physical",
//                                 "value": 21,
//                             },
//                             {
//                                 "id": "0-2",
//                                 "title": "Chemical",
//                                 "value": 22,
//                             },
//                             {
//                                 "id": "0-3",
//                                 "title": "Biological",
//                                 "value": 23,

//                             }
//                         ]
//         }
//     ];
//     console.log(rootNode)

//       $('div.treeSelector').treeSelector(rootNode, [], function (e, values) {
//         console.info('onChange', e, values);
//       }, {
//         checkWithParent: true,
//         titleWithParent: true,
//         notViewClickParentTitle: true
//       });


$.ajax({
    url:"{{url('/get-roles')}}",
    method:"GET",
    success:function(data){
        $('#roles').html(data);
        if(data!=null)
        {
            $('#roles').data('plugin_lwMultiSelect').updateList();
        }
    },
    error:function(data){
        console.log(data)
    }

});
$.ajax({
    url:"{{url('/get-subjects')}}",
    method:"GET",
    success:function(data){
        $('#subjects').html(data);
        if(data!=null)
        {
            $('#subjects').data('plugin_lwMultiSelect').updateList();
        }
    },
    error:function(data){
        console.log(data)
    }

});

$.ajax({
    url:"{{url('/get-classes')}}",
    method:"GET",
    success:function(data){
        // $('#subjects').html(data);
        var classesStr;
        if(data!=null)
        {
            console.log(data.data)
            classesStr = data.data;
                    $('div.treeSelector').treeSelector(classesStr, [], function (e, values) {
                                                            console.info('onChange', e, values);
                                                            $('#hidden_classes').val(values)
                                                            // var res = values.toString()
                                                            // $('#hidden_classes').val(res.forEach(item => {item.split("_")}))

                                                        }, {
                                                            checkWithParent: true,
                                                            titleWithParent: true,
                                                            notViewClickParentTitle: true
                                                        });
        }
    },
    error:function(data){
        console.log(data)
    }

});

$('#insert_data').on('submit',function(event){
    event.preventDefault();
    $('#hidden_role').val($('#roles').val());
    $('#hidden_subject').val($('#subjects').val());
    var form_data =  $("#insert_data").serialize();
    console.log(form_data);

    $.ajax({
    url:"{{url('/get-roles')}}",
    method:"POST",
    data:form_data,
    success:function(data){

        if(data!=null)
        {
            // console.log(data);

            var html = Object.values(data).map(function(item){
                    return `<span class='mx-1'>${(item.level?item.level:'')+"</span><span class='mx-1'>"+(item.name?item.name:'')+"</span><span class='mx-1'>"+(item.hidden_subject?'select atleast one subject':'')+"</span><span class='mx-1'>"+(item.hidden_role?'select atleast one role':'')+"</span><span class='mx-1'>"+(item.hidden_classes?'select atleast one class':'')+"</span><span class='mx-1'>"+(item.password?item.password:'')}</span>`;
            });
            // console.log(html)
            $('#results').html(`<div class="alert alert-danger col-sm-6">${html}</div>`);
        }
    },
    error:function(data){
        console.log(data)
    }

});
});



});
</script>

@endsection
