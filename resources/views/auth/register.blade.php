@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="login-logo">
                    <img src="{{asset('assets/images/logo.png')}}" width="auto" height="100">
                </div>
                <div class="card shadow">

                    <div class="card-body register-card-body">
                        <p class="login-box-msg"><b>{{ __('REGISTER') }}</b></p>
                        <form method="POST" action="{{ route('register') }}" class="loginBox">
                            @csrf
                            <div class="row justify-content-center">



                                        <div class="col-12 form-group">
                                            <select class="form-control" name="user_type" id="user_type" onchange="setVals()">
                                                <option value="traveller" selected>Tourist</option>
                                                <option value="hotel">Hotel</option>
                                                {{--<option value="transport">Driver</option>--}}
                                            </select>
                                        </div>

                                {{--<div class="col-12 d-flex">
                                    <div class="row justify-content-center">
                                        <div class="col-6"><div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Tourist
                                                </label>
                                            </div></div>
                                        <div class="col-6"><div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                <label class="form-check-label" for="exampleRadios2">
                                                    Second default radio
                                                </label>
                                            </div></div>
                                    </div>
                                </div>--}}
                                        <div class="col-12 form-group" id="hotelName" hidden="hidden">
                                            <input placeholder="Hotel Name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" disabled>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>





                                           <div class="col-12 form-group userInfo">
                                               <input placeholder="Last Name" id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name" autofocus>

                                               @error('last_name')
                                               <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                 </span>
                                               @enderror
                                           </div>



                                           <div class="col-12 form-group userInfo">
                                               <input placeholder="First Name" id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" autocomplete="first_name">

                                               @error('first_name')
                                               <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                               @enderror
                                           </div>



                                           <div class="col-12 form-group userInfo">

                                               <input placeholder="Other Names" id="other_name" type="text" class="form-control @error('other_name') is-invalid @enderror" name="other_name" value="{{ old('name') }}"
                                                      autocomplete="other_name" data-slider-tooltip="Leave theis field blank if you do not have Other Name">

                                               @error('other_name')
                                               <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                            </span>
                                               @enderror
                                           </div>


                                        <div class="col-12 form-group">
                                            <input placeholder="Email" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>


                                        <div class="col-12 form-group">
                                            <input placeholder="Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>


                                        <div class="col-12 form-group">
                                            <input placeholder="Confirm Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>

                                </div>

                            <div class="row mb-0 justify-content-center">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function setVals(){

            let userType = $('#user_type').val();

            if(userType === "traveller"){
                //alert(userType);
                $('#name').attr('disabled', 'disabled');
                $('#hotelName').attr('hidden', 'hidden');
                $('.userInfo').removeAttr('hidden');
                $('.userInfo').removeAttr('disabled');
            }
            else if(userType === "hotel"){
                $('.userInfo').attr('disabled', 'disabled');
                $('.userInfo').attr('hidden', 'hidden');
                $('#hotelName').removeAttr('hidden');
                $('#name').removeAttr('disabled');
            }
            else if(userType === "transport"){
                $('#name').attr('disabled', 'disabled');
                $('#hotelName').attr('hidden', 'hidden');
                $('.userInfo').removeAttr('hidden');
                $('.userInfo').removeAttr('disabled');
            }
        }
        // $(document).ready(function(){
        //     $('#user_type').change(function(){
        //
        //     });
        //
        //
        //
        // });
    </script>
    @endsection

