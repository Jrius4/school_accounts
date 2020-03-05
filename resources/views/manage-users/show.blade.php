@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Staff</li>
    </ol>
</nav>


<section class="content">

<section class="container-fluid">


     <!-- Small boxes (Stat box) -->
     <div class="row d-flex justify-content-center col-12">

        <div class="card card-dark  col-md-10 mx-auto p-0 animated bounce">
            <div class="card-header">
                <h4 class="card-title">{{$user->name}} Profile</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @if ($user->image)
                        <div class="mx-auto d-flex justify-content-center my-2" style="max-height:75px;max-width:75px">
                            <img src="{{asset('files/'.$user->image)}}" width="75px" height="75px" class="img-fluid img-circle"  alt="{{$user->username}}">
                        </div>
                    @endif

                    <div class="col-10 row d-flex justy-content-center">
                        <div class="col-sm-6">
                            <h4>Name</h4>
                            <p>
                                {{$user->name}}
                            </p>
                            <h4>Username</h4>
                            <p>
                                {{$user->username}}
                            </p>
                        </div>
                        <div class="col-sm-6">

                            @if($user->entry_date)
                                <h4>Enrolled</h4>
                                <p>
                                 {{ Carbon\Carbon::parse($user->entry_date,'UTC')->isoFormat('dddd D, MMMM, Y')}}
                                </p>
                            @endif
                            <h4>Serving as</h4>
                            <ul class="list-group">
                                @if ($user->roles->count()>0)
                                    @foreach ($user->roles as $row)

                                        <li class="list-group-item">{{$row->display_name}}</li>

                                    @endforeach
                                @else
                                <p>No Role Assigned</p>
                                @endif
                            </ul>

                        </div>


                    </div>
                    <div class="col-md-6">


                        @if($user->join_as)
                            <h4>Join as</h4>
                            <p>
                                {{$user->join_as}}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-12 my-2">
                        @if($user->biography)
                            <h4>Biography</h4>
                            <p>
                                {{$user->biography}}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-12 my-2">
                        @if ($user->some_form)
                            <h4>Entry Documents</h4>
                            <embed src="{{ asset('files/'.$user->some_form) }}" style="min-height:450px;" class="col-12" />
                        @endif
                    </div>

                    <div class="col-md-12 my-2">
                        <div class="row">


                            <div class="col-md-6">
                                @if ($user->subjects->count()>0)
                                    <h4>Teaching</h4>
                                    <ul class="list-group">
                                        @foreach ($user->subjects->groupBy('level') as $level=>$subz)
                                            <h4 class="list-group-item  active">{{$level}}</h4>
                                            @foreach ($subz as $row)
                                            <li class="list-group-item">{{$row->name}}</li>

                                            @endforeach
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if ($user->subjects->count()>0)
                                    <h4>Teacher In</h4>
                                    <ul class="list-group">
                                        @foreach ($user->schclasses->groupBy('level') as $level=>$clasz)
                                            <h4 class="list-group-item  active">{{$level}}</h4>
                                            @foreach ($clasz as $row)
                                            <li class="list-group-item">{{$row->name}}</li>

                                            @endforeach
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

      </div>
      <!-- /.row -->
@section('script')
 <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection







</section>



@endsection




@section('style')

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>

@endsection
