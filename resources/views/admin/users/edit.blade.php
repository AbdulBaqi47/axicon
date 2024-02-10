<?php use Spatie\Permission\Models\Role; ?>

@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Users - {{ $user->name }}</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/users.css') }}">
@endsection

@section('scripts')

    <!-- Dependencies -->
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    
    <script src="{{ asset('assets/js/pages_users_edit.js') }}"></script>
@endsection

@section('content')

    <h4 class="font-weight-bold py-3 mb-4">
        Edit User <span class="text-muted font-weight-light"> / {{ $user->name }}</span> <span class="text-muted">#{{ $user->id }}</span>
    </h4>

    <div class="nav-tabs-top">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#user-edit-account">Account Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#user-edit-info">Social Links</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="user-edit-account">

                {!! Form::open(['action' => ['UserController@update', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body">

                    <div class="media align-items-center">
                        <img src="{{ asset('storage/photos/avatars/'. $user->avatar) }}" alt="{{ $user->name }}'s Avatar" class="d-block ui-w-80">
                        <div class="media-body ml-3">
                            <label class="form-label d-block mb-2">Avatar</label>
                            <label class="btn btn-outline-primary btn-sm">
                                Change
                                {{ Form::file('image', ['class' => 'user-edit-fileinput']) }}
                            </label>&nbsp;
                            <a href="{{ route('admin.users.avatar.reset', $user->id) }}" class="btn btn-default btn-sm md-btn-flat">Reset</a>
                        </div>
                    </div>

                </div>
                <hr class="border-light m-0">
                <div class="card-body pb-2">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="form-label">Full Name</label>
                            {{ Form::text('name', $user->name, ['class' => 'form-control', 'required']) }}
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">Account Role</label>
                            <select name="role" class="custom-select" required>
                                @if (!$user->hasAnyRole(Role::all()))
                                <option value="user" selected>User</option>
                                @else
                                <option value="user">User</option>
                                @endif

                                @if ($user->hasRole('admin'))
                                <option value="admin" selected>Admin</option>
                                @else
                                <option value="admin">Admin</option>
                                @endif

                                @if ($user->hasRole('partner-manager'))
                                <option value="partner-manager" selected>Partner Manager</option>
                                @else
                                <option value="partner-manager">Partner Manager</option>
                                @endif
                                
                                @if ($user->hasRole('support'))
                                <option value="support" selected>Support Staff</option>
                                @else
                                <option value="support">Support Staff</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        {{ Form::text('email', $user->email, ['class' => 'form-control', 'required']) }}
                    </div>

                    <div class="form-group pb-2">
                        <label class="form-label">Influencer Bio</label>
                        {{ Form::textarea('influencer_bio', $user->influencer_bio, ['class' => 'form-control mb-1', 'rows' => '2']) }}
                    </div>

                    {{ Form::hidden('_method', 'PUT') }}

                    {{ Form::submit('Update', ['class' => 'btn btn-primary mt-1 mb-3']) }}

                </div>

                {!! Form::close() !!}

            </div>

            <div class="tab-pane fade" id="user-edit-info">

                @if (isset($user->youtubeChannel->channel_url))
                    <div class="card-body mt-4">
                        <h5>
                            {!! Form::open(['action' => ['SocialAuthController@handleYoutubeRemoval', $user->id], 'method' => 'POST']) !!}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::Submit('Unlink', ['class' => 'btn btn-sm btn-secondary md-btn-flat float-right']) }}
                            {!! Form::close() !!}
                            <i class="ion ion-logo-youtube text-pinterest"></i>
                            &nbsp;User connected to YouTube:
                        </h5>
                        <a href="{{ 'https://youtube.com/channel/'.$user->youtubeChannel->channel_url }}" target="_blank">{{ $user->youtubeChannel->channel_url }}</a>
                    </div>
                @else
                    <div class="card-body mt-2">
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
                            &nbsp;User connected to Dailymotion:
                        </h5>
                        <a href="https://dailymotion.com/{{ $user->dailymotionChannel->channel_url }}" target="_blank">{{ $user->dailymotionChannel->channel_id }}</a>
                    </div>
                @else 
                    <div class="card-body pt-2 pb-2">
                        <a href="{{ url('/link/dailymotion') }}" class="btn btn-facebook"><i class="ion ion-md-videocam text-white"></i> &nbsp; Connect to <strong>Dailymotion</strong></a>
                    </div>
                @endif

                <div class="card-body">

                    {!! Form::open(['action' => ['UserController@updateSocials', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

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
        </div>
    </div>

@endsection