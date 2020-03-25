<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <router-link to="/home" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p class="myPss">
                    Home
                </p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/transport/dashboard" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p class="myPss">
                    Dashboard
                </p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/transport/chat" class="nav-link">
                <i class="nav-icon fas fa-bed"></i>
                <p class="myPss">
                    Rooms
                </p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/transport/chat" class="nav-link">
                <i class="fas fa-circle nav-icon green"></i>
                <p class="myPss">Bookings</p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/transport/profile" class="nav-link">
                <i class="nav-icon fas fa-user-circle orange"></i>
                <p class="myPss">
                    Profile
                </p>
            </router-link>
        </li>
        <br>
        <li class="nav-item" style="border-top: 1px solid #ffffff;">
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                <i class="fas fa-power-off nav-icon red"></i>
                <p class="myPss">
                    {{ __('Logout') }}
                </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
