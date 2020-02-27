@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('roles.index')}}">Manage Roles</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create New Role</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-dark elevation-2 animated flipInX p-0">
            <div class="card-header">
                <h3 class="card-title mr-auto">Create New Role</h3>
            </div>
            <div class="card-body">

                    {!! Form::model($role,['files' => false,'route' => 'roles.store','method'=>'POST']) !!}


                            <div class="container-fluid row d-flex justify-content-center mx-auto">
                                @include('roles.form')
                            </div>

                    {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>


</section>



@endsection

@section('first-scripts')
 <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>


@endsection

@section('style')

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>
@endsection

