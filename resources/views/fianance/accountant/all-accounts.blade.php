@extends('layouts.main-dashboard')
@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Accounts List</li>
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
                                <th>Type</th>
                                <th>Payment Structure</th>
                                <th>Balance</th>
                                <th>Mini Balance</th>
                                <th>Action</th>
                            </thead>
                        </thead>
                        <tbody>

                            @if ($accounts->count()>0)
                                @foreach ($accounts as $row)
                                    <tr>
                                        <td>{{$row->account_name}}</td>
                                        <td>{{$row->accCategory != null?$row->accCategory->name:'ungrouped'}}</td>
                                        <td>{{$row->to_pay}}</td>
                                        <td>{{$row->amount}}</td>
                                        <td>{{$row->set_minium_balance?$row->set_minium_balance:'Not set'}}</td>
                                        <td style="width:120px">
                                            <p style="font-size:16px;">
                                                <form action="{{route('school_accounts.delete',$row->id)}}" method="POST">
                                                    <a class="text-info" href=""><i class="fa fa-eye"></i></a>|
                                                    <a href=""><i class="fa fa-edit"></i></a>|
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @csrf
                                                    <button @if($row->account_name == 'Main Account' || $row->account_name == 'School Fees') disabled @endif class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');" type="submit"><i class="fas fa-times"></i></button>
                                                </form>

                                            </p>

                                        </td>
                                    </tr>
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
