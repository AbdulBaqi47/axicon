@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Settings</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/account.css') }}">
@endsection

@section('scripts')
    <!-- Braintree API Drop-In UI -->
    <script src="https://js.braintreegateway.com/web/dropin/1.14.1/js/dropin.min.js"></script>

    <!-- Dependencies -->
    <script src="/js/app.js" defer></script>

@endsection

@section('content')
    <h4 class="font-weight-bold py-3 mb-4">
        Account settings
    </h4>

    @include('includes.messages')

    <div class="card overflow-hidden mb-2">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-connections">Connections</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-subscription">Subscription</a>
                    @role('admin')
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-api">Axiquo API</a>
                    @endrole
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="account-general">

                        {!! Form::open(['action' => ['SettingController@update', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            
                            <div class="card-body media align-items-center">
                                <img src="storage/photos/avatars/{{ $user->avatar }}" alt="{{ $user->name }}'s Avatar'" class="d-block ui-w-80 rounded-circle">
                                <div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">
                                        Upload new photo
                                        {{ Form::file('image', ['class' => 'account-settings-fileinput']) }}
                                    </label> &nbsp;
                                    <a href="{{ route('avatar.reset') }}" class="btn btn-default md-btn-flat">Reset</a>
                                </div>
                            </div>

                            <hr class="border-light m-0">

                            <div class="card-body">
        
                                    <div class="form-group">
                                        <label class="form-label">Full Name</label>
                                        {{ Form::text('name', $user->name, ['class' => 'form-control', 'required']) }}
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Email Address</label>
                                        {{ Form::text('email', $user->email, ['class' => 'form-control', 'required']) }}
                                    </div>

                                    <div class="form-group pb-2">
                                        <label class="form-label">Influencer Bio</label>
                                        {{ Form::textarea('influencer_bio', $user->influencer_bio, ['class' => 'form-control', 'rows' => '2']) }}
                                    </div>

                                    {{ Form::hidden('_method', 'PUT') }}

                                    {{ Form::submit('Update', ['class' => 'btn btn-primary mt-2']) }}
                                
                            </div>

                        {!! Form::close() !!}

                    </div>

                    <div class="tab-pane fade" id="account-connections">

                        @if (isset($user->youtubeChannel->channel_url))
                            <div class="card-body mt-4">
                                <h5>
                                    {!! Form::open(['action' => ['SocialAuthController@handleYoutubeRemoval', $user->id], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::Submit('Unlink', ['class' => 'btn btn-sm btn-secondary md-btn-flat float-right']) }}
                                    {!! Form::close() !!}
                                    <i class="ion ion-logo-youtube text-pinterest"></i>
                                    &nbsp;You are connected to YouTube:
                                </h5>
                                <a href="{{ 'https://youtube.com/channel/'.$user->youtubeChannel->channel_url }}" target="_blank">{{ $user->youtubeChannel->channel_url }}</a>
                            </div>
                        @else
                            <div class="card-body mt-4">
                                <a href="{{ url('/link/youtube') }}" class="btn btn-pinterest"><i class="ion ion-logo-youtube text-white"></i> &nbsp; Connect to <strong>YouTube</strong></a>
                            </div>
                        @endif

                        @if (isset($user->dailymotionChannel->channel_url))
                            <div class="card-body pt-2 pb-2">
                                <h5>
                                    {!! Form::open(['action' => ['SocialAuthController@handleDailymotionRemoval', $user->id], 'method' => 'POST']) !!}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::Submit('Unlink', ['class' => 'btn btn-sm btn-secondary md-btn-flat float-right']) }}
                                    {!! Form::close() !!}
                                    <i class="ion ion-md-videocam text-facebook"></i>
                                    &nbsp;You are connected to Dailymotion:
                                </h5>
                                <a href="https://dailymotion.com/{{ $user->dailymotionChannel->channel_url }}" target="_blank">{{ $user->dailymotionChannel->channel_id }}</a>
                            </div>
                        @else 
                            <div class="card-body pt-2 pb-2">
                                <a href="{{ url('/link/dailymotion') }}" class="btn btn-facebook"><i class="ion ion-md-videocam text-white"></i> &nbsp; Connect to <strong>Dailymotion</strong></a>
                            </div>
                        @endif

                        <div class="card-body">

                            {!! Form::open(['action' => ['SettingController@updateSocials', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                                <div class="form-group pb-3">
                                    <label class="form-label">Twitch</label>
                                    {{ Form::text('twitch_id', $user->twitch_id, ['class' => 'form-control', 'placeholder' => 'twitch.tv/username']) }}
                                </div>

                                <div class="form-group pb-3">
                                    <label class="form-label">Twitter</label>
                                    {{ Form::text('twitter_id', $user->twitter_id, ['class' => 'form-control', 'placeholder' => 'twitter.com/username']) }}
                                </div>

                                <div class="form-group pb-3">
                                    <label class="form-label">Facebook</label>
                                    {{ Form::text('facebook_id', $user->facebook_id, ['class' => 'form-control', 'placeholder' => 'facebook.com/username']) }}
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Instagram</label>
                                    {{ Form::text('instagram_id', $user->instagram_id, ['class' => 'form-control', 'placeholder' => 'instagram.com/username']) }}
                                </div>

                                {{ Form::hidden('_method', 'PUT') }}

                                {{ Form::submit('Update', ['class' => 'btn btn-primary mt-3']) }}

                            {!! Form::close() !!}

                        </div>
                    </div>

                    <div class="tab-pane fade" id="account-subscription">
                        <div class="card-body mt-2 mb-2">

                            @if ($user->subscribed('influencer') and $user->subscription('influencer')->onGracePeriod())
                                
                                <h5>Your subscription ends on {{ $user->subscription('influencer')->ends_at->format('dS M Y') }}</h5>
                                
                                @if (isset($user->card_last_four))
                                    <div class="card-body pt-4 pb-2">
                                        <h6>
                                            {!! Form::open(['action' => ['SubscriptionController@resume'], 'method' => 'POST']) !!}
                                                {{ Form::Submit('Resume', ['class' => 'btn btn-sm btn-secondary md-btn-flat float-right']) }}
                                            {!! Form::close() !!}
                                            <i class="far fa-credit-card text-danger"></i>
                                            &nbsp;£15 /month using {{ $user->card_brand }} card:
                                        </h6>
                                        <p class="text-muted">**** **** **** {{ $user->card_last_four }}</p>
                                    </div>
                                @else
                                    <div class="card-body pt-4 pb-2">
                                        <h6>
                                            {!! Form::open(['action' => ['SubscriptionController@resume'], 'method' => 'POST']) !!}
                                                {{ Form::Submit('Resume', ['class' => 'btn btn-sm btn-secondary md-btn-flat float-right']) }}
                                            {!! Form::close() !!}
                                            <i class="fab fa-paypal text-danger"></i>
                                            &nbsp;£15 /month using PayPal:
                                        </h6>
                                        <p class="text-muted">{{ $user->paypal_email }}</p>
                                    </div>
                                @endif

                            @elseif ($user->subscribed('influencer'))
                                
                                <h5>You have an ongoing subscription to Influencer Social.</h5>

                                @if (isset($user->card_last_four))
                                    <div class="card-body pt-4 pb-2">
                                        <h6>
                                            {!! Form::open(['action' => ['SubscriptionController@cancel'], 'method' => 'POST']) !!}
                                                {{ Form::Submit('Cancel', ['class' => 'btn btn-sm btn-secondary md-btn-flat float-right']) }}
                                            {!! Form::close() !!}
                                            <i class="far fa-credit-card text-success"></i>
                                            &nbsp;£15 /month using {{ $user->card_brand }} card:
                                        </h6>
                                        <p class="text-muted">**** **** **** {{ $user->card_last_four }}</p>
                                    </div>
                                @else
                                    <div class="card-body pt-4 pb-2">
                                        <h6>
                                            {!! Form::open(['action' => ['SubscriptionController@cancel'], 'method' => 'POST']) !!}
                                                {{ Form::Submit('Cancel', ['class' => 'btn btn-sm btn-secondary md-btn-flat float-right']) }}
                                            {!! Form::close() !!}
                                            <i class="fab fa-paypal text-success"></i>
                                            &nbsp;£15 /month using PayPal:
                                        </h6>
                                        <p class="text-muted">{{ $user->paypal_email }}</p>
                                    </div>
                                @endif

                            @else
                                
                                @include('user.subscriptions')
                                
                            @endif

                        </div>
                    </div>

                    @role('admin')
                    <div class="tab-pane fade" id="account-api">
                        <div class="mt-2 mb-2" id="application">
                            
                            <passport-clients></passport-clients>
                            <passport-authorized-clients></passport-authorized-clients>
                            <passport-personal-access-tokens></passport-personal-access-tokens>

                        </div>
                    </div>
                    @endrole
                    
                </div>
            </div>
        </div>
    </div>

@endsection