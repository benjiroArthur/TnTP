@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="login-box justify-content-center ">
                <div class="login-logo">
                    <img src="{{asset('assets/images/logo.png')}}" width="auto" height="100">
                </div>
                <!-- /.login-logo -->
                <div class="card shadow">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg"><b>WELCOME</b></p>

                        <form action="{{route('login')}}" method="post" class="main-login-form loginBox">
                            @csrf

                            <div class="input-group mb-3">
                                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text divBor">
                                        <span class="fas fa-envelope text-success"></span>
                                    </div>
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <div class="input-group-append">
                                    <div class="input-group-text divBor">
                                        <span class="fas fa-lock text-success"></span>
                                    </div>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <button type="submit" class="btn btn-success btn-block">Sign In</button>
                                </div>
                                <!-- /.col -->

                                <div class="col-12">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember" name="remember">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->

                            </div>
                        </form>

                        <p class="mb-1">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </p>
                        <div class="row justify-content-center">
                            <div class="col-12 test-center">
                                <p class="text-center">----------Or----------</p>
                                <hr>
                                <p class="text-center text-danger">Don't Have Account?</p>
                            </div>

                            <div class="col-12">
                                <a href="{{route('register')}}" class="btn btn-primary form-control">Sign Up</a>
                            </div>
                        </div>

                    </div>

                    <!-- /.login-card-body -->
                </div>
            </div>
            <!-- /.login-box -->
        </div>
    </div>

@endsection
