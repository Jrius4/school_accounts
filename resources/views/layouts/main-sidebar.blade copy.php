  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 shadow-md">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link row d-flex justify-content-center">
        <div class="col-12 d-flex align-self-center">
            <img src="{{asset("schools/logos/logo1.png")}}" style="transform:scale(1.3)" alt="logo" class="brand-image img-circle elevation-3 mx-auto"
           style="opacity: .8;"/>
        </div>
        <div class="col-12 d-flex align-self-center"> <span class="brand-text font-weight-light row text-center p-2 mx-auto"><p style="font-size:16pt">FRIENDS<br>ACADEMY KITENDE</p></span></div>


        <br/>

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info row d-flex justify-content-center mx-auto col-6">
                @if (Auth::user()->image)
                    <img src="{{asset('files/'.Auth::user()->image)}}" width="75px" height="75px" class="img-fluid img-circle mx-auto "  alt="{{Auth::user()->username}}">
                @endif
        <a href="{{url('/')}}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{url('/')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
            @if (Auth::user()->hasRole('head_teacher'))
                @include('layouts.staff-navs.v-2.headteacher')
            @endif
            @if (Auth::user()->hasRole('accountant'))
                @include('layouts.staff-navs.v-2.accountant')
            @endif
            @if(Auth::user()->hasRole('academic'))
                @include('layouts.staff-navs.v-2.academics')
            @endif
            @if(Auth::user()->hasRole('secretary'))
                @include('layouts.staff-navs.v-2.secretary')
            @endif
            @if(Auth::user()->hasRole('teacher'))
                @include('layouts.staff-navs.v-2.teacher')
            @endif

          <li class="nav-item">
            <a href="{{route('profile')}}" class="nav-link">
              <i class="nav-icon fas fa-toolbox"></i>
              <p>
                My Account
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
