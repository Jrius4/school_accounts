@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" ><a href="{{url('/')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$from->name}} Students Results</li>
    </ol>
</nav>


<section class="content">

<students-results event="{{$event}}" query="{{$query}}"></students-results>


</section>




@endsection
