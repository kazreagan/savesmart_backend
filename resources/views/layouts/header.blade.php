<style>
    /* Add this style to your CSS */
    .main-navbar {
        display: flex;
        justify-content: space-between;
        width: 90%;
    }

    .navbar-right {
        margin-left: auto;
    }
</style>

<!-- Wrap your navbar content in a container with the main-navbar class -->
<div class="main-navbar">
    <form class="form-inline" action="#">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>

    <ul class="navbar-nav navbar-right">
        @if(\Illuminate\Support\Facades\Auth::user())
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="user_avatar" src="{{ asset('img/user_avatar.jpg') }}" class="rounded-circle mr-1 thumbnail-rounded user-thumbnail">
                    <div class="d-sm-none d-lg-inline-block">
                        Hi, {{\Illuminate\Support\Facades\Auth::user()->first_name}}
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-title">
                        Welcome, {{\Illuminate\Support\Facades\Auth::user()->name}}
                    </div>
                    <a class="dropdown-item has-icon edit-profile" href="#" data-id="{{ \Auth::id() }}">
                        <i class="fa fa-user"></i>Edit Profile
                    </a>
                    <a class="dropdown-item has-icon" data-toggle="modal" data-target="#changePasswordModal" href="#" data-id="{{ \Auth::id() }}">
                        <i class="fa fa-lock"></i>Change Password
                    </a>
                    <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        @else
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <div class="d-sm-none d-lg-inline-block">{{ ('messages.common.hello') }}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-title">{{ ('messages.common.login') }} / {{ ('messages.common.register') }}</div>
                    <a href="{{ route('login') }}" class="dropdown-item has-icon">
                        <i class="fas fa-sign-in-alt"></i> {{ ('messages.common.login') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('register') }}" class="dropdown-item has-icon">
                        <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
                    </a>
                </div>
            </li>
        @endif
    </ul>
</div>
