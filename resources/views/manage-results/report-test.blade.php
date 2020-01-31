

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Papers</th>
                    <th>Marks</th>
                    <th>Set</th>
                    <th>term</th>
                    <th>Class</th>
                    <th>Stream</th>
                </tr>
            </thead>
            <tbody>
                {{$id = 0}}
                @foreach ($results->orderBy('student_id')->get() as $res)
                    <tr>
                        <td>{{++$id}}</td>
                        <td>{{$res->student->name}}</td>
                        <td>{{$res->subject->name}}</td>

                            @if ($res->paper !=null)
                                <td>
                                    {{$res->paper->paper_abbrev}}
                                </td>
                                <td>
                                    {{$res->mark}}
                                </td>
                            @else
                            <td colspan="2">
                                {{$res->mark}}
                            </td>
                            @endif
                        <td>{{$res->exmset->set_name}}</td>
                        <td>{{$res->term->name}}</td>
                        <td>{{$res->schclass->name}}</td>
                        <td>{{$res->student->schstream->name}}</td>


                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
