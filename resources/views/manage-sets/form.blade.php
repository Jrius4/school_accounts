@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('sets.index')}}">Manage Term sets</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create New Term Sets percentages</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated flipInX">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Create New Term Sets percentages</h3>
            </div>
            <div class="card-body">

                            <form id="inputData" action="{{route('sets.store')}}" method="post">

                                @csrf
                                <input type="hidden" name="_method" value="POST">

                                <div class="container row d-flex justify-content-center">
                                    <div class="form-group col-md-8">

                                        <label for='set_name'>Exam Set</label>


                                        <select id="set_name" name="set_name" class="form-control col-12 d-block @error('set_name') is-invalid @enderror">
                                            <option value="">Select Set</option>
                                            @foreach ($sets as $set)

                                            <option value="{{$set->id}}" @if(old('set_name')==$set->id) selected @elseif($exmset->exists()&&$exmset->id==$set->id) selected @endif>{{$set->set_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('set_name')
                                            <strong class="invalid-feedback text-danger">{{$message}}</strong>
                                        @enderror
                                    </div>


                                <div class="form-group col-md-8">
                                    <label for='set_percentage'>Set percentage</label>

                                    <br />
                                    <input type="number" class="form-control col-12 d-block @error('set_percentage') is-invalid @enderror" name="set_percentage" value="@if(old('set_percentage')!==null){{old('set_percentage')}}@elseif($exmset->exists()){{$exmset->set_percentage}}@endif"/>
                                    <small class="text-muted right">number less than 100</small>
                                    @error('set_percentage')
                                    <strong class="invalid-feedback text-danger">{{$message.'Or Number less than 100'}}</strong>
                                @enderror
                                </div>


                                <div class="form-group col-md-8">
                                    <button type="submit" class="btn btn-info col-12 d-block">Save</button>
                                </div>
                            </div>
                            </form>


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
 <link rel="stylesheet" href="{{asset('schools/plugins/select2/css/select2.min.css')}}">
 <script src="{{asset('schools/plugins/select2/js/select2.full.min.js')}}"></script>


@endsection
