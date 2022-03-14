<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="../../index3.html" class="brand-link">
        <img src="../../dist/img/AdminLTELogo.png" alt="wac Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">W A C </span>
    </a>

    <div class="sidebar">


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class=" fa fa-dashboard"></i>
                        <p>
                            Dashboard
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a></li><li class="">
                    <a href="{{ route('employee.create') }}" class="nav-link">
                        <i class=" fa fa-user"></i>
                        <p>
                            Add Employee
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a></li>

            </ul>
        </nav>

    </div>

</aside>