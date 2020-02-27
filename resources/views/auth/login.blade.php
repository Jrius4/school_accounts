@extends('layouts.main')
@section('styles')
<style>
body{
    background-color: #516369;
}
.panel-vh{
 min-height: 100%
}
.head-info{
    color: antiquewhite;
    background-color: #323638;

}
footer{
    background-color: #242b2d;
    color: antiquewhite;

}
footer a{
    color: #61e490;
}
</style>

@endsection
@section('full-content')

    <div class="container-fluid" style="min-height:98vh">
        <div class="card card-body elevation-4 shadow-sm head-info">
            <h3>WELCOME TO FRIENDS ACADEMY KATENDE</h3>
        </div>
        <div class="container row d-flex justify-content-center mx-auto">


            <div class="col-md-5 card h-100 panel-vh bg-dark elevation-2 shadow-sm mx-1 animated bounce">
                <div class="card-header d-flex justify-content-center">
                    <img src="{{asset('schools/img/logo/log.png')}}" alt="">
                </div>
                <div class="form-group d-lg py-1"></div>
                <div class="card-body">
                    <h4 class="mb-2">Student/Parent</h4>
                    <form method="post" action="{{ route("login.student") }}" class="my-auto adminpro-form">
                        @csrf
                        <div class="form-group">
                            <label for="roll_number">Student Roll Number </label>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text bg-dark text-light" id="basic-addon1"><i class="fa fa-credit-card login-user" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" placeholder="Roll Number" autocomplete="off" name="roll_number" class="form-control bg-transparent text-light d-block col-md-12 @error('roll_number') is-invalid @enderror" aria-label="roll_number" aria-describedby="basic-addon1"/>
                              </div>
                            @error('roll_number')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ "Dear Student,".$message }}</strong>
                                </span>
                            @enderror
                            {{-- @if (isset($message))
                            <span class="invalid-feedback text-danger" role="alert">
                                <strong>{{ "Dear Student,".$message }}</strong>
                            </span>
                            @endif --}}
                            <input type="hidden" name="password" value="student">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn btn-info btn-block d-block col-md-12"/>
                        </div>
                        <div class="form-group d-lg py-4"></div>


                    </form>
                </div>
            </div>

           <div class="col-md-5 card h-100 bg-dark elevation-2 shadow-sm mx-1 animated bounce">
                <div class="card-header d-flex justify-content-center">
                    <img src="{{asset('schools/img/logo/log.png')}}" alt="">
                </div>
                <div class="card-body">
                    <h4 class="mb-2">Administration</h4>
                    <form class="adminpro-form" method="POST" action='{{ url("/") }}' aria-label="{{ __('Login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="roll_number">Username</label>

                            <input id="username" placeholder="username" type="text" class="form-control bg-transparent text-light d-block col-md-12 @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus/>

                            @error('username')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="roll_number">Password</label>

                            <input id="password" placeholder="password" type="password" class="form-control bg-transparent text-light d-block col-md-12 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>

                            @error('password')
                                <span class="invalid-feedback  text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" required class="btn btn-info btn-block d-block col-md-12"/>
                        </div>



                    </form>
                </div>
           </div>

        </div>

<div class="col-lg-12">

    <div class="row container my-2 mx-auto text-white">
        <div class="mr-auto col-sm-6">
            <div class="">
                <h4>Users</h4>
                <h6>Password: 123456</h6>
                @foreach (App\User::get() as $user)
                <div class="row d-flex justify-content-center">
                    <div class="mr-auto">
                        <h5>Username</h5>
                        <p>{{$user->username}}</p>
                    </div>
                    <div class="ml-auto">
                        <h5>Roles:</h5>
                        <ul class="list-group">
                            @foreach ($user->roles as $role)
                                <li class="list-group-item bg-dark">{{$role->display_name}}</li>
                            @endforeach
                        </ul>

                    </div>
                </div>
                @endforeach
            </div>
        </div>



        <div class="ml-auto col-sm-6">
            <ul class="list-group ml-auto col-sm-6">
                <h4>Students</h4>
                <h5>Roll Number</h5>
                @foreach (App\Models\Student::get() as $stud)
                <li class="list-group-item bg-dark">
                    {{$stud->roll_number.' Class: '. $stud->schclass->name}}
                </li>
                @endforeach
            </ul>
        </div>




    </div>

</div>


    </div>
<footer class="container-fluid">
            <strong>Copyright &copy; {{date('Y')}} <a href="#">ntechnology</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.2
            </div>
</footer>

@endsection
@section('script')
  <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection
