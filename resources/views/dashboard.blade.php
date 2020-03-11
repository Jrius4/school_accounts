@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</nav>


<section class="content">

<section class="container-fluid">

    @if (Auth::user()->hasRole('head_teacher'))
        @include('dashboards.head-teacher')
    @endif
    @if (Auth::user()->hasRole('accountant'))
        @include('dashboards.accountant')
    @endif
    @if (Auth::user()->hasRole('academic'))
        @include('dashboards.academics')
    @endif
    @if (Auth::user()->hasRole('secretary'))
        @include('dashboards.secretary2')
    @endif
    @if (Auth::user()->hasRole('teacher'))
        @include('dashboards.teacher')
    @endif



</section>



@endsection




@section('style')

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>

@endsection
