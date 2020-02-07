

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('schools/plugins/rowspanizer/jquery.rowspanizer.js')}}"></script>


</head>
<style>
.sm{
background: #d27272
}
</style>
<body>
    <div class="container">
        <a href="{{url('/')}}">&raquo;&raquo;</a>|<a href="{{url('/pdf/print-results')}}" class="btn btn-sm btn-light"><i class="fa big-icon fa-print"></i> print</a>|
        <button class="btn btn-sm btn-success" onclick="PrintElem('#students')" id="print_pdf"><i class="fa big-icon fa-print"></i> PDF</button>
        <table class="table table-bordered" id="students">
            <thead>
                <tr>
                    <th>Name</th>
                    <th colspan="2">Subject</th>
                    <th>Marks</th>
                    <th>Set</th>
                    <th>term</th>
                    <th>Class</th>
                    <th>Stream</th>
                </tr>
            </thead>
            <tbody>
                <div class="d-none">{{$id = 0}}</div>

                @foreach ($results->orderBy('student_id')->get() as $res)
                    <tr>
                        <td>{{$res->student->name}}</td>
                        @if ($res->paper !=null)
                            <td>{{$res->subject->name}}</td>
                            <td>
                                {{$res->paper->paper_abbrev}}
                            </td>
                            <td>
                                {{$res->mark}}
                            </td>
                            <td>{{$res->exmset->set_name}}</td>
                            <td>{{$res->term->name}}</td>
                            <td>{{$res->schclass->name}}</td>
                            <td>{{$res->student->schstream->name}}</td>
                        @else
                            <td>{{$res->subject->name}}</td>
                            <td>{{null}}</td>
                            <td>
                                {{$res->mark}}
                            </td>
                            <td>{{$res->exmset->set_name}}</td>
                            <td>{{$res->term->name}}</td>
                            <td>{{$res->schclass->name}}</td>
                            <td>{{$res->student->schstream->name}}</td>
                        @endif



                    </tr>

                @endforeach
            </tbody>
        </table>

        <div class="row mt-2">

            <table class="table table-bordered" id="students2">
                @foreach ($result_list as $student=>$mark_list)

                <tr style="background:#fff;color:#d27272">
                    {{-- <th colspan="{{$$mark_list->count()}}">{{$student}}</th> --}}
                    <th colspan="7">{{$students->find($student)->name}}</th>
                </tr>
                @foreach ($mark_list->groupBy('subject_id') as $sub=>$res2)
                    <tr style="background:#8e8a8a;color:#e4e7ff">
                        <td rowspan={{$res2->count()+1}}>{{$subjects->find($sub)->name}}</td>
                    </tr>

                    @foreach ($res2 as $res)
                        <tr>
                            @if ($res->paper_id != null)
                                <td>
                                    {{$res->paper->paper_abbrev}}
                                </td>
                            @else
                                <td>{{null}}</td>
                            @endif
                                <td>{{$res->mark}}</td>
                                <td>{{$res->grade}}</td>

                                <td>{{$res->exmset->set_name}}</td>
                                <td>{{$res->term->name}}</td>


                        </tr>
                    @endforeach


                @endforeach





                @endforeach
            </table>



        </div>

        <div id="content">
            <h3>Hello, this is a H3 tag</h3>

           <p>a pararaph</p>
       </div>
       <div id="editor"></div>
       <button id="cmd">generate PDF</button>
    </div>
    <script src="{{asset('schools/plugins/jsPDF/jspdf.min.js')}}"></script>
    <script type="text/javascript">
$(document).ready(function(){
        console.log('ewjrke')
        var doc = new jsPDF();
        var specialElementHandlers = {

        }
        $('#students').rowspanizer({vertical_align: 'middle'});
        $('#students2').rowspanizer({vertical_align: 'middle'});

        $('#print_pdf').on('click',function(e){
            e.preventDefault();
            console.log('clicked')
            $('#sutdents').printElement();
        })


        var doc = new jsPDF();
        var specialElementHandlers = {
            '#editor': function (element, renderer) {
                return true;
            }
        };

        $('#cmd').click(function () {
            doc.fromHTML($('#students').html(), 15, 15, {
                'width': 170,
                    'elementHandlers': specialElementHandlers
            });
            doc.save('sample-file.pdf');
        });

});

    </script>

</body>
</html>
