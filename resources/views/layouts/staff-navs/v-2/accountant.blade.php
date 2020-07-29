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

<li class="nav-header"> <i class="nav-icon fas fa-balance-scale-right"></i> Income Statements</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-balance-scale-right"></i>
        <p>
            Financial Reports
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('overview-payments')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Payments</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('overview-expenses')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Expenses</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('overview-payments-and-expenses')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Overview</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>
            Financial Graphs
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('graph-payments')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Payments</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('graph-expenses')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Expenses</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('overview-payments-and-expenses')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Overview</p>
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
