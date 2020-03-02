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
                <h3 class="card-title">{{$user->name}} Profile</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @if ($user->image)
                        <div class="col-md-12 mx-auto d-flex justify-content-center my-2">
                            <img src="{{asset('files/'.$user->image)}}" width="75px" height="75px" class="img-fluid img-circle"  alt="{{$user->username}}">
                        </div>
                    @endif

                    <div class="col-md-6">
                        <h2>Name</h2>
                        <p>
                            {{$user->name}}
                        </p>
                        <h2>Username</h2>
                        <p>
                            {{$user->username}}
                        </p>
                        <h2>My Roles</h2>
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
                    <div class="col-md-6">
                        @if($user->entry_date)
                            <h2>Entry Date</h2>
                            <p>
                                {{ Carbon\Carbon::parse($user->entry_date,'UTC')->isoFormat('dddd D, MMMM, Y')}}
                            </p>
                        @endif

                        @if($user->join_as)
                            <h2>Join as</h2>
                            <p>
                                {{$user->join_as}}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-12 my-2">
                        @if($user->biography)
                            <h2>Biography</h2>
                            <p>
                                {{$user->biography}}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-12 my-2">
                        @if ($user->some_form)
                            <h2>Entry Documents</h2>
                            <embed src="{{ asset('files/'.$user->some_form) }}" style="min-height:450px;" class="col-12" />
                        @endif
                    </div>

                    <div class="col-md-12 my-2">
                        <div class="row">


                            <div class="col-md-6">
                                @if ($user->subjects->count()>0)
                                    <h3>Teaching</h3>
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
                                    <h3>Teacher In</h3>
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
