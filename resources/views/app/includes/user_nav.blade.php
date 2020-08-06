@guest
  <a href="{{ route('security.login') }}" class="navbar-item login-link">
  {{ __('messages.label_login') }}
  </a>
@endguest

@auth
  <navbar-dropdown 
  id="navbar-user-dropdown"
  dropdown-classes="user-menu"
  >

  <template slot="dropdown-label">
  <x-profile-image :user="Auth::user()" size="40"/>
  </template>

  <template slot="dropdown-content">

  @section('navbar_menu_items')
    <div class="navbar-item">
    <span class="user-nav-avatar">
    <x-profile-image :user="Auth::user()" size="40"/>
    </span>
    <span 
    class="navbar-username" 
    style="margin-left: 10px;"
    >
    {{ Auth::user()->username }}
    </span>
    </div>

    <hr class="navbar-divider">

    <a class="navbar-item" href="">
    <span class="user-menu-icon">
    <i class="fas fa-edit fa-fw"></i>
    </span>
    {{ __('messages.label_edit_profile') }}
    </a>

    <hr class="navbar-divider">

    <a class="navbar-item logout-link" href="{{ route('security.logout') }}">
    <span class="user-menu-icon">
    <i class="fas fa-sign-out-alt fa-fw"></i>
    </span>
    {{ __('messages.label_logout') }}
    </a>
  @show

  </template>

  </navbar-dropdown>
@endauth