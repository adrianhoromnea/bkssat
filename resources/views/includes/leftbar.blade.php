<!-- Left menu components -->
<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
         @if(auth()->user()->hasAnyRole(['Administrator']))
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Admin">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseAdmin" data-parent="#exampleAccordion">
            <i class="fa fa-cogs"></i>
            <span class="nav-link-text">Admin</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseAdmin">
            <li>
              <a href="{{route('userslist')}}">Utilizatori</a>
            </li>
          </ul>
        </li>
        @endif

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Financiar">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseFinanciar" data-parent="#exampleAccordion">
            <i class="fa fa-money"></i>
            <span class="nav-link-text">Financiar</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseFinanciar">
            <li>
              <a href="{{route('listaprogramariplati')}}">Programare plati</a>
            </li>
          </ul>
        </li>
</ul>

<!-- Bootom button   -->
<ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
</ul>