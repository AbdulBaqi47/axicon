<!DOCTYPE html>

<html lang="en" class="default-style">

<head>
    <title>Axiquo | Login</title>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900" rel="stylesheet">

    <!-- Icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/open-iconic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/pe-icon-7-stroke.css') }}">

    <!-- Core stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/bootstrap-material.css') }}" class="theme-settings-bootstrap-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/appwork-material.css') }}" class="theme-settings-appwork-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-corporate-material.css') }}" class="theme-settings-theme-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/colors-material.css') }}" class="theme-settings-colors-css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/uikit.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">

    <script src="{{ asset('assets/vendor/js/material-ripple.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/layout-helpers.js') }}"></script>

    <!-- Theme settings -->
    <!-- This file MUST be included after core stylesheets and layout-helpers.js in the <head> section -->
    <script src="{{ asset('assets/vendor/js/theme-settings.js') }}"></script>

    <!-- Core scripts -->
    <script src="{{ asset('assets/vendor/js/pace.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <!-- Libs -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/authentication.css') }}">
</head>

<body>
<div class="page-loader">
    <div class="bg-primary"></div>
</div>

<!-- Content -->

<div class="authentication-wrapper authentication-3">
    <div class="authentication-inner">

        <!-- Side container -->
        <!-- Do not display the container on extra small, small and medium screens -->
        <div class="d-none d-lg-flex col-lg-8 align-items-center ui-bg-cover ui-bg-overlay-container p-5" style="background-image: url('{{ asset('assets/img/bg/21.jpg') }}');">
            <div class="ui-bg-overlay bg-dark opacity-50"></div>

            <!-- Text -->
            <div class="w-100 text-white px-5">
                <h1 class="display-2 font-weight-bolder mb-4">Axiquo Media Group</h1>
                <div class="text-large font-weight-light">
                    Empowering Content Creators & Brands
                </div>
            </div>
            <!-- /.Text -->
        </div>
        <!-- / Side container -->

        <!-- Form container -->
        <div class="d-flex col-lg-4 align-items-center bg-white p-5">
            <!-- Inner container -->
            <!-- Have to add `.d-flex` to control width via `.col-*` classes -->
            <div class="d-flex col-sm-7 col-md-5 col-lg-12 px-0 px-xl-4 mx-auto">
                <div class="w-100">

                    <!-- Logo --/>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="ui-w-100">
                            <div class="" style="margin-bottom: 50%;">
                                <img style="width: 280px; height: 56px; margin-right: 100px;" draggable="false" src="{{ asset('storage/img/influencer-social-logo.png') }}" alt="Axiquo Logo">
                            </div>
                        </div>
                    </div>
                    <!- / Logo -->

                <h4 class="text-center text-lighter font-weight-normal mt-5 pb-3 mb-10">Account Login</h4>

                <!-- Form -->
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="form-label">Email Address</label>

                        <div class="">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <em>{{ $errors->first('email') }}</em>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="form-label d-flex justify-content-between align-items-end">
                            <div>Password</div>
                            <a href="{{url('/password/reset')}}" class="d-block small">Reset password?</a>
                        </label>
                        <div class="">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <em>{{ $errors->first('password') }}</em>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center m-0">

                        <label class="custom-control custom-checkbox m-0">
                            <input type="checkbox" class="custom-control-input" name="remember" {{ old('remember') ? 'checked' : ''}}>
                            <span class="custom-control-label">Remember Me</span>
                        </label>

                        <button type="submit" class="btn btn-primary">Sign In</button>

                    </div>

                </form>

                <!-- / Form -->

                <div class="text-center text-muted" style="padding-top: 30px;">
                    Don't have an account yet?
                    <a href="{{ url('/register') }}">Sign Up</a>
                </div>

                <div class="mt-20">
                    <hr>
                    <div class="pt-20">
                        <!--<a class="btn btn-danger" href="{{ url('/login/youtube') }}">
                            <span class="fab fa-youtube"></span>&nbsp;&nbsp; Login with YouTube
                        </a>

                        <button type="button" class="btn btn-primary" style="margin-left: 5px;">
                            <span class="fas fa-video"></span>&nbsp;&nbsp;DailyMotion
                        </button>-->
                    </div>
                </div>

            </div>
        </div>
        <!-- / Form container -->

    </div>
</div>

<!-- / Content -->

<!-- Core scripts -->
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/js/sidenav.js') }}"></script>

<!-- Libs -->
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<!-- Demo -->
<script src="{{ asset('assets/js/demo.js') }}"></script>

</body>

</html>