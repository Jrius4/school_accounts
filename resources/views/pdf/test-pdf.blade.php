<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/materia/bootstrap.min.css" rel="stylesheet" integrity="sha384-uKLgCN8wZ+yo4RygxUNFhjywpL/l065dVTzvLuxys7LAIMmhZoLWb/1yP6+mF925" crossorigin="anonymous"> --}}
    {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}

    <link rel="stylesheet" href="{{asset('pdf/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('pdf/style.css')}}">
    <style>
        /* *{
            -webkit-print-color-adjust: exact;
        } */
        /* body {
            padding: .5in;
            } */
            @page {
        size: 21cm 29.7cm;
        margin: 0;
        }
    </style>
</head>
<body>
    <div class="">
        <table class="table table-sm table-dark">
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Goals
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="3">Kazibwe Julius Junior</td>
                    <td>Coding</td>
                </tr>
                <tr>
                    <td>Making Parents Happy</td>
                </tr>
                <tr>
                    <td>Being Rich</td>
                </tr>
                @foreach ($data as $item)
                    <tr>
                        <td rowspan="{{count($item['goals'])}}">{{$item['name']}}</td>
                        <td>{{$item['goals'][0]}}</td>
                    </tr>
                    @foreach (array_slice($item['goals'],1) as $goal)
                    <tr>
                        <td>
                            {{$goal}}
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
