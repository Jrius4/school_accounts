@extends('layouts.main')

@section('styles')
    <style>
    .dashiy{
        background-color: #f9f9f9 !important;
    }
    label{
        text-transform: capitalize;
    }
    .dropdown-item-navi{
        background: #000000;
        color:white !important;
    }
    .dropdown-item-navi:hover{
      background: #434d4e !important;
      cursor: pointer;
  }
  .dropdown-item-navi:active{
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
    .main-sidebar{
        max-height: 100vh !important;
    }
    </style>
@endsection
@section('full-content')


    @include('layouts.main-navbar')
    @include('layouts.main-sidebar')
    {{-- @include('layouts.sidebar-alt') --}}

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

@section('api-token')
<script type="text/javascript">
    @if(session('access_token'))
        var token = "{{session('access_token')}}"

        localStorage.setItem('access_token',token)
    @endif
        // var token = localStorage.getItem('access_token');
        // if(token===null){
        //     window.location.href = "/";
        // }
        // if(Object.keys(localStorage).includes('access_token'))
        // {
        //     console.log(localStorage.access_token)
        // }
        // console.log(Object.keys(localStorage))
        // console.log(Object.keys(localStorage).includes('access_token'))
</script>
@endsection
@section('script')


<!-- jQuery -->
{{-- <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script> --}}
<!-- jQuery UI 1.11.4 -->

<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>



@endsection



