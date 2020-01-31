<!DOCTYPE html>

<html>

<head>

<title>Results</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
    <link rel="stylesheet" href="{{asset('datatablefiles/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('datatablefiles/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('datatablefiles/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.css')}}">

    <script src="{{asset('datatablefiles/jquery.js')}}"></script>
    <script src="{{asset('datatablefiles/jquery.validate.js')}}"></script>
    <script src="{{asset('datatablefiles/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('datatablefiles/bootstrap.min.js')}}"></script>
    <script src="{{asset('datatablefiles/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('schools/plugins/select2/js/select2.full.min.js')}}"></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script> --}}


</head>

<body class="bg-dark text-white" style="min-height:800px">



<div class="container">


    <a class="btn btn-info" href="javascript:void(0)" id="createNewProduct"> Create New Student Marks</a>

    <div class="row">
        <span id="messages"></span>
    </div>
    <table class="table table-bordered data-table">

        <thead>

            <tr>

                <th>No</th>

                <th>Student Roll Number</th>
                <th>Student Name</th>
                <th>Subject</th>
                <th>Marks</th>
                <th>Comment</th>

                <th width="280px">Action</th>

            </tr>

        </thead>

        <tbody>

        </tbody>

    </table>

</div>



<div class="modal fade" id="ajaxModel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content bg-dark text-white">

            <div class="modal-header">

                <h4 class="modal-title" id="modelHeading"></h4>

            </div>

            <div class="modal-body">

                <form id="resultsForm" name="resultsForm" class="form-horizontal">

                    <input type="hidden" name="result_id" id="result_id">
                    <input type="hidden" class="form-control bg-transparent text-white" id="teacher_id" name="teacher_id" value="{{Auth::user()->id}}" maxlength="50" required="">


                    <div class="form-group">

                        <label for="name" class="col-sm-12 control-label">Student Registration Number</label>

                        <div class="col-sm-12">

                            <input type="text" class="form-control bg-transparent text-white" id="student_regno" name="student_regno" placeholder="Enter Name" value="" maxlength="50" required="">

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="name" class="col-sm-12 control-label">Subject Name</label>

                        <div class="col-sm-12">

                            <input type="text" class="form-control bg-transparent text-white" id="subject_name" name="subject_name" placeholder="Enter Subject Name" value="" maxlength="50" required="">

                        </div>

                    </div>
                    <div class="form-group">

                        <label for="name" class="col-sm-12 control-label">Marks</label>

                        <div class="col-sm-12">

                            <input type="number" class="form-control bg-transparent text-white" id="marks" name="marks" placeholder="Enter Marks" value="" maxlength="50" required="">

                        </div>

                    </div>



                    <div class="form-group">

                        <label class="col-sm-6 control-label">Comments</label>

                        <div class="col-sm-12">

                            <textarea id="comments" name="comments" required="" placeholder="Enter comments" class="form-control bg-transparent text-white"></textarea>

                        </div>

                    </div>



                    <div class="col-sm-offset-2 col-sm-10">

                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes

                     </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<div class="container row">

    <div class="col-lg-12 text-dark">

        <form id="form_data" method="post">

            <select name="city" class="city"  style="width:400px" multiple="multiple">

                <option value="AL">Alabama</option>
                <option value="NY">New York</option>
                <option value="UG">Uganda</option>
                <option value="KY">Kenya</option>

            </select>
            <select name="city" class="city2">

                <option value="AL">Alabama</option>
                <option value="NY">New York</option>
                <option value="UG">Uganda</option>
                <option value="KY">Kenya</option>

            </select>
        </form>
        </div>
        <form id='select2_data' name="select2_data">
            <select id="ajaxDataSel" class="form-control m-4" name="information" style="width:200px;"></select>
            <input type="submit" id="selectBtn" class="btn btn-warning" value="Submit">
        </form>

</div>


</body>



<script type="text/javascript">

  $(function () {



      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

    });


    $('.city2').select2();
    $('.city').select2({
                placeholder:'select an option ajax',
            });

    $('#selStd').select2({
        ajax:{
            url:"{{url('/api/students')}}",
            dataType:'json',
            delay:250,
            data:function(params){
                return {
                            q:params.term,
                            page:params.page
                        };
            },
            processResults:function(data,params){
                params.page = params.page || 1;
                return {
                    results:data.data,
                    pagination:{
                        more:(params.page * 10)<data.total
                    }
                };
            },
            minimumInputLength:1,
            templateResult:function(repo){
                if(repo.loading) return repo.name;
                var markup = "<span>"+repo.roll_number+" "+repo.name+"</span>";
                return markup;
            },
            templateSelection:function(repo){
                return repo.name;
            },
            escapeMarkup:function(markup){
                return markup;
            }
        }
    });

    $('#selectBtn').click(function(e){
        e.preventDefault();
        $(this).html('checking');
        console.log($('#ajaxDataSel').val())
        console.log($('#select2_data').serialize())
        // $.ajax({
        //     data:$('#select2_data').serialize(),
        // });
    });

    $("#ajaxDataSel").select2({
        placeholder: "Select a inspector",
        allowClear: true,
        ajax: {
            url: "http://schools.dev.com/api/get-students",
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

        var $container =$("<span>"+repo.roll_number+" "+repo.name+"</span>");
        return $container;
    }
    function formatRepoSelection(repo)
    {
        return repo.name;
    }




    var table = $('.data-table').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('manage-students-results.index') }}",

        columns: [

            {data: 'DT_RowIndex', name: 'DT_RowIndex'},

            {data: 'student_regno', name: 'student_regno'},
            {data: 'student_name', name: 'student_name'},

            {data: 'subject_name', name: 'subject_name'},
            {data: 'marks', name: 'marks'},
            {data: 'comments', name: 'comments'},

            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    });



    $('#createNewProduct').click(function () {

        $('#saveBtn').val("create-product");

        $('#result_id').val('');

        $('#resultsForm').trigger("reset");

        $('#modelHeading').html("Create New Result Record");

        $('#ajaxModel').modal('show');

    });



    $('body').on('click', '.editProduct', function () {

      var result_id = $(this).data('id');

      $.get("{{ route('manage-students-results.index') }}" +'/' + result_id +'/edit', function (data) {

          $('#modelHeading').html("Edit Result Record");

          $('#saveBtn').val("edit-user");

          $('#ajaxModel').modal('show');

          $('#result_id').val(data.id);

          $('#teacher_id').val(data.teacher_id);
          $('#student_regno').val(data.student_regno);
          $('#subject_name').val(data.subject_name);
          $('#marks').val(data.marks);

          $('#comments').val(data.comments);

      })

   });



    $('#saveBtn').click(function (e) {

        e.preventDefault();

        $(this).html('Sending..');



        $.ajax({

          data: $('#resultsForm').serialize(),

          url: "{{ route('manage-students-results.store') }}",

          type: "POST",

          dataType: 'json',

          success: function (data) {



              $('#resultsForm').trigger("reset");

              $('#ajaxModel').modal('hide');

              table.draw();
              if(Object.keys(data) == "success")
              {
                  Object.values(data).map((item)=>{
                        $('#messages').html(`<span class="alert alert-success">${item}</span>`).delay(500).fadeIn('normal',function(){
                            $(this).delay(5000).fadeOut();
                        });;

                  })
              }
              if(Object.keys(data) == "error-short")
              {
                  Object.values(data).map((item)=>{
                        $('#messages').html(`<span class="alert alert-danger">${item}</span>`).delay(500).fadeIn('normal',function(){
                            $(this).delay(5000).fadeOut();
                        });;

                  })
              }

              if(Object.keys(data) == "errors")
              {
                results = Object.values(data);

                    for(item in results)
                    {
                        $('#messages').html(`<span class="alert alert-danger">${Object.values(results[item])}</span>`).delay(500).fadeIn('normal',function(){
                            $(this).delay(5000).fadeOut();
                        });
                    }



              }



          },

          error: function (data) {

              console.log('Error:', data);

              $('#saveBtn').html('Save Changes');

          }

      });

    });



    $('body').on('click', '.deleteProduct', function () {



        var result_id = $(this).data("id");

        confirm("Are You sure want to delete !");



        $.ajax({

            type: "DELETE",

            url: "{{ route('manage-students-results.store') }}"+'/'+result_id,

            success: function (data) {

                table.draw();


            },

            error: function (data) {

                console.log('Error:', data);

            }

        });

    });



  });

</script>

</html>
