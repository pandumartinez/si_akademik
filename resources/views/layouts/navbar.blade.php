<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #0f4c81;">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" style="color: #fff;" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <div class="btn-group" role="group">
                <a id="btnGroupDrop1" type="button" class="dropdown-toggle text-capitalize"
                    style="color: #fff; margin-right: 40px;"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="nav-icon fas fa-user-circle"></i>
                    &nbsp;
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="nav-icon fas fa-user"></i>
                        &nbsp;
                        My Profile
                    </a>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            &nbsp;
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </li>
    </ul>
</nav>
