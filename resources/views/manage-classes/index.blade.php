@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Classes</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage Classes</h3>
                <a href="{{route('classes.create')}}" class="btn btn-sm btn-outline-primary">Create New Class</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Class Teacher</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if ($classes->count()==0)
                                                    <div class="alert alert-danger">No info</div>
                                            @else
                                                @foreach ($classes as $class)
                                                    <tr>
                                                        <td>
                                                        {{$class->name}}
                                                        </td>
                                                        <td>
                                                            {{$class->level}}
                                                        </td>
                                                        <td>
                                                            @if ($class->user !==null)
                                                            {{$class->user->name}}

                                                            @else

                                                            <p>Not Yet Assigned</p>

                                                            @endif
                                                        </td>

                                                        <td>
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['classes.destroy', $class->id]]) !!}
                                                        <a href="{{route('classes.show',$class->id)}}"><i class="fa fa-eye"></i></a>|
                                                            <a href="{{route('classes.edit',$class->id)}}">
                                                                <i class="fa fab fa-edit"></i>
                                                            </a> |

                                                                <button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-xs btn-danger">
                                                                    <i class="fa fa-times"></i>
                                                                </button>

                                                        {!! Form::close() !!}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif


                    </tbody>
                    <tfoot>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Class Teacher</th>
                        <th>view</th>
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
