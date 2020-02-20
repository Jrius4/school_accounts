@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Combinations</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage Combinations</h3>
                <a href="{{url('/manage-combinations-A-level')}}" class="btn btn-sm btn-outline-primary">Create New Combination</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped">
                    <thead>
                        <th>Name</th>
                        <th>First Subject</th>
                        <th>Second Subject</th>
                        <th>Third Subject</th>
                        <th>Subsidiary Subject</th>
                        <th>Level</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if ($combinations->count()==0)
                                <div class="alert alert-danger">No info</div>
                        @else
                            @foreach ($combinations as $comb)
                                <tr>
                                    <td>
                                    {{$comb->combination_name}}
                                    </td>

                                    <td>
                                        {{$comb->first_subject}}
                                    </td>
                                    <td>{{$comb->second_subject}}</td>
                                    <td>{{$comb->third_subject}}</td>
                                    <td>{{$comb->subsidiary}}</td>
                                    <td>{{$comb->level}}</td>
                                    <td>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['manage-combinations.destroy', $comb->id]]) !!}
                                        <a href="{{route('manage-combinations.edit',$comb->id)}}" class="btn btn-xs btn-info"><i class="fa fas fa-edit"></i></a>|<button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-xs btn-danger">
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
                        <th>First Subject</th>
                        <th>Second Subject</th>
                        <th>Third Subject</th>
                        <th>Subsidiary Subject</th>
                        <th>Level</th>
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
