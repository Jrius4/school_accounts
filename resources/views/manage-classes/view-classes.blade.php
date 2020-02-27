@extends('layouts.main-dashboard')

@section('dashboard')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb elevation-2">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Classes</li>
    </ol>
</nav>


<section class="content">


        <!-- /.row -->
        <div class="row animated flipInX">
            <div class="col-12">
              <div class="card elevation-2">
                <div class="card-header">
                  <h3 class="card-title">All classes</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body  table-responsive p-0 " style="height: 350px;">
                  <table class="table  table-hover table-head-fixed text-nowrap">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Number Of Students</th>
                        <th>Streams</th>
                        <th>Class Teacher</th>
                      </tr>
                    </thead>
                        <tbody>
                            @if ($classes->count()==0)
                                <tr>
                                    <td colspan="4">
                                        No Class Info
                                    </td>
                                </tr>
                            @elseif($classes->count()>0)

                                @foreach ($classes as $class)

                                    <tr title="{{$class->name}}">
                                        <td>{{$class->name}}</td>
                                        <td>{{$class->students()->where('updated_at','like','%'.date('Y').'%')->where('school_presence_status','active')->get()->count()}}</td>
                                        <td class="d-flex justify-content-center">
                                            @if ($class->classStreames->count()>0)
                                                @foreach ($class->classStreames()->get() as $item)
                                                    <span class="btn btn-md bg-gradient-primary mx-1 p-1">{{$item->name}}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{$class->user!=null?$class->user->name:'no class teacher'}}</td>
                                    </tr>

                                @endforeach

                            @endif
                        </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->




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
