<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <router-link to="/home" class="nav-link">
                <i class="nav-icon fas fa-home white"></i>
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
                    <i class="right mdi mdi-chevron-right white"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/user/my-trips" class="nav-link">
                        <i class="fas fa-user nav-icon white"></i>
                        <p>My Trips</p>
                    </router-link>
                </li>


                <li class="nav-item">
                    <router-link :to="{name:'user.sites'}" class="nav-link">
                        <i class="mdi mdi-car nav-icon purple"></i>
                        <p>All Tourist Sites</p>
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{name:'user.regions'}" class="nav-link">
                        <i class="mdi mdi-car nav-icon purple"></i>
                        <p>Tourist Sites By Region</p>
                    </router-link>
                </li>

{{--                <li class="nav-item">--}}
{{--                    <router-link to="/user/trips" class="nav-link">--}}
{{--                        <i class="mdi mdi-car nav-icon purple"></i>--}}
{{--                        <p>Trips</p>--}}
{{--                    </router-link>--}}
{{--                </li>--}}

            </ul>
        </li>
        {{--<li class="nav-item">
            <router-link to="/user/trips" class="nav-link">
                <i class="nav-icon mdi mdi-car purple"></i>
                <p>
                    Trips
                </p>
            </router-link>

        </li>--}}
        <li class="nav-item">
            <router-link to="/user/profile" class="nav-link">
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
