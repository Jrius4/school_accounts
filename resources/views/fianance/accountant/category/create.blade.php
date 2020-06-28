@extends('layouts.main-dashboard')
@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Account Category Creation</li>
    </ol>
</nav>

<section class="content">

        @if (session('message'))
            <div class="row container d-flex justify-content-center">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <p>
                        {{ session('message') }}
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        <form action="{{route('acc-category.store')}}" method="POST">

            <div class="row container d-flex justify-content-center">
                <div class="card card-dark p-0 animated slideInDown col-lg-10">
                    <div class="card-header">Student Payment</div>
                    <div class="card-body">
                        @csrf
                        @include('fianance.accountant.category.form')
                    </div>
                </div>
            </div>

        </form>

</section>

@endsection

@section('script')
<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection
