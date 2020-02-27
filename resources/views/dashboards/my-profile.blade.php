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
     <div class="row d-flex justify-content-center col-10">

        <div class="card card-dark col-12 p-0">
            <div class="card-header">
                <h3 class="card-title">My Profile</h3>
            </div>
            <div class="card-body col-md-8">
                <h2>Name</h2>
                <p>
                    {{$user->name}}
                </p>
                <h2>Name</h2>
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
