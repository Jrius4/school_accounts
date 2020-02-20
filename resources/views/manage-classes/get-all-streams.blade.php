@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Streams</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage Streams</h3>
                <a href="{{url('/create-streams')}}" class="btn btn-sm btn-outline-primary">Create New Stream</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped">
                    <thead>
                        <th>Name</th>
                        <th colspan="2">Class(es)</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if ($schstream->count()==0)
                                                    <div class="alert alert-danger">No info</div>
                                            @else
                                                @foreach ($schstream as $stream)
                                                    <tr>
                                                        <td>
                                                        {{$stream->name}}
                                                        </td>

                                                        <td colspan="2">
                                                            @if ($stream->schoolclasses()->count()>0)
                                                                @foreach ($stream->schoolclasses()->get() as $res)
                                                                    <span class="streams">{{$res->name}}</span>
                                                                @endforeach
                                                            @else

                                                            <p>Not Yet Assigned</p>

                                                            @endif
                                                        </td>

                                                        <td>

                                                        <form action="{{url('/delete-stream',$stream->id)}}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <a href="/edit-stream/{{$stream->id}}/edit"><i class="fa fa-eye"></i></a>|
                                                                <a href="/edit-stream/{{$stream->id}}/edit">
                                                                    <i class="fa fab fa-edit"></i>
                                                                </a> |

                                                                    <button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-xs btn-danger">
                                                                        <i class="fa fa-times"></i>
                                                                    </button>

                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif


                    </tbody>
                    <tfoot>
                        <th>Name</th>
                        <th colspan="2">Class(es)</th>
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
    .streams{
        display: inline;
        margin-inline-start: 0.5em;
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
