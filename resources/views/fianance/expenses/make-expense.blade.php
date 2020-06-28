@extends('layouts.main-dashboard')
@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Make Expense</li>
    </ol>
</nav>

<section class="content">

            @if (session('message'))
                <div class="row container d-flex justify-content-center">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <p>
                            {{ session('message') }}
                        </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error-message'))
                <div class="row container d-flex justify-content-center">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p>
                            {{ session('message') }}
                        </p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif


            <div class="row container d-flex justify-content-center">
                <div class="card card-dark p-0 animated slideInDown col-xl-12 col-lg-12 col-sm-12"  style="min-width:450px !important;">
                    <div class="card-header">Make Expense</div>
                    <div class="card-body">
                        @csrf
                        @include('fianance.expenses.expense-form')
                    </div>
                </div>
            </div>



</section>

@endsection

@section('script')
<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection
