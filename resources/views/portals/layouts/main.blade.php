<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Friends Academy</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @include('portals.layouts.main-head')


</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper"  id="app">
        @include('portals.layouts.main-navbar')
        @include('portals.layouts.main-sidebar')
        <div class="sessionOut d-none">
            <form action="javascript:void(0)" id="insertdata12" method="POST">
                @csrf
                @auth
                    <input type="hidden" name="timer" value="{{config('session.lifetime')}}" class="sessTimer">
                @endauth
                @guest
                <input type="hidden" name="timer" value="" class="sessTimer">
                @endguest
            </form>
        </div>
        {{-- @include('portals.layouts.main-content') --}}
        @include('portals.layouts.main-footer')
        @include('portals.layouts.main-controlbar')
    </div>
<script type="text/javascript" async src="{{mix('js/app.js')}}"></script>
@include('portals.layouts.main-scripts')


<script type="text/javascript">
    $(document).ready(function(){

            $.ajaxSetup({
                // Authorization: "Bearer " + localStorage.getItem('access_token'),
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
            });




        var timer = $('.sessTimer').val();
        console.log(timer)
        // if(timer != "")
        // {
        //     var i = 0
        //     var timer =parseInt(timer)*1000*60 + 5;

        //     setInterval(function(){
        //         window.location.href = "{{auth()->user()!==null ?route('logoutUser'):route('login')}}";
        //     }, timer);

        // }

    });
</script>





</body>
</html>
