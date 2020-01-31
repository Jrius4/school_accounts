@extends('manage-files.layout')
@section('content')
<div class="row">
    <a href="{{route('files.index')}}" class="btn btn-sm btn-info">Go Back</a>
</div>

<div class="row">
    @include('partials.message')
</div>


    {!! Form::model($file,['files' => TRUE,'route' => ['files.update',$file->id],'method'=>'PUT']) !!}

        @include('manage-files.form')

    {!! Form::close() !!}
@endsection
