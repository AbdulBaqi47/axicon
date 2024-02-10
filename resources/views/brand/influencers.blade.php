@extends('layouts.layout-without-sidenav')


@section('styles')

    <title>Axiquo | Influencer List</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/contacts.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages_contacts.js') }}"></script>
@endsection

@section('content')

    @guest

        <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-2 mb-4">
            <div>Axiquo Influencers</div>
        </h4>
    
        @include('includes.messages')
    
        <div class="d-flex flex-wrap justify-content-between pt-3 mb-4">
            <div>
                <!-- View toggle -->
                <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                    <label class="btn btn-default icon-btn md-btn-flat active">
                        <input type="radio" name="contacts-view" value="contacts-col-view" checked> <span class="ion ion-md-apps"></span>
                    </label>
                    <label class="btn btn-default icon-btn md-btn-flat">
                        <input type="radio" name="contacts-view" value="contacts-row-view"> <span class="ion ion-md-menu"></span>
                    </label>
                </div>
                <!-- / View toggle -->
            </div>
        </div>
    
        <!-- Set `.contacts-col-view` or '.contacts-row-view' to control view mode -->
        <div class="row contacts-col-view">
            
            @foreach ($users as $user)
                @if ($user->subscribed('influencer'))
                    <div class="contacts-col col-12">
        
                        <div class="card mb-4">
                            <div class="card-body">
            
                                <div class="contact-content">
                                    <img src="/storage/photos/avatars/{{ $user->avatar }}" class="contact-content-img rounded-circle" alt="">
                                    <div class="contact-content-about">
                                        <h5 class="contact-content-name mb-2">{{ $user->name }}</h5>
                                        {{-- <div class="contact-content-user text-muted small mb-2">{{ $user->email }}</div> --}}
                                        <div class="small">
                                            @if (isset($user->influencer_bio))
                                                {{ $user->influencer_bio }}
                                            @endif
                                        </div>
                                        <hr class="border-light">
                                        <div>
                                            {{-- <a href="mailto:{{ $user->email }}" class="text-secondary"><span class="ion ion-md-mail"></span></a> &nbsp;&nbsp;
                                            <span class="text-lighter">|</span> &nbsp;&nbsp; --}}
                                            @if (isset($user->youtubeChannel->channel_url))
                                                <a href="https://youtube.com/channel/{{ $user->youtubeChannel->channel_url }}" class="text-pinterest" target="_blank"><span class="ion ion-logo-youtube"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->dailymotionChannel->channel_url))
                                                <a href="https://dailymotion.com/{{ $user->dailymotionChannel->channel_url }}" class="text-facebook" target="_blank"><span class="ion ion-ios-videocam"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->twitch_id))
                                                <a href="{{ $user->twitch_id }}" class="text-primary" target="_blank"><span class="ion ion-logo-twitch" style="color: #6441a5;"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->twitter_id))
                                                <a href="{{ $user->twitter_id }}" class="text-twitter" target="_blank"><span class="ion ion-logo-twitter"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->facebook_id))
                                                <a href="{{ $user->facebook_id }}" class="text-facebook" target="_blank"><span class="ion ion-logo-facebook"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->instagram_id))
                                                <a href="{{ $user->instagram_id }}" class="text-instagram" target="_blank"><span class="ion ion-logo-instagram"></span></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                        </div>
            
                    </div>
                @endif
            @endforeach
            
        </div><!-- / .row -->   

    @endguest

    @auth
        
        <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
            <div>Axiquo Influencers</div>
            @hasanyrole('admin|partner-manager')
            <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/users') }}'">
            <span class="ion ion-md-code"></span>&nbsp; Users Admin</button>
            @endhasanyrole
        </h4>
    
        @include('includes.messages')
    
        <div class="d-flex flex-wrap justify-content-between px-3 pt-3 mb-4">
            <div>
                <!-- View toggle -->
                <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                    <label class="btn btn-default icon-btn md-btn-flat active">
                        <input type="radio" name="contacts-view" value="contacts-col-view" checked> <span class="ion ion-md-apps"></span>
                    </label>
                    <label class="btn btn-default icon-btn md-btn-flat">
                        <input type="radio" name="contacts-view" value="contacts-row-view"> <span class="ion ion-md-menu"></span>
                    </label>
                </div>
                <!-- / View toggle -->
            </div>
        </div>
    
        <!-- Set `.contacts-col-view` or '.contacts-row-view' to control view mode -->
        <div class="row contacts-col-view">
            
            @foreach ($users as $user)
                @if ($user->subscribed('influencer'))
                    <div class="contacts-col col-12">
                        <div class="card mb-4">
                            <div class="card-body">
            
                                <div class="contact-content">
                                    <img src="/storage/photos/avatars/{{ $user->avatar }}" class="contact-content-img rounded-circle" alt="">
                                    <div class="contact-content-about">
                                        <h5 class="contact-content-name mb-1">{{ $user->name }}</h5>
                                        <div class="contact-content-user text-muted small mb-2">{{ $user->email }}</div>
                                        <div class="small">
                                            @if (isset($user->influencer_bio))
                                                {{ $user->influencer_bio }}
                                            @endif
                                        </div>
                                        <hr class="border-light">
                                        <div>
                                            <a href="mailto:{{ $user->email }}" class="text-secondary"><span class="ion ion-md-mail"></span></a> &nbsp;&nbsp;
                                            <span class="text-lighter">|</span> &nbsp;&nbsp;
                                            @if (isset($user->youtubeChannel->channel_url))
                                                <a href="https://youtube.com/channel/{{ $user->youtubeChannel->channel_url }}" class="text-pinterest" target="_blank"><span class="ion ion-logo-youtube"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->dailymotionChannel->channel_url))
                                                <a href="https://dailymotion.com/{{ $user->dailymotionChannel->channel_url }}" class="text-facebook" target="_blank"><span class="ion ion-ios-videocam"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->twitch_id))
                                                <a href="{{ $user->twitch_id }}" class="text-twitch" target="_blank"><span class="ion ion-logo-twitch" style="color: #6441a5;"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->twitter_id))
                                                <a href="{{ $user->twitter_id }}" class="text-twitter" target="_blank"><span class="ion ion-logo-twitter"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->facebook_id))
                                                <a href="{{ $user->facebook_id }}" class="text-facebook" target="_blank"><span class="ion ion-logo-facebook"></span></a> &nbsp;&nbsp;
                                            @endif
                                            @if (isset($user->instagram_id))
                                                <a href="{{ $user->instagram_id }}" class="text-instagram" target="_blank"><span class="ion ion-logo-instagram"></span></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
            
        </div><!-- / .row -->

    @endauth

@endsection