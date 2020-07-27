<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        {{--<li class="nav-item">
            <router-link to="/admin/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt yellow"></i>
                <p>
                    Dashboard
                </p>
            </router-link>
        </li>--}}
        <li class="nav-item">
            <router-link to="/manage/tourist-sites" class="nav-link">
                <i class="nav-icon fas fa-water blue"></i>
                <p>
                    Tourist Sites
                </p>
            </router-link>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon mdi mdi-account-multiple purple"></i>
                <p>
                    Manage Users
                    <i class="right mdi mdi-chevron-right white"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/manage/admin" class="nav-link">
                        <i class="fas fa-user nav-icon white"></i>
                        <p>Administrators</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/manage/hotel" class="nav-link">
                        <i class="fas fa-hotel nav-icon white"></i>
                        <p>Hotel</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/manage/traveller" class="nav-link">
                        <i class="fas fa-walking nav-icon white"></i>
                        <p>Tourist</p>
                    </router-link>
                </li>
                 {{--<li class="nav-item">
                    <router-link to="/manage/transport" class="nav-link">
                        <i class="fas fa-car nav-icon white"></i>
                        <p>Transports</p>
                    </router-link>
                 </li>--}}

            </ul>
        </li>
        <li class="nav-item">
            <router-link to="/admin/profile" class="nav-link">
                <i class="nav-icon fas fa-user-circle orange"></i>
                <p>
                    Profile
                </p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/password/update" class="nav-link">
                <i class="nav-icon fas fa-lock yellow"></i>
                <p>
                    Password Update

                </p>
            </router-link>
        </li>

<br>
        <li class="nav-item" style="border-top: 1px solid #ffffff;">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off nav-icon red"></i>
                <p>
                    {{ __('Logout') }}
                </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
