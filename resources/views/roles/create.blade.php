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
    <div class="col-12">
        <div class="card elevation-2 animated flipInX">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Create New Role</h3>
            </div>
            <div class="card-body">

                    {!! Form::model($role,['files' => false,'route' => 'roles.store','method'=>'POST']) !!}


                            <div class="container row d-flex justify-content-center">
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

