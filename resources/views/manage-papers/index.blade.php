@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Subjects</li>
    </ol>
</nav>


<section class="content">

<div class="row">
    <div class="col-12">
        <div class="card elevation-2 animated bounce">
            <div class="card-header row">
                <h3 class="card-title mr-auto">Manage subjects-</h3>
                <a href="{{route('subjects.create')}}" class="btn btn-sm btn-outline-primary">Create New Subjects</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('partials.message')
                </div>
                <table id="RoleTable" class="table table-bordered table-striped">
            <thead>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Papers</th>
                    <th>Action</th>
            </thead>
            <tbody>
                @if ($subjects->count()==0)
                        <div class="alert alert-danger">No info</div>
                @else
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>
                            {{$subject->name}}
                            </td>
                            <td>
                                {{$subject->level}}
                            </td>
                            <td>
                                @if ($subject->papersIn()->count()>0)

                                    @foreach($subjects->find($subject->id)->papersIn()->get() as $paper)
                                        <span class="span">{{$paper->paper_name!==null?$paper->paper_name:$paper->paper_abbrev}}</span>
                                    @endforeach

                                @else
                                    <span class="text-warning">No Paper Assigned</span>

                                @endif
                            </td>
                            <td>
                                <span></span>
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <th>Name</th>
                <th>Level</th>
                <th>Papers</th>
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
.span{
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
