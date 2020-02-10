<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <router-link to="/home" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Home
                </p>
            </router-link>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon mdi mdi-account-multiple purple"></i>
                <p>
                    Trips
                    <i class="right mdi mdi-chevron-right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/admin/upcoming-appointment" class="nav-link">
                        <i class="far fa-circle nav-icon indigo"></i>
                        <p>My Trips</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/past-appointment" class="nav-link">
                        <i class="far fa-circle nav-icon indigo"></i>
                        <p>Add Trip</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/past-appointment" class="nav-link">
                        <i class="far fa-circle nav-icon indigo"></i>
                        <p>Bookings</p>
                    </router-link>
                </li>

            </ul>
        </li>
        <li class="nav-item">
            <router-link to="/user/profile" class="nav-link">
                <i class="nav-icon fas fa-user-circle orange"></i>
                <p>
                    Profile
                </p>
            </router-link>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="preventDefault();
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
