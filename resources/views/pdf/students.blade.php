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
<body>
    <h4>Students</h4>
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

            @foreach ($results as $res)
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
    <script type="text/javascript">
        $(document).ready(function(){
                console.log('ewjrke')
                $('#students').rowspanizer({vertical_align: 'middle'});
                $('#students2').rowspanizer({vertical_align: 'middle'});
        });

    </script>
</body>
</html>
