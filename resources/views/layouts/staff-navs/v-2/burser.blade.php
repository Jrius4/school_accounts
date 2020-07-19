<li class="nav-header"><i class="nav-icon fas fa-arrow-up  text-success"></i>  <span>Inflow</span></i></li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link"><i class="nav-icon fas fa-circle"></i>

        <p>
            Payments
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('make-payment')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Payments</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('view-payments')}}" class="nav-link">
                <i class="far fa-eye nav-icon"></i>
                <p>View Payments</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-header my-1 d-flex"><i class="nav-icon fas fa-arrow-down  text-danger"></i>  <span>Outflow</span></li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link"><i class="nav-icon fas fa-circle"></i>

        <p>
            Expenses
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('view-expenses')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>View Expenses</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Spend</p>
            </a>
        </li>
    </ul>
</li>
