@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
    </ol>
</nav>


<section class="content">

<section class="container-fluid">


     <!-- Small boxes (Stat box) -->
     <div class="row d-flex justify-content-center col-md-10">

        <div class="card card-dark mx-auto col-12 p-0 animated bounce">
            <div class="card-header">
                <h3 class="card-title">My Profile</h3>
            </div>
            <div class="card-body col-md-8">
                <h2>Name</h2>
                <p>
                    {{$user->name}}
                </p>
                <h2>Username</h2>
                <p>
                    {{$user->username}}
                </p>
                <h2>My Roles</h2>
                <ul class="list-group">
                    @if ($user->roles->count()>0)
                        @foreach ($user->roles as $row)

                            <li class="list-group-item">{{$row->display_name}}</li>

                        @endforeach
                    @else
                       <p>No Role Assigned</p>
                    @endif
                </ul>
                <p>
                    {{$user->username}}
                </p>


            </div>

        </div>

      </div>
      <!-- /.row -->
@section('script')
 <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection







</section>



@endsection




@section('style')

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>

@endsection
