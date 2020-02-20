@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('subjects.index')}}">Manage Subjects</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Papers To Subjects</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated flipInX">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Create Papers To Subjects</h3>
            </div>
            <div class="card-body">


                    <form id="insert_paper_data" action="{{url('/assign_paper_subjects')}}" method="post">
                        @csrf

                        <input type="hidden" name="_method" value="post">
                        <div class="container row d-flex justify-content-center">
                    <div class="form-group  col-md-8">
                        <label for="sub_comp">Subject Name</label>
                        <select name="subject_name" id="subject_name" class="form-control d-block col-12 @error('subject_name') is-invalid @enderror">
                            <option value="">Select a subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="subject_name_hidden" id="subject_name_hidden">
                        @error('subject_name')
                        <span class="invalid-feedback text-danger">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="form-group col-md-8">
                        <label for="paper_name">Paper Name</label>
                        <input type="text" name="paper_name" id="paper_name" placeholder="Paper Name" class="form-control d-block col-12 @error('paper_name') is-invalid @enderror" value="@if(old('paper_name')!==null){{old('paper_name')}}@endif">
                        @error('paper_name')
                        <span class="invalid-feedback text-danger">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group col-md-8">
                        <label for="paper_name">Paper Short Form</label>
                        <input type="text" name="paper_abbrev" id="paper_abbrev" placeholder="Paper Abbrev" class="form-control d-block col-12 @error('paper_abbrev') is-invalid @enderror" value="@if(old('paper_abbrev')!==null){{old('paper_abbrev')}}@endif">
                        @error('paper_abbrev')
                        <span class="invalid-feedback text-danger">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-8">
                        <label for="paper_name">Paper Percentage</label>
                        <input type="text" name="paper_percentage" id="paper_percentage" placeholder="Paper Percentage" class="form-control d-block col-12 @error('paper_percentage') is-invalid @enderror" value="@if(old('paper_percentage')!==null){{old('paper_percentage')}}@endif">
                        <small class="text-muted right my-1"><p>Optional if necessary number less than 100</p></small>
                        @error('paper_percentage')
                        <span class="invalid-feedback text-danger">
                            <strong>{{$message.'number'}}</strong>
                        </span>
                        @enderror
                    </div>



                <div class="form-group col-md-8">
                    <button type="submit" class="btn btn-info col-12 d-block">Submit</button>
                </div>
                </div>






                    </form>
                </div>
            </div>
        </div>
    </div>


    </section>


@include('manage-subjects.script')
@endsection

