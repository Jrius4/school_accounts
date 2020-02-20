@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="{{route('subjects.index')}}">Manage Subjects</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create New Subject</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated flipInX">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Create New Subject</h3>
            </div>
            <div class="card-body">



                    <form action="{{route('subjects.update',$subject->id)}}" method="post">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                            <div class="container row d-flex justify-content-center">
                                @include('manage-subjects.form')
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


@endsection

@section('style')

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>
@endsection

