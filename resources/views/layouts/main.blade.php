<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Friends Academy Kitende</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{mix('css/app.css')}}"/>
    <script type="text/javascript">


        window.Laravel =  {"csrfToken":'{{csrf_token()}}'};

    </script>

    @if(!auth()->guest())
        <script type="text/javascript">
            window.Laravel.userId = {{auth()->user()->id}};
        </script>
    @elseif(!auth()->guest('students'))
    <script type="text/javascript">
        window.Laravel.userId = {{auth()->guard('students')->user()->id}};
        // window.Laravel.following_admin = {{auth()->user()->isFollowing(1)}};
    </script>

    @endif

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- animate CSS
		============================================ -->
	<link rel="stylesheet" href="{{asset('schools/css/animate.css')}}">
	<!-- normalize CSS
		============================================ -->
    {{-- <link rel="stylesheet" href="{{asset('schools/css/normalize.css')}}"> --}}
    <!-- adminpro icon CSS
		============================================ -->
    {{-- <link rel="stylesheet" href="{{asset('schools/css/adminpro-custon-icon.css')}}"> --}}

    <style>
    body{
        background-color: #516369;
    }
    .wrapper{
        min-height: 100vh;
    }
    .profile-pic:hover{
        transform: scale(1.8);
        transition-duration: 2s;
    }
    </style>
    @yield('api-token')
    @yield('styles')
    @yield('style')
    @yield('first-scripts')
    <link rel="shortcut icon" href="{{asset('schools/img/favicon.ico')}}" type="image/x-icon">
</head>
<body class="hold-transition sidebar-mini layout-fixed ">

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
    <div  class="wrapper" id="app">
        @yield('full-content')
    </div>


    <script src="{{mix('js/app.js')}}"></script>



@yield('script')
@yield('others-scripts')

@yield('scripts')

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
