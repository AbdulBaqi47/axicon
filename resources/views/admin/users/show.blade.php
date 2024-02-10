@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Users - {{ $user->name }}</title>

    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/users.css') }}">
@endsection

@section('content')
    <div class="media align-items-center py-3 mb-3">
        <img src="{{ asset('storage/photos/avatars/'.$user->avatar) }}" alt="" class="d-block ui-w-100 rounded-circle">
        <div class="media-body ml-4">
            <h4 class="font-weight-bold mb-0">{{ $user->name }}</h4>
            <div class="text-muted mb-2">User ID: {{ $user->id }}</div>
            {!! Form::open(['action' => ['UserController@destroy', $user->id], 'method' => 'POST']) !!}
            <a href="/admin/users/edit/{{ $user->id }}" class="btn btn-primary btn-sm md-btn-flat">Edit</a>&nbsp;
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::Submit('Delete', ['class' => 'btn btn-danger btn-sm md-btn-flat'])}}
            {!! Form::close() !!}
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table user-view-table m-0">
                <tbody>
                    <tr>
                        <td>Registered:</td>
                        <td>{{ date_format($user->created_at,"d F Y @ h:i A") }}</td>
                    </tr>
                    <tr>
                        <td>Latest update:</td>
                        <td>{{ date_format($user->updated_at,"d F Y @ h:i A") }}</td>
                    </tr>
                    <tr>
                        <td>Subscription:</td>

                        @if ($user->subscribed('influencer') and $user->subscription('influencer')->onGracePeriod())
                            <td>Cancelling - Influencer</td>
                        @elseif ($user->subscribed('influencer'))
                            <td>Active - Influencer</td>
                        @else
                            <td>No Subscription</td>
                        @endif

                    </tr>
                    <tr>
                        <td>Role:</td>
                        @if ($user->hasRole('admin'))
                        <td><span class="badge badge-outline-success">Admin</span></td>
                        @elseif ($user->hasRole('partner-manager'))
                        <td><span class="badge badge-outline-success">Partner Manager</span></td>
                        @elseif ($user->hasRole('support'))
                        <td><span class="badge badge-outline-success">Support</span></td>
                        @else
                        <td><span class="badge badge-outline-success">User</span></td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <h6 class="mt-2 mb-3">Personal Info</h6>

            <table class="table user-view-table m-0">
                <tbody>
                    <tr>
                        <td>Name:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>Influencer Bio:</td>
                        <td>{{ $user->influencer_bio }}</td>
                    </tr>
                </tbody>
            </table>

            <h6 class="mt-4 mb-3">Social links</h6>

            <table class="table user-view-table m-0">
                <tbody>
                    
                    <tr>
                        <td>YouTube:</td>
                        @if (isset($user->youtubeChannel->channel_url))
                            <td><a href="https://youtube.com/channel/{{ $user->youtubeChannel->channel_url }}">https://youtube.com/channel/{{ $user->youtubeChannel->channel_url }}</a></td>
                        @endif
                    </tr>
                    
                    <tr>
                        <td>DailyMotion:</td>
                        @if (isset($user->dailymotionChannel->channel_url))
                            <td><a href="https://dailymotion.com/{{ $user->dailymotionChannel->channel_url }}" target="_blank">https://dailymotion.com/{{ $user->dailymotionChannel->channel_url }}</a></td>
                        @endif
                    </tr>
                    
                    <tr>
                        <td>Twitch:</td>
                        @if (isset($user->twitch_id))
                            <td><a href="{{ $user->twitch_id }}">{{ $user->twitch_id }}</a></td>
                        @endif
                    </tr>

                    <tr>
                        <td>Twitter:</td>
                        @if (isset($user->twitter_id))
                            <td><a href="{{ $user->twitter_id }}">{{ $user->twitter_id }}</a></td>
                        @endif
                    </tr>

                    <tr>
                        <td>Facebook:</td>
                        @if (isset($user->facebook_id))
                            <td><a href="{{ $user->facebook_id }}">{{ $user->facebook_id }}</a></td>
                        @endif
                    </tr>
                    
                    <tr>
                        <td>Instagram:</td>
                        @if (isset($user->instagram_id))
                            <td><a href="{{ $user->instagram_id }}">{{ $user->instagram_id }}</a></td>
                        @endif
                    </tr>
                    
                </tbody>
            </table>

            <h6 class="mt-4 mb-3">Payment Info</h6>

            <table class="table user-view-table m-0">
                <tbody>
                    <tr>
                        <td>Braintree ID:</td>
                        <td>{{ $user->braintree_id }}</td>
                    </tr>
                    <tr>
                        <td>Paypal Email:</td>
                        <td>{{ $user->paypal_email }}</td>
                    </tr>
                    <tr>
                        <td>Card Brand:</td>
                        <td>{{ $user->card_brand }}</td>
                    </tr>
                    <tr>
                        <td>Card Last 4:</td>
                        <td>{{ $user->card_last_four }}</td>
                    </tr>
                    <tr>
                        <td>Subscription Ends:</td>
                        @if($user->subscribed('influencer'))
                        <td>{{ $user->subscription('influencer')->ends_at }}</td>
                        @else
                        <td></td>
                        @endif
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    
@endsection