<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <div id="app" class="container">
        {{-- <make-expense></make-expense> --}}
        <h5 class="text-center">Realtime Search</h5>

        <div class="col w-100"></div>
        <selectfield-component></selectfield-component>

    </div>


    <script async src="{{asset('js/app.js')}}"></script>

</body>
</html>
