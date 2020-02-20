@extends('layouts.main')

@section('styles')
    <style>
    .dashiy{
        background-color: #f9f9f9 !important;
    }
    .dropdown-item:hover{
      background: #434d4e !important;
      cursor: pointer;
  }
  .dropdown-item:active{
      background: #434d4e !important;
  }
    footer{
    background-color: #242b2d !important;
    color: antiquewhite !important;
    border: none !important;

    }
    footer a{
        color: #61e490 !important;
    }
    </style>
@endsection
@section('full-content')


    @include('layouts.main-navbar')
    @include('layouts.main-sidebar')

    <div class="content-wrapper dashiy">
        @yield('dashboard')
    </div>





      <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}} <a href="#">ntechnology</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.2
    </div>
  </footer>

  <!-- Control Sidebar -->
  {{-- <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside> --}}
  <!-- /.control-sidebar -->

@endsection
