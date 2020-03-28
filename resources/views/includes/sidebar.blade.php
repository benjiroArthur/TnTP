<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{asset('assets/images/trip3.png')}}" alt="TripIt" height="50" width="auto">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid #ffffff; padding-top: 15px">
            <div class="image">
                <img src="{{Auth()->user()->userable->image}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block white">
                     Hi  {{auth()->user()->userable->first_name}}
                </a>
            </div>
        </div>

        @auth
        <!-- Sidebar Menu -->
        @if(auth()->user()->role->name == 'hotel')

        @include('includes.hotel_nav')

        @elseif(auth()->user()->role->name == 'admin')
            @include('includes.admin_nav')
        @elseif(auth()->user()->role->name == 'traveller')
            @include('includes.traveller_nav')
        @elseif(auth()->user()->role->name == 'transport')
            @include('includes.transport_nav')
        @endif
        @endauth
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

