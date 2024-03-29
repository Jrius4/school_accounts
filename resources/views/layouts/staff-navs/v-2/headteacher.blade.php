<li class="nav-item">
    <a href="{{url('/view-classes')}}" class="nav-link">
      <i class="nav-icon fas fa-chalkboard"></i>
      <p>
        Classes
      </p>
    </a>
  </li>
  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>
        Role/Titles
        <i class="fas fa-angle-left right"></i>
        <span class="badge badge-info right">{{App\Role::count()}}</span>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{route('roles.create')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Create Role</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('roles.index')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>View All</p>
        </a>
      </li>
    </ul>
  </li>
  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>
        Staffs
        <i class="fas fa-angle-left right"></i>
        <span class="badge badge-info right">{{App\User::count()}}</span>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{route('users.create')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Create Staff</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('users.index')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>View All</p>
        </a>
      </li>
    </ul>
  </li>
  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-chalkboard-teacher"></i>
      <p>
        Teachers
        <i class="fas fa-angle-left right"></i>
        <span class="badge badge-info right">{{App\Role::whereName('teacher')->first()->count()}}</span>
      </p>
    </a>
    <ul class="nav nav-treeview">
      {{-- <li class="nav-item">
        <a href="{{route('teachers.create')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Create Teacher</p>
        </a>
      </li> --}}
      <li class="nav-item">
        <a href="{{route('teachers.index')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>View All</p>
        </a>
      </li>
    </ul>
  </li>

   <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-chart-bar"></i>
      <p>
        Salaries
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">

      <li class="nav-item">
        <a href="{{route('employee-salary.index')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Salaries</p>
        </a>
      </li>
    </ul>
  </li>


