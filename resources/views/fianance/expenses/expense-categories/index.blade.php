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
                                <th>Number Of Expense</th>
                                <th>Action</th>
                            </thead>
                        </thead>
                        <tbody>

                            @if ($exp_cats->count()>0)
                                @foreach ($exp_cats as $row)

                                    <tr>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->outflows->count}}</td>
                                        <td style="width:120px">
                                            <p style="font-size:16px;">
                                                <form action="{{route('exp-category.destroy',$row->id)}}" method="POST">
                                                    <a class="text-info" href=""><i class="fa fa-eye"></i></a>|
                                                    <a href=""><i class="fa fa-edit"></i></a>|
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    @csrf
                                                    {{-- <button @if($row->name == 'Main Account' || $row->name == 'Student') disabled @endif class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');" type="submit"><i class="fas fa-times"></i></button> --}}
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');" type="submit"><i class="fas fa-times"></i></button>
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
