@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Staffs</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card col-12 p-0 card-dark m-x elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage Staffs</h3>
                <a href="{{route('users.create')}}" class="btn btn-sm btn-outline-primary">Create New User</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <div class="card">
                    <div class="card-body table-responsive p-0"  style="min-height: 350px;">
                        <table id="StaffTable" class="table table-bordered table-striped">
                            <thead>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Add User</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @if ($users->count()==0)
                                                            <div class="alert alert-danger">No info</div>
                                                    @else
                                                        @foreach ($users as $user)
                                                            <tr title="{{$user->name}}">
                                                                <td>
                                                                {{$user->name}}
                                                                </td>

                                                                <td>
                                                                    @if (true)
                                                                        @foreach ($user->roles as $role)
                                                                            <span class="bg-primary" style="color:white;padding:3px">{{$role->display_name}}</span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="bg-warning">No info</span>
                                                                    @endif
                                                                </td>
                                                                <td><a href="{{route('users.create')}}"><i class="fa fa-user-plus"></i></a></td>
                                                                <td>

                                                                {{-- <a href="{{route('users.edit',$user->id)}}"><i class="fa fa-edit"></i></a>|
                                                                <a href="{{route('users.destroy',$user->id)}}"><i class="fa fa-trash"></i></a>| --}}
                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                                                                <a href="{{route('users.show',$user->id)}}"><i class="fa fa-eye"></i></a>|
                                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-default">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a> |
                                                                    {{-- @if($category->id == config('cms.default_category_id'))
                                                                        <button onclick="return false" type="submit" class="btn btn-xs btn-danger disabled">
                                                                            <i class="fa fa-times"></i>
                                                                        </button>
                                                                    @else --}}
                                                                        <button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-xs btn-danger">
                                                                            <i class="fa fa-times"></i>
                                                                        </button>
                                                                    {{-- @endif --}}
                                                                {!! Form::close() !!}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif



                            </tbody>
                            <tfoot>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Add User</th>
                                <th>Action</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
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
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
    $(function () {
      $('#StaffTable').DataTable({
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
