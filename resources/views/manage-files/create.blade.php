@extends('manage-files.layout')
@section('content')

<div class="row ">
    <div>
        <a href="{{route('files.index')}}"  class="btn btn-sm btn-info">Go Back</a>
    </div>
</div>
<div class="row">
    @include('partials.message')
</div>


        {!! Form::model($file,['files' => TRUE,'route' => 'files.store','method'=>'POST']) !!}

             @include('manage-files.form')

        {!! Form::close() !!}
@endsection
