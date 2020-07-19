<li class="nav-header">Accounts</li>

    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Accounts
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('overview-payments')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Accounts Type</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('account.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Accounts</p>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{route('structures.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Create Structure</p>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="{{route('acc-category.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Account Types</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('school_accounts.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View All Accounts</p>
                </a>
            </li>
        </ul>
    </li>

<li class="nav-header">Income Statements</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Payments
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('overview-payments')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Expenses</p>
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
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>View All Students</p>
                </a>
            </li>
        </ul>
    </li>
