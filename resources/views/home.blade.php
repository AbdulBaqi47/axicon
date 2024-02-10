<?php use Illuminate\Foundation\Inspiring; ?>

@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Influencer Social</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/plyr/plyr.css') }}">

@endsection

@section('scripts')
<!-- Dependencies -->
<script src="{{ asset('assets/vendor/libs/chartjs/chartjs.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/plyr/plyr.js') }}"></script>
    
<script src="{{ asset('assets/js/ui_media-player.js') }}"></script>

<script src="{{ asset('assets/js/dashboards_dashboard-5.js') }}"></script>
@endsection

@section('content')

@if (isset($user->youtubeChannel->channel_url) or isset($user->dailymotionChannel->channel_url))
    <!-- Head stats -->
    <div class="row no-gutters bg-lighter bg-white container-p-x pb-3 container-m--x container-m--y mb-4">
        <div class="col-6 col-sm-3 col-md pt-3 pr-4">
            <div class="media align-items-center">
                <div class="ion ion-logo-youtube text-pinterest text-large"></div>
                <div class="media-body ml-3">
                    @if (isset($user->youtubeChannel->channel_url))
                    <div class="text-big font-weight-bold line-height-1">{{ number_format($user->youtubeChannel->subscriber_count) }}</div>
                    @else
                    <div class="text-big font-weight-bold line-height-1">N/A</div>
                    @endif
                    <div class="text-light text-tiny font-weight-semibold line-height-1 mt-1">SUBSCRIBERS</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-md pt-3 pr-4">
            <div class="media align-items-center">
                <div class="ion ion-md-eye text-pinterest text-large"></div>
                <div class="media-body ml-3">
                    @if (isset($user->youtubeChannel->channel_url))
                    <div class="text-big font-weight-bold line-height-1">{{ number_format($user->youtubeChannel->view_count) }}</div>
                    @else
                    <div class="text-big font-weight-bold line-height-1">N/A</div>
                    @endif
                    <div class="text-light text-tiny font-weight-semibold line-height-1 mt-1">OVERALL VIEWS</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-md pt-3 pr-4">
            <div class="media align-items-center">
                <div class="ion ion-md-videocam text-pinterest text-large"></div>
                <div class="media-body ml-3">
                    @if (isset($user->youtubeChannel->channel_url))
                    <div class="text-big font-weight-bold line-height-1">{{ number_format($user->youtubeChannel->video_count) }}</div>
                    @else
                    <div class="text-big font-weight-bold line-height-1">N/A</div>
                    @endif
                    <div class="text-light text-tiny font-weight-semibold line-height-1 mt-1">TOTAL VIDEOS</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-md pt-3 pr-4">
            <div class="media align-items-center">
                <div class="ion ion-md-camera text-twitter text-large"></div>
                <div class="media-body ml-3">
                    @if (isset($user->dailymotionChannel->channel_url))
                    <div class="text-big font-weight-bold line-height-1">{{ number_format($user->dailymotionChannel->subscriber_count) }}</div>
                    @else
                    <div class="text-big font-weight-bold line-height-1">N/A</div>
                    @endif
                    <div class="text-light text-tiny font-weight-semibold line-height-1 mt-1">DAILYMOTION FOLLOWS</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-md pt-3 pr-4">
            <div class="media align-items-center">
                <div class="ion ion-md-eye text-twitter text-large"></div>
                <div class="media-body ml-3">
                    @if (isset($user->dailymotionChannel->channel_url))
                    <div class="text-big font-weight-bold line-height-1">{{ number_format($user->dailymotionChannel->view_count) }}</div>
                    @else
                    <div class="text-big font-weight-bold line-height-1">N/A</div>
                    @endif
                    <div class="text-light text-tiny font-weight-semibold line-height-1 mt-1">DAILYMOTION VIEWS</div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Head stats -->
@else
    <!-- Head stats -->
    <div class="row no-gutters bg-lighter bg-white container-p-x pb-3 container-m--x container-m--y mb-4">
        <div class="col-12 col-sm-12 col-md pt-3 pr-4">
            <div class="media align-items-center">
                <div class="ion ion-md-link text-warning text-large"></div>
                <div class="media-body ml-3">
                    <div class="text-light line-height-1">You haven't connected your social channel(s). Please do this on the <a class="text-primary" href="{{ url('/settings') }}">settings page</a>.</div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Head stats -->
@endif

<h4 class="media align-items-center font-weight-bold py-3 mb-4">
    <!--<i class="lnr lnr-thumbs-up display-4"></i>-->
    <i class="ion ion-md-partly-sunny display-4"></i>
    <!--<i class="ion ion-ios-partly-sunny display-4"></i>-->
    <div class="media-body ml-3">
        Welcome back, {{ $user->name }}!
        <div class="text-muted text-tiny mt-1"><small class="font-weight-normal">{{ Inspiring::quote() }}</small></div>
    </div>
    @hasanyrole('admin|partner-manager')
    <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/home/edit') }}'">
    <span class="ion ion-md-brush"></span>&nbsp; Edit Home</button>
    @endhasanyrole
</h4>

@include('includes.messages')

<div class="row">

    <div class="col-xl-4">

        <!-- Side info -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="media">
                    <img src="/storage/photos/avatars/{{ $user->avatar }}" alt class="ui-w-60 rounded-circle">
                    <div class="media-body ml-3" style="padding-top: 12px;">
                        <h5 class="mb-1">{{ $user->name }}</h5>
                        @if ($user->hasRole('admin'))
                        <div class="text-muted small">Admin</div>
                        @elseif ($user->hasRole('partner-manager'))
                        <div class="text-muted small">Partner Manager</div>
                        @elseif ($user->hasRole('support'))
                        <div class="text-muted small">Support Staff</div>
                        @elseif ($user->subscribed('influencer'))
                        <div class="text-muted small">Influencer</div>
                        @else
                        <div class="text-muted small">User</div>
                        @endif
                    </div>
                </div>
            </div>
            @if (isset($user->influencer_bio) || !$user->subscribed('influencer'))
            <hr class="border-light m-0">
            <div class="card-body">
                @if ($user->subscribed('influencer'))
                    <div class="text-muted">
                        {{ $user->influencer_bio }}
                    </div>
                @else
                    <div class="text-muted">
                        You're currently <strong>not subscribed</strong> to Influencer Social.<br><br>To use our platform, please subscribe in <a href="{{ url('/settings') }}">settings</a>.
                    </div>
                @endif
                
            </div>
            @endif
        </div>
        <!-- / Side info -->

        <!-- Links -->
        @if (isset($user->youtubeChannel->channel_url) or isset($user->dailymotionChannel->channel_url) or isset($user->twitch_id) or isset($user->twitter_id) or isset($user->facebook_id) or isset($user->instagram_id))
        <div class="card mb-4">
            <div class="card-header">Social Links</div>
            <div class="card-body">

                @if (isset($user->youtubeChannel->channel_url))
                <div class="media align-items-center pb-1 mb-3">
                    <i class="ion ion-logo-youtube text-pinterest pl-2 pr-2"></i>
                    <div class="media-body flex-truncate ml-3">
                        <a href="https://youtube.com/channel/{{ $user->youtubeChannel->channel_url }}" target="_blank">YouTube</a>
                        <div class="text-muted small text-truncate">{{ $user->youtubeChannel->channel_url }}</div>
                    </div>
                </div>
                @endif

                @if (isset($user->dailymotionChannel->channel_url))
                <div class="media align-items-center pb-1 mb-3">
                    <i class="ion ion-md-videocam text-facebook pl-2 pr-2"></i>
                    <div class="media-body flex-truncate ml-3">
                        <a href="https://dailymotion.com/{{ $user->dailymotionChannel->channel_url }}" target="_blank">Dailymotion</a>
                        <div class="text-muted small text-truncate">{{ $user->dailymotionChannel->channel_id }}</div>
                    </div>
                </div>
                @endif

                @if (isset($user->twitch_id))
                <div class="media align-items-center pb-1 mb-3">
                    <i class="ion ion-logo-twitch pl-2 pr-2" style="color: #6441a5;"></i>
                    <div class="media-body flex-truncate ml-3">
                        <a href="https://{{ $user->twitch_id }}">Twitch</a>
                        <div class="text-muted small text-truncate">{{ $user->twitch_id }}</div>
                    </div>
                </div>
                @endif

                @if (isset($user->twitter_id))
                <div class="media align-items-center pb-1 mb-3">
                    <i class="ion ion-logo-twitter text-twitter pl-2 pr-2"></i>
                    <div class="media-body flex-truncate ml-3">
                        <a href="https://{{ $user->twitter_id }}">Twitter</a>
                        <div class="text-muted small text-truncate">{{ $user->twitter_id }}</div>
                    </div>
                </div>
                @endif

                @if (isset($user->facebook_id))
                <div class="media align-items-center pb-1 mb-3">
                    <i class="ion ion-logo-facebook text-facebook pl-2 pr-2"></i>
                    <div class="media-body flex-truncate ml-3">
                        <a href="https://{{ $user->facebook_id }}">Facebook</a>
                        <div class="text-muted small text-truncate">{{ $user->facebook_id }}</div>
                    </div>
                </div>
                @endif

                @if (isset($user->instagram_id))
                <div class="media align-items-center pb-1 mb-2">
                    <i class="ion ion-logo-instagram pl-2 pr-2"></i>
                    <div class="media-body flex-truncate ml-3">
                        <a href="https://{{ $user->instagram_id }}">Instagram</a>
                        <div class="text-muted small text-truncate">{{ $user->instagram_id }}</div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        @endif
        <!-- / Links -->

    </div>
    <!-- Content -->
    <div class="col">
        <div class="card mb-4">
            <div class="card-body">
                
                <div id="plyr-video-player" data-type="youtube" data-video-id="{{ $home->featured_video_url }}"></div>

                <hr class="border-light container-m--x my-4">

                <h5 class="mb-1">{{ $home->featured_video_name }}</h5>
                <div class="text-muted small text-truncate">by {{ $home->featured_video_creator }}</div>

                <div class="pt-3 pb-2">
                    <button type="button" class="btn btn-pinterest d-block" onclick="location.href='{{ url('https://www.youtube.com/watch?v='.$home->featured_video_url) }}'">
                    <span class="ion ion-logo-youtube"></span>&nbsp; View on YouTube</button>
                </div>
                

            </div>
        </div>
    </div>
    <!-- / Content -->
</div>

@endsection