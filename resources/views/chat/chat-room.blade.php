@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Chat Rooms</li>
    </ol>
</nav>


<section class="content">

<section class="container-fluid">
    <chat-room :user="{{auth()->user()}}"></chat-room>
</section>



@endsection




@section('style')

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>

@endsection

