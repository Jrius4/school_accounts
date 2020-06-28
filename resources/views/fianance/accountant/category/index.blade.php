@extends('layouts.main-dashboard')
@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Account Types</li>
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
</section>

<section class="card card-body row container d-flex col-11 mx-auto elevation-2 animated slideInDown p-0">
<table class="table table-sm table-hover">
    <thead>
        <tr class="bg-dark p-1">
            <th colspan="3" class="">
                <span>Account Types List</span>
                <a href="{{route('acc-category.create')}}" class="btn btn-outline-info float-right">Create New</a>
            </th>
        </tr>
        <tr>
            <th>Name</th>
            <th>Number Of Accounts</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        @if ($accCategories->count()>0)

            @foreach ($accCategories as $row)
                <tr>
                    <td>{{$row->name}}</td>
                    <td>{{$row->schoolAccounts()->count()}}</td>
                    <td style="">
                        <form action="{{route('acc-category.destroy',$row->id)}}" method="POST">
                            <a class="text-info" href="{{route('acc-category.show',$row->id)}}"><i class="fa fa-eye"></i></a>|
                            <a href=""><i class="fa fa-edit"></i></a>|
                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            <button @if($row->name == 'Main Account' || $row->name == 'Student' || $row->name == 'Loans' ||  $row->name == 'School Assets') disabled @endif class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');" type="submit">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
        <tr>
            <td colspan="2" class="text-center py-2">
                <p>No information</p>
            </td>
        </tr>
        @endif

    </tbody>
</table>

</section>

@endsection

@section('script')
  <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection
@section('scripts')

<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script type="text/javascript">
    $(function () {
      $('#accTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
      });
    });
  </script>
@endsection
