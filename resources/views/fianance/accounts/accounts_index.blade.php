@extends('layouts.main-dashboard')
@section('dashboard')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Accounts</li>
    </ol>
</nav>
<div class="content">
    <accounts-index></accounts-index>
    <div></div>
</div>

@endsection
