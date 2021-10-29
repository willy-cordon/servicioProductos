<div class="main-header">
    <div class="logo">
        <img src="{{asset('img/liv.png')}}" alt="">
    </div>

    <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="d-flex align-items-center">

    </div>

    <div style="margin: auto"></div>

    <div class="header-part-right">
        <!-- Full screen toggle -->
        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
        <!-- Grid menu Dropdown -->
        @can('users_manage')
        <div class="dropdown">
            <i class="i-Gear text-muted header-icon" role="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false"></i>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="menu-icon-grid">
                    <a href="{{route('admin.users.index')}}"><i class="i-Add-User"></i> {{trans('cruds.user.title')}}</a>
                    <a href="{{route('admin.roles.index')}}"><i class="i-Lock-User"></i> {{trans('cruds.role.title')}}</a>
                </div>
            </div>

        </div>
        @endcan
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end pl-1">

                <span id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="i-Male-21 header-icon"></i>
                </span>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{ $logged_in_user->name }}
                    </div>
                    <a href="{{route('profile.change_password')}}" class="dropdown-item">
                        {{ trans('global.change_password') }}
                    </a>

                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">

                        {{ trans('global.logout') }}
                    </a>
                    <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- header top menu end -->
