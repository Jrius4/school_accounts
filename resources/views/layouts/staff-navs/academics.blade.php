<li class="nav-item">
    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-user-plus"></i> <span class="mini-dn">Classes</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">

        <a href="{{url('/create-classes')}}" class="dropdown-item">Create Class</a>
        <a href="{{url('/create-streams')}}" class="dropdown-item">Create Stream</a>
        <a href="{{url('/assign-class-to-classteacher')}}" class="dropdown-item">Assign Class To Class Teacher</a>
    <a href="{{route('classes.index')}}" class="dropdown-item">Manage Classes</a>
        <a href="#" class="dropdown-item">Manage Streams</a>
    </div>
</li>
<li class="nav-item">
    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-book"></i> <span class="mini-dn">Subjects</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
        <a href="{{route('subjects.create')}}" class="dropdown-item">Create Subject</a>
        <a href="{{url('/assign_paper_subjects')}}" class="dropdown-item">Assign Paper to Subject</a>
        <a href="{{route('papers.index')}}" class="dropdown-item">Manage Added Papers</a>
        <a href="{{route('subjects.index')}}" class="dropdown-item">Manage Subjects</a>
    </div>
</li>
<li class="nav-item">
    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-book"></i> <span class="mini-dn">Combinations</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
        <a href="{{url('/manage-combinations-A-level')}}" class="dropdown-item">A Level</a>
        <a href="{{url('/manage-combinations-O-level')}}" class="dropdown-item">O Level</a>
        <a href="{{route('manage-combinations.index')}}" class="dropdown-item">Manage Combinations</a>
    </div>
</li>
<li class="nav-item">
    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-user-plus"></i> <span class="mini-dn">Teachers</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
        <a href="{{url('/assign-class-to-teacher')}}" class="dropdown-item">Assign Class To Teacher</a>
        <a href="{{url('/assign-subject-to-teacher')}}" class="dropdown-item">Assign Subject To Teacher</a>
        <a href="{{url('/manage-assign-subject-to-teacher')}}" class="dropdown-item">Manage Assign Subjects To Teacher</a>
        <a href="{{url('/manage-assign-class-to-teacher')}}" class="dropdown-item">Manage Assigned Classes To Teacher</a>
    </div>
</li>
<li class="nav-item">
    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-user-plus"></i> <span class="mini-dn">Students</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
        <a href="{{url('/student/a-level')}}" class="dropdown-item">A-Level</a>
        <a href="{{url('/student/o-level')}}" class="dropdown-item">O-Level</a>
    </div>
</li>
<li class="nav-item">
    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa big-icon fa-user-plus"></i> <span class="mini-dn">Manage Term</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
        <a href="{{route('sets.create')}}" class="dropdown-item">Set Percentages</a>
    </div>
</li>
<li class="nav-item">
    <a href="{{route('declares.index')}}" class="nav-link "><i class="fa big-icon fa-stop"></i> <span class="mini-dn">Declare Results</span></a>
</li>


