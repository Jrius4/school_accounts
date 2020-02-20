@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('teachers.index')}}">Manage Teacher</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create New Teacher</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated flipInX">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Create New Teacher</h3>
            </div>
            <div class="card-body">

                {!! Form::model($teacher,['files' => true,'method'=>'POST','id'=>'insert_data']) !!}
                <div class="row col-lg-12 d-flex justify-content-between"><div id="results"></div></div>
                <div class="container row d-flex justify-content-center">


                            @include('manage-teachers.form')


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

