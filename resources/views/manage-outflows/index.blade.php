@extends('layouts.admin-dashboard')
@section('admin-content')
<div class="row">
    <div class="col-lg-12">

        <div class="sparkline13-list shadow-reset">
            <div class="sparkline13-hd">
                <div class="main-sparkline13-hd">

                    <h1>View <span class="table-project-n">OutFlow</span> Info</h1>
                    <div class="sparkline13-outline-icon">
                        <span class="sparkline13-collapse-link"><i class="fa fa-chevron-up"></i></span>
                        <span class="sparkline13-collapse-close"><i class="fa fa-times"></i></span>
                    </div>
                </div>
            </div>
            <div class="sparkline13-graph">
                <div class="datatable-dashv1-list custom-datatable-overright">
                    @include('manage-outflows.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
