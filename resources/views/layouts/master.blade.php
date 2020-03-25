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
<div class="wrapper bodyColour" id="app">
    <!--    navbar -->
    @include('includes.navbar')

<!-- Main Sidebar Container -->

    @include('includes.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper bodyColour">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid mt-3">
            @include('includes.messages')
            @yield('content')
            <transition name="router-anim" enter-active-class="animated fadeInDown" leave-active-class="animated fadeOutDown">
            <router-view class="bodyColour">

                {{--Vue elements goes here--}}
            </router-view>
            </transition>
            <vue-progress-bar></vue-progress-bar>
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
