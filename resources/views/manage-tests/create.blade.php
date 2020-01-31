@extends('manage-tests.layout')
@section('content')
<div class="row">
        <a href="{{route('to-checks.index')}}" class="btn btn-danger">Back</a>
        </div>

        <div class="mx-auto">
            <div class="col-12">
                {!! Form::model($subject,['files' => TRUE,'route' => 'to-checks.store','method'=>'POST']) !!}

                    @include('manage-tests.form')

                {!! Form::close() !!}
            </div>
        </div>



@endsection

@section('scripts')
<script>


</script>

@endsection
