<!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>bjb</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>bjb</b>App</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-language"></i> {{ __('Language') }} <span class="caret"></span></a>

            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="{{ url('setLocale/id') }}"><i class="fa fa-circle"></i> {{ __('Indonesian') }}</a>
              </li>
              <li>
                <a href="{{ url('setLocale/en') }}"><i class="fa fa-circle"></i> {{ __('English') }}</a>
              </li>
            </ul>

          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i> {{ Auth::user()->name }} <span class="caret"></span></a>

            <ul class="dropdown-menu" role="menu">
              <li><a href="{{ route('profile') }}"><i class="fa fa-user"></i> {{ __('Profile') }}</a></li>
              <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> {{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
              </li>
            </ul>

          </li>

        </ul>
      </div>
    </nav>
  </header>