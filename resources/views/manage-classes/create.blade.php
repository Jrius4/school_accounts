@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('classes.index')}}">Manage Classes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create New Class</li>
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

                    {!! Form::model($schclass,['files' => false,'route' => 'classes.store','method'=>'POST']) !!}


                            <div class="container row d-flex justify-content-center">



                                    <div class="py-2 form-group col-md-8 {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name">Class Name</label>

                                        <input type="text" name="name" value="@if(old('name')!==null){{old('name')}}@elseif($schclass->exists) {{$schclass->name}}  @endif" class="form-control bg-transparent d-block @error('name') is-invalid @enderror" placeholder="Enter Class Name">
                                        @if($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="py-2 form-group col-md-8 {{ $errors->has('level') ? 'required' : '' }}">
                                        <label for="level">Class Level</label>
                                        <select name="level" id="level" class="form-control bg-transparent d-block @error('level') is-invalid @enderror">
                                            <option value="">Select a level</option>
                                            <option value="Ordinary Level" @if(old('level')!==null) @if(old('level')=="Ordinary Level") selected @endif @elseif($schclass->exists) @if($schclass->level == "Ordinary Level") selected @endif  @endif>Ordinary Level</option>
                                            <option value="Advanced Level" @if(old('level')!==null) @if(old('level')=="Advanced Level") selected @endif @elseif($schclass->exists) @if($schclass->level == "Advanced Level") selected @endif  @endif>Advanced Level</option>
                                            <option value="Both" @if(old('level')!==null) @if(old('level')=="Both") selected @endif @elseif($schclass->exists) @if($schclass->level == "Both") selected @endif  @endif>Both</option>

                                        </select>
                                        @if($errors->has('level'))
                                            <span class="text-danger">{{ $errors->first('level') }}</span>
                                        @endif
                                    </div>

                                    <div class="py-2 col-md-8">
                                    {{ Form::submit('Create Class',['class'=>'btn btn-md btn-info d-block col-12']) }}
                                    </div>




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

