<script type="text/javascript">
var reciever_id = '';
var my_id = {{auth()->user()->id}};
console.log({reciever_id,my_id});
$(document).ready(function(){

    Echo
    .channel('messenger-channel')
    .listen('MessengerEvent',(data)=>{

        if(my_id === data.from)
        {
            $('#'+data.to).click();

        }
        else if(my_id === data.to){


            if(reciever_id == data.from){

                $('#'+data.from).click();
            }
            else{



                var pending = parseInt($('#'+data.from).find('.pending').html())

                if(pending){
                    $('#'+data.from).find('.pending').html(pending + 1)

                }
                else{
                    $('#'+data.from).append('<span class="pending">1</span>')

                }




        }

        }


    });
    $('.user').click(function(){
        $('.user').removeClass('active-messenger');
        $(this).addClass('active-messenger');
        $(this).find(".pending").remove();
        reciever_id = $(this).attr('id')

        $.ajax({
            type:'get',
            url:"/messenger/"+reciever_id,
            data:"",
            cache:false,
            success:function(data){
                $('#messenger').html(data);
                scrollToDownFunction();
            },
            error:function(data){
                console.log({data})
            },

        })
    });

    $(document).on('keyup','.input-text input',function(e){
        var message = $(this).val();
        if(e.keyCode == 13 && message !== '' && reciever_id !== ""){

            $(this).val('');

            var datastr = "reciever_id="+reciever_id+"&message="+message;
            $.ajax({
                type:"POST",
                url:"messenger",
                data:datastr,
                cache:false,
                success:function(data){

                },
                error:function(data){

                },
                complete:function(){
                    scrollToDownFunction();
                }
            })
        }

    });
});

function scrollToDownFunction(){
    $('.messenger-wrapper').animate({
        scrollTop:$('.messenger-wrapper').get(0).scrollHeight
    },50);
}
</script>
