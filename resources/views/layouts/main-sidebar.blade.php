

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
      <img src={{asset("schools/logos/logo1.png")}} alt="Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">FRIENDS<br>ACADEMY KITENDE</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        @if (Auth::user()->image)
            <div class="image">
                <img src="{{asset('files/'.Auth::user()->image)}}" class="img-circle elevation-2" alt="User Image">
            </div>
        @endif
        <div class="info">
          <a href="{{url('/')}}" class="d-block">{{Auth::user()->last_name}}</a>
        </div>
      </div>

      <nav class="mt-2 mb-7">
        <ul class="nav nav-pills nav-sidebar flex-column mb-6" data-widget="treeview" role="menu" data-accordion="false">

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
            @if (Auth::user()->hasRole('burser'))
                @include('layouts.staff-navs.v-2.burser')
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



              <li class="nav-header">
                  Messages
                </li>


              <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-comments"></i>
              <p>
                Messages
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info left">6</span>
              </p>
                  </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('messenger.index')}}" class="nav-link">
                                <i class="nav-icon  fas fa-envelope mr-2"></i>
                                <span class="badge badge-danger navbar-badge">15</span>
                                  <p>Inbox</p>
                              </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{route('messages.create')}}" class="nav-link">
                              <i class="nav-icon  fas fa-plus mr-2"></i>
                                <p>Compose</p>
                            </a>
                        </li>
                      </ul>
              </li>

          <li class="nav-item mb-4">
            <a href="{{route('profile')}}" class="nav-link">
              <i class="nav-icon fas fa-toolbox"></i>
              <p>
                My Account
              </p>
            </a>
          </li>
          <li class="nav-item mb-4">
            <a href="{{route('chat-room.all')}}" class="nav-link">
                <i class="nav-icon fas fa-toolbox"></i>
              <p>
                    Chat Room
                </p>
            </a>
        </li>

        <li class="nav-item mb-4">
            <a href="{{route('follows.users')}}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                <p>
                    Follows
                </p>
            </a>
        </li>

        <li class="nav-item mb-4">
            <a href="{{url('/web-events')}}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                <p>
                    Comments
                </p>
            </a>
        </li>
        <li  class="nav-item mb-4">
                     <a href="{{route('app-tests')}}" class="nav-link">App Tests</a>
                </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
