@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('roles.index')}}">Input Results Results</a></li>
        <li class="breadcrumb-item active" aria-current="page">Enter Term @if(request()->term == 'term-1'){{'One'}}@elseif(request()->term == 'term-2'){{'Two'}}@elseif(request()->term == 'term-3'){{'Three'}}@endif @if(request()->set == 'b-o-t'){{'Beginning Of Term'}}@elseif(request()->set == 'm-o-t'){{'Mid Of Term'}}@elseif(request()->set == 'e-o-t'){{'End Of Term'}}@endif Results</li>
    </ol>
</nav>


<section class="content">

<enter-marks term="{{request()->term}}" set="{{request()->set}}"></enter-marks>


</section>




@endsection