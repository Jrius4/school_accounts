@extends('layouts.main-dashboard')

@section('dashboard')

    <div class="col-md-8 blog-main col-lg-8">
        <h3 class="pb-3 mb-4 font-italic border-bottom">
            <a href="/messages">The Message</a>
        </h3>
        <h3 class="pb-3 mb-4 font-italic border-bottom">
            {{ $message->message }} posted by {{ $message->user['name'] }}
        </h3>

    </div>
@endsection

@section('script')
<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection
