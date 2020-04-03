<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
        <meta name="user-id" content="{{ Auth::user()->id }}">
        <meta name="status" content="{{ Auth::user()->active }}">
        <meta name="pro-update" content="{{ Auth::user()->profile_updated }}">
    @else
        <meta name="user-id" content="0">
        <meta name="status" content="0">
        <meta name="pro-update" content="2">
    @endauth

    <title>{{ config('app.name', 'Tripit Gh') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{--icon--}}
    <link rel="icon" href="{{asset('assets/images/logo.png')}}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini bodyColour">
<div class="wrapper" id="app">
    <!--    navbar -->
    @include('includes.navbar')

<!-- Main Sidebar Container -->

    @include('includes.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper bodyColour">

    <!-- Main content -->
    <div class="content" v-cloak>
        <div class="container-fluid mt-3">
            @include('includes.messages')
            @yield('content')

            <router-view>

                {{--Vue elements goes here--}}
            </router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>

    </div>

    <div class="animated slower myLoadDiv1" :class="true ? 'zoomOut':''" v-if="pageLoader">
        <div class="myLoadDiv2">
            <div class="justify-content-center myLoadDiv3">
                <img src="{{asset('assets/images/logo.png')}}" alt="TripIt GH" height="400px" width="auto" class="animated fadeInDown">
            </div>

        </div>
    </div>
    <!-- /.content -->


</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->

        <div class="row">
            <!-- Default to the left -->
            <div class="clo-sm-12 col-md-12 col-lg-8 text-center"> <strong>Copyright &copy; {{date('Y')}} <a href="#">  TRIPIT GH  </a>.</strong> All rights reserved.</div>
            <div class="clo-sm-12 col-md-12 col-lg-4 float-right d-sm-inline pl-2 text-center">
                Your Comfort Our Concern
            </div>
        </div>
    </footer>
</div>

<!-- ./wrapper -->

{{--scripts--}}
@yield('script')

</body>
</html>
