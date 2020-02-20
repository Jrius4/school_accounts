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

    <div class="container-fluid" style="min-height:90vh">
        <div class="card card-body elevation-4 shadow-sm head-info">
            <h3>WELCOME TO FRIENDS ACADEMY KATENDE</h3>
        </div>
        <div class="container row d-flex justify-content-center mx-auto">


            <div class="col-md-5 card h-100 panel-vh bg-dark elevation-2 shadow-sm mx-1 animated bounce">
                <div class="card-header d-flex justify-content-center">
                    <img src="{{asset('schools/img/logo/log.png')}}" alt="">
                </div>
                <div class="card-body">
                    <h4 class="mb-2">Student/Parent</h4>
                    <form method="post" action="{{ route("login.student") }}" class="my-auto adminpro-form">
                        @csrf
                        <div class="form-group">
                            <label for="roll_number">Student Roll Number <i class="fa fa-credit-card login-user" aria-hidden="true"></i></label>
                            <input type="text"  autocomplete="off" name="roll_number" required class="form-control bg-transparent text-light d-block col-md-12"/>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn btn-info btn-block d-block col-md-12"/>
                        </div>
                        <div class="form-group"></div>


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

                            <input id="username" type="text" class="form-control bg-transparent text-light d-block col-md-12 @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus/>

                            @error('username')
                                <span class="invalid-feedback text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="roll_number">Password</label>

                            <input id="password" type="password" class="form-control bg-transparent text-light d-block col-md-12 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"/>

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




    </div>
<footer class="container-fluid">
            <strong>Copyright &copy; {{date('Y')}} <a href="#">ntechnology</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.2
            </div>
</footer>

@endsection
