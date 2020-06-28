@extends('layouts.main-dashboard')

@section('dashboard')

    <div class="blog-post">
        <ul class="list-group">
            @if ($messages->count()>0)

                @foreach ($messages as $message)
                    <li class="list-group-item">
                        <h2 class="blog-post-title">
                            <a href="{{route('messages.show',$message->id)}}">{{$message->message}}</a>
                        </h2>
                    </li>
                    <li class="list-group-item">
                        <a href="{{route('messages.edit',$message->id)}}">Edit</a>
                    </li>
                @endforeach

            @endif
        </ul>
    </div>
@endsection

@section('script')
<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection
