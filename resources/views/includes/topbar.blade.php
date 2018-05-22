<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user-circle-o"></i>
            <span>{{Auth::user()->firstname . ' ' . Auth::user()->lastname}}</span>
        </a>

        <div class="dropdown-menu" aria-labelledby="alertsDropdown">

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="#">
                <span class="text-info">
                    <strong>
                        Editeaza profil
                    </strong>
                </span>
            </a>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" href="#">
                <span class="text-info">
                    <strong>
                        Schimba parola
                    </strong>
                </span>
            </a>

            <div class="dropdown-divider"></div>

        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">
            <i class="fa fa-fw fa-sign-out"></i>Delogare
        </a>
    </li>
</ul>