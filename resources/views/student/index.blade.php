@extends('student')
@section('content')
<div class="card col-md-10 mx-auto">
    <div class="card-header">
        <h4>Personel Information</h4>
    </div>
    <div class="card-body p-0">
        <div class="row col-12">

            @if($student->admission_form)

                <h4>Admission Form</h4>

            <div class="row col-md-12">
                <embed style="width:100%;height:100vh" src="{{asset('documents/'.$student->admission_form)}}" type="">
            </div>

            @endif

        </div>
    </div>



</div>
@endsection
