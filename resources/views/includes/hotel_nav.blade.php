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
        <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    Dashboard
                </p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/chat" class="nav-link">
                <i class="nav-icon fas fa-bed"></i>
                <p>
                    Rooms
                </p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/user/chat" class="nav-link">
                <i class="fas fa-circle nav-icon green"></i>
                <p>Bookings</p>
            </router-link>
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
