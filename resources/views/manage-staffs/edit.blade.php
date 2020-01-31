@extends('manage-files.layout')
@section('content')
<div class="row">
    <a href="{{route('files.index')}}" class="btn btn-sm btn-info">Go Back</a>
</div>

<div class="row">
    @include('partials.message')
</div>


    {!! Form::model($user,['files' => TRUE,'route' => ['files.update',$user->id],'method'=>'PUT']) !!}

        @include('manage-users.form')

    {!! Form::close() !!}
@endsection
