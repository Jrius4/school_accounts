@section('scripts')





<script type="text/javascript">


     $(document).ready(function(){
        var arrNew = Array()
        arrNew.push([{'name':'90'}])
        arrNew.push([{'last':'234'}])
        console.log({arrNew})


    $.ajaxSetup({
        headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });




        @if($items->count()>0)
            $.ajax({
                type:'GET',
                url:'{{route("expenses.fetch-items")}}',
                success:function(data){
                    $('#results').html(data)

                },
                error:function(data){
                }
            })
        @endif
        var result =new Array();



        $('.action-acc').change(function(){

            if($(this).val()!='')
            {

                    var action = $(this).attr('id');
                    var query = $(this).val();


                    if(action === 'term')
                    {

                        if(result.length===0)
                        {
                            result.push({'term':query});
                            $('#term').removeClass('is-invalid');
                            $('#expense-term-error').html('');
                        }

                        if(result.length === 1)
                        {
                            for (let index = 0; index < result.length; index++) {
                                const element = result[index];
                                for (const key in element){
                                    if (element.hasOwnProperty(key)) {
                                        const element3 = element[key];
                                        if(key != 'term')
                                        {
                                            result.push({'term':query});
                                            $('#term').removeClass('is-invalid');
                                            $('#expense-term-error').html('');
                                        }
                                    }
                                }
                            }
                        }




                        if(result.length>0)
                        {

                            for (let index = 0; index < result.length; index++) {
                                const element = result[index];
                                for (const key in element) {
                                    if (element.hasOwnProperty(key)) {
                                        const element3 = element[key];
                                        if(key === 'term')
                                        {
                                            result[index] ={'term':query}
                                        }
                                    }
                                }
                            }
                        }

                    }

                    if(action === 'category')
                    {
                        if(result.length === 0)
                        {
                            $('#term').addClass('is-invalid');
                            var html = '<p class="text-danger">Term field empty</p>'
                            $('#expense-term-error').html(html);
                            result.push({'category':query});

                        }
                        if(result.length === 1)
                        {
                            for (let index = 0; index < result.length; index++) {
                                const element = result[index];
                                for (const key in element){
                                    if (element.hasOwnProperty(key)) {
                                        const element3 = element[key];
                                        if(key != 'category')
                                        {
                                            result.push({'category':query});
                                        }
                                    }
                                }
                            }
                        }



                        if(result.length>0)
                        {
                            for (let index = 0; index < result.length; index++) {
                                const element = result[index];
                                for (const key in element){
                                    if (element.hasOwnProperty(key)) {
                                        const element3 = element[key];
                                        if(key == 'category')
                                        {
                                            result[index] ={'category':query}
                                        }
                                    }
                                }
                            }
                        }

                    }

                    console.log(result)

                    if(result.length==2){
                        var term = '';
                        var category = '';
                        console.log(Object.keys(result[1])[0]);

                        if(Object.keys(result[0])[0]==='term') {term = Object.values(result[0])[0];}
                        if(Object.keys(result[1])[0]==='term') {term = Object.values(result[1])[0];}
                        if(Object.keys(result[0])[0]==='category') {category = Object.values(result[0])[0];}
                        if(Object.keys(result[1])[0]==='category'){ category = Object.values(result[1])[0];}
                        var grand_total = $('#grand-total').val()
                        var seletedAcc = '';
                        // console.log({'grand_total':grand_total,'term':term,'acc_category':category})
                        $.ajax({
                                    type:'POST',
                                    data:{'grand_total':grand_total,'term':term,'acc_category':category},
                                    url:'{{route('expenses.get-results')}}',
                                    success:function(data){
                                        $('#borrowing').html(data.output)
                                        console.log(data)
                                    },
                                    error:function(data){
                                        console.log(data);
                                    }
                                });
                    }
            }




        })


       $('#add-item').click(function(e){
            e.preventDefault();
        var nom = parseInt($('#rowNum').val());
        nom+=1;
        $('#rowNum').val(nom);

        var oldRow = $('#addField').html();

        var query = nom;
        nom-=1;

        var item = $(`#item`).val();
        var quantity = $(`#quantity`).val();
        var units = $(`#units`).val();
        var rate = $(`#rate`).val();

        $(`#item`).removeClass('is-invalid');
        $(`#quantity`).removeClass('is-invalid');
        $(`#units`).removeClass('is-invalid');
        $(`#rate`).removeClass('is-invalid');
        $(`#report`).html('');



         $.ajax({
                    type:'POST',
                    data:{'query':query,'item':item,'quantity':quantity,'units':units,'rate':rate},
                    url:'{{route('expenses.get-form')}}',
                    success:function(data){

                        $('#oldField').html('');
                        $('#oldField').html(data.output);
                        $('#results').html(data.output2);

                    },
                    error:function(data){
                        console.log(data.responseJSON);
                        var numErr = data.responseJSON.errors;
                        var message = data.responseJSON.message;
                        var html = "";
                        html+=`
                            <div class="row container d-flex justify-content-center">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    `;

                        html+=`<h6>${message}</h6>`;
                            for (const key in numErr) {
                                if (numErr.hasOwnProperty(key)) {
                                    const element = numErr[key];

                                    $(`.${key}`).addClass('is-invalid');
                                    console.log(element[0])

                                    html+=`<p>${element[0]}</p>`;
                                }
                            }

                            html+=`<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>`;
                            $("#report").html(html);


                    }


                });





       });

       console.log($('#remain').val())



     });



function removeList(id){
    confirm('Are You sure')
    $.ajax({
        type:'POST',
        data:{id},
        url:"{{route('remove-item')}}",
        success:function(data){
            
            window.location.href = "{{route('expenses.create')}}"
        },
        error:function(data){
            console.log(data)
        }
    })
}


var arrOut = new Array();
var arrBorrow = new Array();


const tableRowClick=(name,amount,selected)=>
{
    // arrOut.push({selected})

  document.getElementById(name).style.backgroundColor = '#0cb519'
  document.getElementById(name).style.color = '#fff'
    if(arrOut.length===0)
    {
    arrOut.push({selected})
    }
  if(arrOut.length===1)
  {
    arrOut.push({name,amount})
  }

  if(arrOut.length>1)
  {

    var i = arrOut.length-1
    if(!checkItem({name,amount}))
    {

      arrOut.push({name,amount})
    }
    else if(checkItem({name,amount}) && i != 1 && i != 0)
    {
      var arr2 = new Array();
      document.getElementById(name).style.backgroundColor = '#888686'
      document.getElementById(name).style.color = 'white'
      arrOut.forEach(element => {
        if(element.name!=name)
        {
        //   arr2.push({selected})
          arr2.push(element)
        }
      });
      arrOut = [];
      arr2.forEach(element=>{
          arrOut.push(element)
      })
    }


  }


//   console.log(arrOut)
  $.ajax({
      type:"POST",
      data:{arrOut,arrBorrow},
      url:'{{route("expenses-borrow.inputs")}}',
      success:function(data){
          console.log(data)
          $('#BorrowAcc').html(data)
      },
      error:function(data){
          console.log(data)
      },
  })
}



const checkItem = (item)=>{
  var i = arrOut.length;

  if(i>0)
  {

    for (let index = 0; index < arrOut.length; index++) {
      const element = arrOut[index];
      if(element.name === item.name)
      {
        return true;
      }

    }
  }
}

var collected = 0;
var arrBorrow2 = new Array();

function addBorrow(acc_name,amount,row){
    var borrow = $('#borrow-'+row).val();
    var regex= /^[0-9]+$/;
    if((borrow%1)!== 0)
    {
        $('#borrow-'+row).addClass('is-invalid');
        html=`<p class='text-danger text-center'>is Input Number field</p>`;
        $('#inform-'+row).removeClass('d-none');
        $('#inform-'+row).addClass('d-block');
        $('#inform-'+row).html(html);
    }
    else if(borrow === ''){
        $('#borrow-'+row).addClass('is-invalid');
        html=`<p class='text-danger text-center'>Please full field</p>`;
        $('#inform-'+row).removeClass('d-none');
        $('#inform-'+row).addClass('d-block');
        $('#inform-'+row).html(html);
    }
    else if(borrow!=='' && (borrow%1)=== 0)
    {
        $('#inform-'+row).removeClass('d-block');
        $('#inform-'+row).removeClass('d-none');
        $('#inform-'+row).addClass('d-none');
        var html = `<p class='text-success text-center'>Added</p>`
        $('#inform-'+row).html(html);
        $('#borrow-'+row).removeClass('is-invalid')



        arrBorrow = [];
        if(arrBorrow2.length === 0)
        {
            collected+=parseInt(borrow)
            var html1 = collected.toString()+'/=';
            var remain = parseInt($('#remaining').val())+collected
            var html2 = remain.toString()+'/=';
            $('#coll-amount').html(html1);
            $('#coll-remain').html(html2);

            arrBorrow2.push({acc_name,amount,row,borrow})
        }

        if(arrBorrow2.length>0)
        {
            if(!checkBorrow(acc_name,amount,row,borrow))
            {
                arrBorrow2.push({acc_name,amount,row,borrow})
            }
            var i = arrBorrow2.length-1;
            // else if(checkBorrow({acc_name,amount,row,borrow}) && i!==0)
            // {
            //     var arr2 = new Array()
                // arrBorrow2.forEach(element=>{
                //     if(element.acc_name!==acc_name)
                //     {
                //         arr2.push(element)
                //     }
                // });
                // arrBorrow2=[]
                // arr2.forEach(element=>{
                //         arrBorrow2.push(element)
                // })
            // }
            // else if(1>0){
            //     console.log(big)
            // }
        }



        arrBorrow2.forEach(element => {
                arrBorrow.push(element)
        });
        console.log({arrBorrow})
    }

}

function checkBorrow(item)
{
    var i = arrBorrow2.length;
    if(i>0)
    {
        for (let index = 0; index < i; index++) {
            const element = arrBorrow2[index];
            if(element.acc_name === item.acc_name)
            {
                return true
            }

        }
    }
}
// return confirm(`Are you sure?`);
$('#removeForm').on('submit',function (e) {
    // e.preventDefault();
    // var formData = new FormData()
    // console.log(formData)
})
</script>
@endsection
