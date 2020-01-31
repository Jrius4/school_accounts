@extends('layouts.dashboard')
@section('content')
    {{-- <div>
        <h3 class="text-center text-info display-2">You are logged in</h3>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div> --}}


   @include('layouts.admin-nav')

    <!-- Breadcome start-->
    <div class="breadcome-area mg-b-30 small-dn">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcome-list map-mg-t-40-gl shadow-reset">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="breadcome-heading">
                                    <h2>Dashboard</h2>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ul class="breadcome-menu">
                                    <li><a href="#">Home</a> <span class="bread-slash">/</span> </li>
                                    <li><span class="bread-blod">dashboard</span> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcome End-->

    <!-- system analysis	 Start -->
    <div class="income-order-visit-user-area" style="min-height:60vh">
        <div class="container-fluid">

            @if (Auth::user()->hasRole('head_teacher'))
                @include('dashboards.head-teacher')
            @elseif (Auth::user()->hasRole('secretary'))
                @include('dashboards.secretary')
            @endif

        </div>
    </div>
    <!-- system analysis end -->
@endsection
