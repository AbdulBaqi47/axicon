<?php $routeName = Route::currentRouteName(); ?>

<!-- Layout sidenav -->
<div id="layout-sidenav" class="{{ isset($layout_sidenav_horizontal) ? 'layout-sidenav-horizontal sidenav-horizontal container-p-x flex-grow-0' : 'layout-sidenav sidenav-vertical' }} sidenav bg-sidenav-theme">
    @empty($layout_sidenav_horizontal)
    
    <div class="demo-brand">

        <!--<img class="w-50 h-50" draggable="false" src="{{ asset('storage/svg/logo-1.svg') }}" alt="Axiquo Logo">-->
        <!--<a href="/" class="demo-brand-name sidenav-text font-weight-normal ml-2">Axiquo</a>-->
        <img class="w-100" draggable="false" src="{{ asset('storage/img/influencer-social-logo.png') }}" alt="Axiquo Logo">

    </div>

    <div class="sidenav-divider mt-0"></div>
    @endempty

    <!-- Links -->
    <ul class="sidenav-inner{{ empty($layout_sidenav_horizontal) ? ' py-1' : '' }}">

        <!-- Dashboard -->
        <li class="sidenav-item{{ $routeName == 'home' ? ' active' : '' }}">
            <a href="{{ url('/home') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-speedometer"></i><div>Dashboard</div></a>
        </li>

        <!-- User Settings -->
        <li class="sidenav-item{{ $routeName == 'user.settings' ? ' active' : '' }}">
            <a href="{{ url('/settings') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-cog"></i><div>Settings</div></a>
        </li>

        {{-- 
            INFLUENCER MENU
        --}}

        @if (Auth::user()->subscribed('influencer') or Auth::user()->hasRole('admin'))
            
            <li class="sidenav-header small font-weight-semibold">INFLUENCER</li>

            <li class="sidenav-item{{ $routeName == 'apps.apps' ? ' active' : '' }}">
                <a href="{{ url('/apps') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-appstore"></i><div>Apps</div></a>
            </li>

            <li class="sidenav-item{{ $routeName == 'sponsorships.sponsorships' ? ' active' : '' }}">
                <a href="{{ url('/sponsorships') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-gift"></i><div>Sponsorships</div></a>
            </li>

            <li class="sidenav-item{{ $routeName == 'education.education' ? ' active' : '' }}">
                <a href="{{ url('/education') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-bookmarks"></i><div>Education</div></a>
            </li>

            <li class="sidenav-item{{ $routeName == 'requests.requests' ? ' active' : '' }}">
                <a href="{{ url('/requests') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-create"></i><div>Requests</div></a>
            </li>

            <li class="sidenav-item{{ $routeName == 'gear.gear' ? ' active' : '' }}">
                <a href="{{ url('/gear') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-laptop"></i><div>Gear</div></a>
            </li>

            <li class="sidenav-item{{ $routeName == 'videos.videos' ? ' active' : '' }}">
                <a href="{{ url('/videos') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-camera"></i><div>Featured Videos</div></a>
            </li>

            <li class="sidenav-item{{ $routeName == 'downloads.downloads' ? ' active' : '' }}">
                <a href="{{ url('/downloads') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-cloud-download"></i><div>Downloads</div></a>
            </li>

            {{--<li class="sidenav-item{{ $routeName == 'analytics.analytics' ? ' active' : '' }}">
                <a href="{{ url('/analytics') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-analytics"></i><div>Analytics</div></a>
            </li>--}}

        @endif



        {{--
            BRAND MENU
        --}}

        @role('admin|brand')
        <li class="sidenav-header small font-weight-semibold">BRAND</li>

        <li class="sidenav-item{{ $routeName == 'brand.deals.list' ? ' active' : '' }}">
            <a href="{{ url('/brand/deals') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-paper"></i><div>Brand Deals</div></a>
        </li>
        <li class="sidenav-item{{ $routeName == 'brand.influencers' ? ' active' : '' }}">
            <a href="{{ url('/brand/influencers') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-megaphone"></i><div>Influencer List</div></a>
        </li>
        @endrole



        {{-- 
            ADMINISTRATOR MENU
        --}}

        @role('admin')
        <li class="sidenav-header small font-weight-semibold">ADMINISTRATOR</li>

        <li class="sidenav-item{{ $routeName == 'admin.users.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/users') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-contacts"></i><div>Users</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.tasks.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/tasks') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-clipboard"></i><div>Tasks</div></a>
        </li>

        {{--<li class="sidenav-item{{ $routeName == 'admin.subscriptions.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/subscriptions') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-card"></i><div>Subscriptions</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.stats.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/stats') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-trending-up"></i><div>Platform Stats</div></a>
        </li>--}}

        <!-- Feature Management Dropdown -->
        <li class="sidenav-item{{ strpos($routeName, 'admin.*') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-md-list"></i><div>Feature Manager</div></a>

            <ul class="sidenav-menu">

                <li class="sidenav-item{{ $routeName == 'admin.apps.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/apps') }}" class="sidenav-link"><div>Apps</div></a>
                </li>

                <li class="sidenav-item{{ $routeName == 'admin.sponsorships.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/sponsorships') }}" class="sidenav-link"><div>Sponsorships</div></a>
                </li>

                <li class="sidenav-item{{ $routeName == 'admin.education.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/education') }}" class="sidenav-link"><div>Education</div></a>
                </li>

                <li class="sidenav-item{{ $routeName == 'admin.requests.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/requests') }}" class="sidenav-link"><div>Requests</div></a>
                </li>

                <li class="sidenav-item{{ $routeName == 'admin.gear.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/gear') }}" class="sidenav-link"><div>Gear</div></a>
                </li>

                <li class="sidenav-item{{ $routeName == 'admin.videos.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/videos') }}" class="sidenav-link"><div>Featured Videos</div></a>
                </li>

                <li class="sidenav-item{{ $routeName == 'admin.downloads.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/downloads') }}" class="sidenav-link"><div>Downloads</div></a>
                </li>

                <li class="sidenav-item{{ $routeName == 'admin.brands.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/brands') }}" class="sidenav-link"><div>Brand Deals</div></a>
                </li>

                <li class="sidenav-item{{ $routeName == 'admin.support.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/support') }}" class="sidenav-link"><div>Support Tickets</div></a>
                </li>

                <li class="sidenav-item{{ $routeName == 'admin.cms.list' ? ' active' : '' }}">
                    <a href="{{ url('/admin/cms') }}" class="sidenav-link"><div>DailyMotion CMS</div></a>
                </li>

            </ul>
        </li>
        @endrole

        {{-- 
            PARTNER MANAGER MENU
        --}}

        @role('partner-manager')
        <li class="sidenav-header small font-weight-semibold">PARTNER MANAGER</li>

        <li class="sidenav-item{{ $routeName == 'admin.tasks.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/tasks') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-clipboard"></i><div>Tasks</div></a>
        </li>
        
        <li class="sidenav-item{{ $routeName == 'admin.apps.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/apps') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-appstore"></i><div>Apps</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.sponsorships.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/sponsorships') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-gift"></i><div>Sponsorships</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.education.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/education') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-bookmarks"></i><div>Education</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.requests.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/requests') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-create"></i><div>Requests</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.gear.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/gear') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-laptop"></i><div>Gear</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.videos.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/videos') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-camera"></i><div>Featured Videos</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.downloads.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/downloads') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-cloud-download"></i><div>Downloads</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.brands.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/brands') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-contacts"></i><div>Brand Deals</div></a>
        </li>

        <li class="sidenav-item{{ $routeName == 'admin.support.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/support') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-help-buoy"></i><div>Support Tickets</div></a>
        </li>
        @endrole


        {{-- 
            SUPPORT USER MENU
        --}}

        @role('support')
        <li class="sidenav-header small font-weight-semibold">SUPPORT STAFF</li>

        <li class="sidenav-item{{ $routeName == 'admin.tasks.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/tasks') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-clipboard"></i><div>Tasks</div></a>
        </li>
        
        <li class="sidenav-item{{ $routeName == 'admin.support.list' ? ' active' : '' }}">
            <a href="{{ url('/admin/support') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-help-buoy"></i><div>Support Tickets</div></a>
        </li>
        @endrole        
        
    </ul>
</div>
<!-- / Layout sidenav -->
