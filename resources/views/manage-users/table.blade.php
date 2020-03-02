@extends('layouts.admin-dashboard')
@section('style')
<style>
    .bg-transparent{
        background:transparent !important;
        border:none
    }
    .center-items{
        display: flex;
        justify-items: center;
    }
</style>
@endsection
@section('admin-content')
        <div class="row">
            <div class="center-contents">
                <a href="{{route('users.create')}}" class="btn btn-info"><i class="fa fa-user-plus"></i> Add User</a>
                </div>
        </div>
        <div class="row">
            @include('partials.message')
        </div>
		<!-- Static Table Start -->
		<div class="data-table-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sparkline13-list shadow-reset">
                                <div class="sparkline13-hd">
                                    <div class="main-sparkline13-hd">
                                        <h1>View <span class="table-project-n">Assigned Subjects</span> Info</h1>
                                        <div class="sparkline13-outline-icon">
                                            <span class="sparkline13-collapse-link"><i class="fa fa-chevron-up"></i></span>
                                            <span class="sparkline13-collapse-close"><i class="fa fa-times"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sparkline13-graph">
                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-key-events="true" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId" data-click-to-select="true" data-toolbar="#toolbar">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Member Of Role</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if ($users->count()==0)
                                                    <div class="alert alert-danger">No info</div>
                                            @else
                                                @foreach ($users as $user)
                                                    <tr>
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
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Static Table End -->

@endsection
@section('scripts')
            	<!-- scrollUp JS
         ============================================ -->
	<script src="{{ asset('schools/js/jquery.scrollUp.min.js')}}"></script>
	<!-- counterup JS
		============================================ -->
	<script src="{{ asset('schools/js/counterup/jquery.counterup.min.js')}}"></script>
	<script src="{{ asset('schools/js/counterup/waypoints.min.js')}}"></script>
	<!-- peity JS
		============================================ -->
	<script src="{{ asset('schools/js/peity/jquery.peity.min.js')}}"></script>
	<script src="{{ asset('schools/js/peity/peity-active.js')}}"></script>
	<!-- sparkline JS
		============================================ -->
	<script src="{{ asset('schools/js/sparkline/jquery.sparkline.min.js')}}"></script>
	<script src="{{ asset('schools/js/sparkline/sparkline-active.js')}}"></script>
	<!-- data table JS
		============================================ -->
	<script src="{{ asset('schools/js/data-table/bootstrap-table.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/tableExport.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/data-table-active.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/bootstrap-table-editable.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/bootstrap-editable.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/bootstrap-table-resizable.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/colResizable-1.5.source.js')}}"></script>
	<script src="{{ asset('schools/js/data-table/bootstrap-table-export.js')}}"></script>
	<!-- main JS
         ============================================ -->
	<script src="{{ asset('schools/js/main.js')}}"></script>
@endsection
