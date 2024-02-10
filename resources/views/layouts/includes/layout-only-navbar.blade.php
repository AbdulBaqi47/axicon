<!-- Layout navbar -->
<nav class="layout-navbar navbar navbar-expand-lg align-items-lg-center bg-white container-p-x" id="layout-navbar">

    @empty($hide_layout_sidenav_toggle)
    <!-- Sidenav toggle (see resources/assets/css/demo.css) -->
    <div class="layout-sidenav-toggle navbar-nav d-lg-none align-items-lg-center mr-auto">
        <a class="nav-item nav-link px-0 mr-lg-4" href="javascript:void(0)">
            <i class="ion ion-md-menu text-large align-middle"></i>
        </a>
    </div>
    @endempty

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#layout-navbar-collapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="layout-navbar-collapse">
        <!-- Divider -->
        <hr class="d-lg-none w-100 my-2">

        <div class="navbar-nav align-items-lg-center">
            <a href="/">
                <!--<img class="w-50 h-50" draggable="false" src="{{ asset('storage/svg/logo-1.svg') }}" alt="Axiquo Logo">-->
                <!--<img class="w-150 h-150" draggable="false" src="{{ asset('storage/img/influencer-social-logo.png') }}" alt="Axiquo Logo">-->
                <img class="w-25" draggable="false" src="{{ asset('storage/img/influencer-social-logo.png') }}" alt="Axiquo Logo">
            </a>  
        </div>

        <div class="navbar-nav align-items-lg-center ml-auto">

            @guest
        
                <div class="demo-navbar-user nav-item">
                    
                    <a class="nav-link">
                        <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                            <span class="px-1 mr-lg-2 ml-2 ml-lg-0"></span>
                        </span>
                    </a>

                </div>

            @endguest

            @auth

            <!-- Divider -->
            <div class="nav-item d-none d-lg-block text-big font-weight-light line-height-1 opacity-25 mr-3 ml-1">|</div>
                
                <div class="demo-navbar-user nav-item dropdown">
                    
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <span class="d-inline-flex flex-lg-row-reverse align-items-center align-middle">
                            <img src="{{ asset('storage/photos/avatars/' . Auth::user()->avatar) }}" alt class="d-block ui-w-30 rounded-circle">
                            <span class="px-1 mr-lg-2 ml-2 ml-lg-0">{{ Auth::user()->name }}</span>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">

                        <a href="/support" class="dropdown-item"><i class="ion ion-md-help-buoy text-lightest"></i> &nbsp; Support</a>
                        <a href="/settings" class="dropdown-item"><i class="ion ion-ios-mail text-lightest"></i> &nbsp; Settings</a>
                        
                        <div class="dropdown-divider"></div>

                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ion ion-ios-log-out text-danger"></i> 
                            &nbsp; {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </div>

            @endauth

        </div>
    </div>
</nav>
<!-- / Layout navbar -->
