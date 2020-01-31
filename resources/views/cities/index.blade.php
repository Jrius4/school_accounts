<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Insert Dynamic </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <link rel="stylesheet" href="{{asset('css/app.css')}}">
   <script src="{{asset('js/app.js')}}"></script>

   <script type="text/javascript" src="{{asset('schools/plugins/multiselect/jquery.lwMultiSelect.js')}}"></script>
   <link rel="stylesheet" href="{{asset('schools/plugins/multiselect/jquery.lwMultiSelect.css')}}" />
</head>
<body>
    <br /><br />
		<div class="container" style="width:600px;">
			<h2 class="text-center">Insert Dynamic Multi Select Box Data using Jquery Ajax PHP</h2><br /><br />
			<form method="post" id="insert_data">
				<select name="country" id="country" class="form-control action">
					<option value="">Select Country</option>
                   @foreach ($result as $row)
                       <option value="{{$row->country}}">{{$row->country}}</option>
                   @endforeach
				</select>
				<br />
				<select name="state" id="state" class="form-control action">
					<option value="">Select State</option>
				</select>
				<br />
				<select name="city" id="city" multiple class="form-control">
				</select>
				<br />
				<input type="hidden" name="hidden_city" id="hidden_city" />
				<input type="submit" name="insert" id="action" class="btn btn-info" value="Insert" />
			</form>
		</div>

<script>


    $(document).ready(function(){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $('#city').lwMultiSelect();

        $('.action').change(function(){
            if($(this).val() != '')
            {
                var action = $(this).attr("id");
                var query = $(this).val();
                var result = '';
                if(action == 'country')
                {
                    result = 'state';
                }
                else
                {
                    result = 'city';
                }
                $.ajax({
                    url:"{{url('/fetch-cities')}}",
                    method:"POST",
                    data:{action:action, query:query},
                    success:function(data)
                    {
                        $('#'+result).html(data);

                        if(result == 'city')
                        {
                            $('#city').data('plugin_lwMultiSelect').updateList();
                        }
                    },
                    error:function(data)
                    {
                        console.log(data)
                    }

                })
            }
        });

        $('#insert_data').on('submit', function(event){
            event.preventDefault();
            if($('#country').val() == '')
            {
                alert("Please Select Country");
                return false;
            }
            else if($('#state').val() == '')
            {
                alert("Please Select State");
                return false;
            }
            else if($('#city').val() == '')
            {
                alert("Please Select City");
                return false;
            }
            else
            {
                $('#hidden_city').val($('#city').val());
                // $('#action').attr('disabled', 'disabled');
                var form_data = $(this).serialize();
                $.ajax({
                    url:"{{route('cities.store')}}",
                    method:"POST",
                    data:form_data,
                    success:function(data)
                    {
                        // $('#action').attr("disabled", "disabled");
                        // if(data == 'done')
                        // {
                        //     $('#city').html('');
                        //     $('#city').data('plugin_lwMultiSelect').updateList();
                        //     $('#city').data('plugin_lwMultiSelect').removeAll();
                        //     $('#insert_data')[0].reset();
                        //     alert('Data Inserted');
                        // }

                            $('#city').html('');
                            $('#city').data('plugin_lwMultiSelect').updateList();
                            $('#city').data('plugin_lwMultiSelect').removeAll();
                            $('#insert_data')[0].reset();
                            alert('Data Inserted');
                        console.log(data)
                    }
                });
            }
        });

    });
    </script>
</body>
</html>
