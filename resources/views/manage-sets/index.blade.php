@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Term Sets</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage Term Set</h3>
                <a href="{{route('sets.create')}}" class="btn btn-sm btn-outline-primary">Create New Set Percentage</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped">
                    <thead>
                        <th colspan="2">Set Name</th>
                        <th colspan="2">Set Percentage In A Term</th>
                    </thead>
                    <tbody>
                        @if ($sets->count()==0)
                                <div class="alert alert-danger">No info</div>
                        @else
                            @foreach ($sets as $set)
                                <tr>
                                    <td colspan="2">
                                    {{$set->set_name}}
                                    </td>

                                    <td colspan="2">
                                        {{$set->set_percentage}}<sup style="font-size: 12px">%</sup>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <th colspan="2">Set Name</th>
                        <th colspan="2">Set Percentage In A Term</th>
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
