<!DOCTYPE html>

<html>

<head>

    <title>Laravel 5 - Ajax Image Uploading Tutorial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
{{--
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script src="http://malsup.github.com/jquery.form.js"></script> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<style>
    .avatar-pic {
    width: 300px;
    }
</style>
</head>

<body>


{{-- <div class="container">

  <h1>Laravel 5 - Ajax Image Uploading Tutorial</h1>


  <form action="{{ route('ajaxImageUpload') }}" enctype="multipart/form-data" method="POST">


  	<div class="alert alert-danger print-error-msg" style="display:none">

        <ul></ul>

    </div>


    <input type="hidden" name="_token" value="{{ csrf_token() }}">


    <div class="form-group">

      <label>Alt Title:</label>

      <input type="text" name="title" class="form-control" placeholder="Add Title">

    </div>


	<div class="form-group">

      <label>Image:</label>

      <input type="file" name="image" class="form-control">

    </div>


    <div class="form-group">

      <button class="btn btn-success upload-image" type="submit">Upload Image</button>

    </div>


  </form>





</div> --}}

<div class="container">
    <h3 class="text-center">Files</h3>
    <form id="imageUploadForm" action="javascript:void(0)" method="post" enctype="multipart/form-data">
        <div class="file-field">
            <div class="row">
                <div class="col-md-8 mb-4">
                    <img id="original" src="" alt="" class="z-depth-1-half  avatar-pic"/>
                    <div>
                        <input type="file" name="image" id="photo_ima"><br>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </div>

        </div>

        <div class=" col-md-4 mb-4">
            <img id="thumbImg" src="" class=" z-depth-1-half thumb-pic"
            alt="">
            </div>

    </form>
</div>


<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
        headers: {

    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }
    });

    $('#imageUploadForm').on('submit',(function(e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type:"POST",
            url:"{{url('save-image')}}",
            data:formData,

   cache:false,

   contentType: false,

   processData: false,

   success:function(data){

       $('#original').attr('src', '{{asset("images")}}'+'/'+ data.image);

       $('#thumbImg').attr('src', 'public/thumbnail/'+ data.image);

   },

   error: function(data){

       console.log(data);

   }

        });
    }))
})


</script>


{{-- <script type="text/javascript">

  $("body").on("click",".upload-image",function(e){

    $(this).parents("form").ajaxForm(options);

  });


  var options = {

    complete: function(response)

    {

    	if($.isEmptyObject(response.responseJSON.error)){

    		$("input[name='title']").val('');

    		alert('Image Upload Successfully.');

    	}else{

    		printErrorMsg(response.responseJSON.error);

    	}

    }

  };


  function printErrorMsg (msg) {

	$(".print-error-msg").find("ul").html('');

	$(".print-error-msg").css('display','block');

	$.each( msg, function( key, value ) {

		$(".print-error-msg").find("ul").append('<li>'+value+'</li>');

	});

  }

</script> --}}


</body>

</html>
