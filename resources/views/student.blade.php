@extends('layouts.main')
@section('styles')
<style>
    .paragraphs p{
        display: inline;
        margin-inline-start: 0.5rem;
    }
    .dropdown-item:hover{
        background-color: #3c4650;
    }
</style>
@endsection

@section('full-content')
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

<div class="container-fluid">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark elevation-4 shadow-md">
    <a class="navbar-brand" href="#">FRIENDS ACADEMY KATENDE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      {{-- <ul class="navbar-nav mx-auto">
        <li class="nav-item active">
          <a class="nav-link" href="{{url('/student')}}">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{url('/student-results')}}">Results</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/student-fees">Fees Records</a>
        </li>

      </ul> --}}
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
            <a class="nav-link" href="{{url('/student')}}">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/student-previous-results')}}">Past Results</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('/student-current-results')}}">This Term Results</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/student-fees">Fees Records</a>
          </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$student->name}}
            </a>
            <div class="dropdown-menu bg-dark text-light animated flipInX" aria-labelledby="navbarDropdownMenuLink">
                {{-- <a class="dropdown-item" href="#">Action</a> --}}

                <a class="dropdown-item" href="{{route('logout')}}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf

                </form>
            </div>
          </li>
      </ul>
    </div>
  </nav>

  <div class="row card elevation-2 shadow-sm bg-dark text-light mx-1 my-2 p-2">
      <div class="ml-auto paragraphs">

            @if (isset($student->image))

            <p>
                <img width="50" height="50" class="img-circle" src="{{asset('images/'.$student->image)}}" alt="{{$student->name}}">
            </p>

            @endif

          <p>{{$student->name}}</p>
          <p>{{$student->roll_number}}</</p>
          <p>{{$student->schclass->name}}</</p>
      </div>


  </div>


  <div class="row d-flex justify-content-center">

    <user-dashboard-component></user-dashboard-component>

    @yield('content')

  </div>


</div>



@endsection
@section('script')
  <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

@endsection


