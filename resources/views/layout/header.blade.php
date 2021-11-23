<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
    <a class="navbar-title" href="{{ url('/') }}">
      <span> XDEventos </span>
    </a>

  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

    <ul class="navbar-nav navbar-nav-left header-links">
      <li class="nav-item d-none d-xl-flex">
        <a href="/clients" class="nav-link {{ active_class(['clients']) }}"> Clientes </a>
      </li>
      <li class="nav-item d-none d-xl-flex {{ active_class(['users']) }}">
        <a href="/users" class="nav-link"> Usuários </a>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link" id="UserDropdown" href="/auth/logout"  aria-expanded="false">
          <span class="profile-text d-none d-md-inline-flex"> <i class="mdi mdi-logout-variant"> </i></span>
        </a>  
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu icon-menu"></span>
    </button>
  </div>
</nav>