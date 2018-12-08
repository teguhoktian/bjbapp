<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU APLIKASI</li>

        @role('Super User')
        {{-- Menu Users --}}
        <li class="treeview {{ ($menu=='users') ? 'active' : '' }}">
          <a href="#"><i class="fa fa-users"></i> <span>{{ __('Users') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($submenu == 'user') ? 'active' : '' }}">
              <a href="{{ route('user.index') }}">
                <i class="fa fa-list"></i> <span>{{ __('User List') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'permission') ? 'active' : '' }}">
              <a href="{{ route('permission.index') }}">
                <i class="fa fa-drivers-license"></i> <span>{{ __('Permission') }}</span>
              </a>
            </li>


            <li class="{{ ($submenu == 'role') ? 'active' : '' }}">
              <a href="{{ route('role.index') }}">
                <i class="fa fa-drivers-license"></i> <span>{{ __('Role') }}</span>
              </a>
            </li>

            <li class="{{ ($submenu == 'corporate') ? 'active' : '' }}">
              <a href="{{ route('corporate.index') }}">
                <i class="fa fa-institution"></i> <span>{{ __('Corporate List') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'office') ? 'active' : '' }}">
              <a href="{{ route('office.index') }}">
                <i class="fa fa-building"></i> <span>{{ __('Offices List') }}</span>
              </a>
            </li>
          </ul>
        </li>
        @endrole

        @role('Editor Post|Admin Post|Writer')
        {{-- Menu Post --}}
        <li class="treeview {{ ($menu=='posts') ? 'active' : '' }}">
          <a href="#"><i class="fa fa-sticky-note-o"></i> <span>{{ __('Post') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($submenu == 'list') ? 'active' : '' }}">
              <a href="{{ route('post.index') }}">
                <i class="fa fa-list"></i> <span>{{ __('Posts List') }}</span>
              </a>
            </li>
          </ul>
        </li>
        @endrole

        @role('Admin 4DX')
        {{-- Menu Post --}}
        <li class="treeview {{ ($menu=='4dx_setting') ? 'active' : '' }}">
          <a href="#"><i class="fa fa-cogs"></i> <span>{{ __('Setting 4DX') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($submenu == 'quarter') ? 'active' : '' }}">
              <a href="{{ route('quarter.index') }}">
                <i class="fa fa-cog"></i> <span>{{ __('Quarter') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'goal') ? 'active' : '' }}">
              <a href="{{ route('goal.index') }}">
                <i class="fa fa-cog"></i> <span>{{ __('Goals') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'goalDetail') ? 'active' : '' }}">
              <a href="{{ route('goalDetail.index') }}">
                <i class="fa fa-cog"></i> <span>{{ __('Goal Detail') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'quarterGoal') ? 'active' : '' }}">
              <a href="{{ route('quarterGoal.index') }}">
                <i class="fa fa-cog"></i> <span>{{ __('Quarters Goal') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'userGoal') ? 'active' : '' }}">
              <a href="{{ route('userGoal.index') }}">
                <i class="fa fa-cog"></i> <span>{{ __('Users Goal') }}</span>
              </a>
            </li>
          </ul>
        </li>
        @endrole

        @role('User 4DX')
        <li class="treeview {{ ($menu=='4dx_user') ? 'active' : '' }}">
          <a href="#"><i class="fa fa-users"></i> <span>{{ __('User 4DX') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($submenu == 'dashboardUser') ? 'active' : '' }}">
              <a href="{{ route('dashboard.user') }}">
                <i class="fa fa-dashboard"></i> <span>{{ __('Dashboard 4DX') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'bookingKredit') ? 'active' : '' }}">
              <a href="{{ route('bookingKredit.index') }}">
                <i class="fa fa-book"></i> <span>{{ __('Booking Kredit') }}</span>
              </a>
            </li>
            <!--
            <li class="{{ ($submenu == 'goalDetail') ? 'active' : '' }}">
              <a href="{{ route('goalDetail.index') }}">
                <i class="fa fa-book"></i> <span>{{ __('Booking DPK') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'quarterGoal') ? 'active' : '' }}">
              <a href="{{ route('quarterGoal.index') }}">
                <i class="fa fa-book"></i> <span>{{ __('Recovery Hapus Buku') }}</span>
              </a>
            </li>
          -->
            <li class="{{ ($submenu == 'userSetting') ? 'active' : '' }}">
              <a href="{{ route('user4dxSetting') }}">
                <i class="fa fa-cog"></i> <span>{{ __('Setting 4DX') }}</span>
              </a>
            </li>
          </ul>
        </li>
        @endrole

        @role('PUK 4DX')
        <li class="treeview {{ ($menu=='4dx_puk') ? 'active' : '' }}">
          <a href="#"><i class="fa fa-users"></i> <span>{{ __('PUK 4DX') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($submenu == 'dashboardPuk') ? 'active' : '' }}">
              <a href="{{ route('dashboard.puk') }}">
                <i class="fa fa-dashboard"></i> <span>{{ __('Dashboard 4DX') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'bookingKreditApproval') ? 'active' : '' }}">
              <a href="{{ route('approval.bookingKredit') }}">
                <i class="fa fa-book"></i> <span>{{ __('Approval Booking Kredit') }}</span>
              </a>
            </li>
            <!--
            <li class="{{ ($submenu == 'goalDetail') ? 'active' : '' }}">
              <a href="{{ route('goalDetail.index') }}">
                <i class="fa fa-book"></i> <span>{{ __('Booking DPK') }}</span>
              </a>
            </li>
            <li class="{{ ($submenu == 'quarterGoal') ? 'active' : '' }}">
              <a href="{{ route('quarterGoal.index') }}">
                <i class="fa fa-book"></i> <span>{{ __('Recovery Hapus Buku') }}</span>
              </a>
            </li>
          -->
          </ul>
        </li>
        @endrole


        <!-- Optionally, you can add icons to the links -->
        <li class="{{ ($menu=='about') ? 'active' : '' }}"><a href="{{ route('about') }}"><i class="fa fa-info-circle"></i> <span>{{ __('About') }}</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>