<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{asset('assets/images/logo.png')}}" alt="HealthCareSystem" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="fas fa-car"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('assets/images/user.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{--                    {{auth()->user()->full_name}}--}}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        @if(auth()->user()->role->name = 'hotel')
        @include('includes.hotel_nav')
        @elseif(auth()->user()->role->name = 'admin')
            @include('includes.admin_nav')
        @elseif(auth()->user()->role->name = 'traveller')
            @include('includes.traveller_nav')
        @elseif(auth()->user()->role->name = 'transport')
            @include('includes.transport_nav')
        @endif
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
