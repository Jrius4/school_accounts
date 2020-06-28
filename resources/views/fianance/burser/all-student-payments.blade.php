@extends('layouts.main-dashboard')
@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Payments List</li>
    </ol>
</nav>

<section>
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

        @if (session('action-message'))
            <div class="row container d-flex justify-content-center">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>
                        {{ session('action-message') }}
                    </p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        <div class="row container d-flex justify-content-center">
            <div class="card card-dark p-0 animated slideInDown col-lg-10">
                <div class="card-header">
                    Accounts List
                </div>
                <div class="card-body">
                    <table class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <thead>
                                <th>Name</th>
                                <th>Account</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </thead>
                        </thead>
                        <tbody>

                            @if ($studFees->count()>0)
                                @foreach ($studFees as $student=>$years)
                                    <tr class="bg-dark">
                                       <td colspan="4">{{$years->first()->student->name}}</td>
                                    </tr>

                                    @foreach ($years->groupBy('year') as $year=>$terms)



                                        @foreach ($terms->groupBy('term_id') as $term=>$payments)
                                            <tr>
                                                <td colspan="2">
                                                    {{$payments->first()->term->name}}
                                                </td>
                                                <td colspan="2">
                                                    {{'Year: '.$payments->first()->year}}
                                                </td>
                                            </tr>
                                        @foreach ($payments as $row)
                                            <tr class="@if(($row->to_pay-$row->paid)>0) bg-danger @elseif(($row->to_pay-$row->paid)==0) bg-success @endif">
                                                <td>{{$row->fees}}</td>
                                                <td>{{$row->paid}}</td>
                                                <td>{{($row->to_pay!=null?$row->to_pay-$row->paid:null)}}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach

                                @endforeach

                                    @endforeach


                                @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center py-2">
                                    <p>No information</p>
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
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
