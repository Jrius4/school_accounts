@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('users.index')}}">Manage Staffs</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create New Staff</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Create New User</h3>
            </div>
            <div class="card-body">

                    {!! Form::model($user,['files' => false,'route' => 'users.store','method'=>'POST']) !!}
                            <div class="container row d-flex justify-content-center col-lg-12">
                                @include('manage-users.form')
                            </div>


                    {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>


</section>



@endsection

@section('style')

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>
@endsection

