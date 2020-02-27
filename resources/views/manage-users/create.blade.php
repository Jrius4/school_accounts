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
    <div class="col-md-6 mx-auto">
        <div class="card card-dark elevation-2 animated flipInX">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Create New User</h3>
            </div>
            <div class="card-body">

                    {!! Form::model($user,['files' => true,'route' => 'users.store','method'=>'POST','id'=>'createForm']) !!}
                            <div class="container-fluid row d-flex justify-content-center mx-auto">
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

