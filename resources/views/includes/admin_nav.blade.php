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
            <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p class="myPss">
                    Dashboard
                </p>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link to="/manage/tourist-sites" class="nav-link">
                <i class="nav-icon fas fa-water"></i>
                <p class="myPss">
                    Tourist Sites
                </p>
            </router-link>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon mdi mdi-account-multiple purple"></i>
                <p class="myPss">
                    Manage Users
                    <i class="right mdi mdi-chevron-right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/manage/admin" class="nav-link">
                        <i class="far fa-circle nav-icon indigo"></i>
                        <p class="myPss">Administrators</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/manage/hotel" class="nav-link">
                        <i class="far fa-circle nav-icon indigo"></i>
                        <p class="myPss">Hotel</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/manage/traveller" class="nav-link">
                        <i class="far fa-circle nav-icon indigo"></i>
                        <p class="myPss">Travellers</p>
                    </router-link>
                </li>
                 <li class="nav-item">
                    <router-link to="/manage/transport" class="nav-link">
                        <i class="far fa-circle nav-icon indigo"></i>
                        <p class="myPss">Transports</p>
                    </router-link>
                 </li>

            </ul>
        </li>
        <li class="nav-item">
            <router-link to="/admin/profile" class="nav-link">
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
