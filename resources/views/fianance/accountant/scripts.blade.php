<script type="text/javascript">

$.ajaxSetup({
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
        });

    $(function(){
        $('#typename').change(function(e){
            var valueName = $(this).val();

            $.ajax({
                headers:{
                    Authorization: "Bearer "+localStorage.getItem('access_token')
                },
                url:"{{url('/api/getloan')}}",
                method:'POST',
                data:{query:valueName},
                success:function(data){
                    if(data !== null){
                       $('#typeInput').html(data)
                    }


                },
                error:function(data){
                    console.log(data)
                },
            })
        })
    })
</script>
