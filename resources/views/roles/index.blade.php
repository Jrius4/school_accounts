@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Roles</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage Roles</h3>
                <a href="{{route('roles.create')}}" class="btn btn-sm btn-outline-primary">Create New Role</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Number Of Staffs</th>
                        <th>Add Staff To Role</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if ($roles->count()==0)
                                <div class="alert alert-warning">No info</div>
                        @else
                            @foreach ($roles as $role)
                                <tr>
                                    <td>
                                    {{$role->name}}
                                    </td>

                                    <td>{{$role->users->count()}}</td>
                                    <td><a href="{{route('users.create')}}"><i class="fa fa-user-plus"></i></a></td>
                                    <td>
                                    <a href="{{route('roles.show',$role->id)}}"><i class="fa fa-eye"></i></a>|
                                    <a href="{{route('roles.edit',$role->id)}}"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <th>Name</th>
                        <th>Number Of Staffs</th>
                        <th>Add Staff To Role</th>
                        <th>Action</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>


</section>



@endsection

@section('style')
 <!-- DataTables -->
 <link rel="stylesheet" href="src="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">

<style>
    .breadcrumb{

        background: #fdffffc7;
    }
</style>
@endsection
@section('script')
  <!-- jQuery -->
 <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
@endsection
@section('scripts')
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('adminlte//plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
    $(function () {
      $('#RoleTable').DataTable({
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
