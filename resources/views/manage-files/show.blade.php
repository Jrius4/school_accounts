@extends('manage-files.layout')
@section('content')
<a href="{{route('files.index')}}" class="btn btn-sm btn-info">Go Back</a>
<h2>{{$file->name}}</h2>
<img style="max-height:5vh;max-width:5vw" class="img-fliud" src="{{asset('images/'.$file->image)}}" alt=""/>

<a href="{{ asset('documents/'.$file->file) }}" target="_blanck">Open file</a>
<div class="row my-2">
    <div class="col-md-6">
        <embed src="{{ asset('images/'.$file->image) }}" style="max-height:25vh;max-width:25vw"/>
    </div>
    <embed src="{{ asset('documents/'.$file->file) }}" style="min-height:450px;" class="col-md-6" />

</div>

@endsection
