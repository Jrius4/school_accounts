<li class="nav-header">Manage Classes</li>

    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chalkboard"></i>
            <p>
            Classes
            <i class="right fas fa-angle-left"></i>
            <span class="badge badge-info right">{{App\Schclass::count()}}</span>
            </p>
        </a>
        <ul class="nav nav-treeview">

            <li class="nav-item">
                <a href="{{route('classes.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View All Classes</p>
                </a>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                    Streams
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{url('/create-streams')}}" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Create Stream</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('/all-streams')}}" class="nav-link">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Vlew All Streams</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{route('classes.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Classes</p>
                </a>
            </li>
        </ul>
    </li>

  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>
       Marks
        <i class="fas fa-angle-left right"></i>
        <span class="badge badge-info right">{{App\Schclass::count()}}</span>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{route('classes.create')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Create Class</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('classes.index')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>View All</p>
        </a>
      </li>
    </ul>
  </li>
  <li class="nav-header">Teachers</li>

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

        <li class="nav-item">
            <a href="{{url('/assign-class-to-classteacher')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Assign Class To Class Teacher</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/assign-class-to-teacher')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Assign Class To Teacher</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/assign-subject-to-teacher')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Assign Subjects To Teacher</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/manage-assign-class-to-teacher')}}">
            <i class="far fa-circle nav-icon"></i>
            <P>View Teachers & Classes</P>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/manage-assign-subject-to-teacher')}}">
            <i class="far fa-circle nav-icon"></i>
            <P>View Teachers & Subjects</P>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('teachers.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>View All</p>
            </a>
        </li>
    </ul>
  </li>
  <li class="nav-header">Subjects</li>

  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>
       Subjects
        <i class="fas fa-angle-left right"></i>
        <span class="badge badge-info right">{{App\Subject::count()}}</span>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="{{route('subjects.create')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Create Subject</p>
        </a>
      </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                Subject Papers
                <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{url('/assign_paper_subjects')}}" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Create Paper To Subject</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('papers.index')}}" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Vlew All Papers</p>
                    </a>
                </li>
            </ul>
        </li>
      <li class="nav-item">
        <a href="{{url('/assign-subject-to-teacher')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Assign Subject to Teacher</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{url('/manage-assign-subject-to-teacher')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Manage Assigned Subjects</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{route('subjects.index')}}" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>View All</p>
        </a>
      </li>
    </ul>
  </li>
  <li class="nav-header">Combinations</li>

  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-book"></i>
      <p>
       Combinations
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{url('/manage-combinations-A-level')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>A Level</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url('/manage-combinations-O-level')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>O Level</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('manage-combinations.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>View All</p>
            </a>
        </li>
    </ul>
  </li>

  <li class="nav-header">Students</li>

  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>
       Students
        <i class="fas fa-angle-left right"></i>
        <span class="badge badge-info right">{{App\Models\Student::count()}}</span>

      </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{url('/student/a-level')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>A Level</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url('/student/o-level')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>O Level</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('students.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>View All Students</p>
            </a>
        </li>
    </ul>
  </li>

  <li class="nav-header">Terms</li>

  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>
       Term
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Next Term</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Make Term Schedules</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('sets.create')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Make Set Percentage</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{route('sets.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>View All Sets</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Manage Sets</p>
            </a>
        </li>
    </ul>
  </li>

  <li class="nav-header">Next Terms</li>
  <li class="nav-item">
    <a href="{{route('declares.index')}}" class="nav-link">Declare Results</a>
  </li>

