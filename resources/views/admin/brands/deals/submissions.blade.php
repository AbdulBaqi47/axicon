@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | {{ $brand->name }} - {{ $deal->title }} - Submissions</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-table/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/projects.css') }}">

@endsection

@section('scripts')

    <!-- Dependencies -->
    <script src="{{ asset('assets/vendor/libs/tableexport/tableexport.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    
    <script src="{{ asset('assets/vendor/libs/bootstrap-table/bootstrap-table.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-table/extensions/export/export.js') }}"></script>
    
    <script src="{{ asset('assets/js/tables_bootstrap-table.js') }}"></script>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>{{ $brand->name }}<span class="text-muted font-weight-light"> / {{ $deal->title }}</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/brands/'.$brand->id) }}'">
            <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    @include('includes.messages')

    <div class="row">
        
        <div class="col-md-4 col-xl-3">

            <!-- Request details -->
            <div class="card mb-4">
                <h6 class="card-header">Brand Details</h6>
                <ul class="list-group list-group-flush" style="padding-bottom: 10px;">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Created</div>
                        <div>{{ $deal->created_at->diffForHumans() }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Updated</div>
                        <div>{{ $deal->updated_at->diffForHumans() }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Budget</div>
                        <div><strong>{{ number_format($deal->price) }} GBP</strong></div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Status</div>
                        @if ($deal->approved == 1)
                            <div class="pb-1"><span class="badge badge-outline-success">BRAND APPROVED</span></div>
                        @else
                            @switch($deal->status)
                                @case("Proposed")
                                    <div class="pb-1"><span class="badge badge-outline-default">Proposed</span></div>
                                    @break

                                @case("Negotiating")
                                    <div class="pb-1"><span class="badge badge-outline-primary">Negotiating</span></div>
                                    @break

                                @case("In Progress")
                                    <div class="pb-1"><span class="badge badge-outline-info">In Progress</span></div>
                                    @break

                                @case("Complete")
                                    <div class="pb-1"><span class="badge badge-outline-success">Complete</span></div>
                                    @break
                            @endswitch
                        @endif
                    </li>
                </ul>
            </div>
            
            <!-- / Brand details -->

        </div>

        <div class="col">

            <!-- Request details -->
            <div class="card mb-4">
                <h6 class="card-header">Deal Description</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center mt-2 mb-1">
                        <textarea class="form-control" rows="7" readonly>{{ $deal->description }}</textarea>
                    </li>
                </ul>
            </div>
            <!-- / Brand details -->

        </div>
        
    </div>

    <hr class="pt-2 pb-2">

    <div class="card mb-4">
        <h6 class="card-header">Submission Links</h6>
        <div class="card-body">

            {!! Form::open(['action' => ['BrandDealController@updateSubmissions',$deal->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-row">
                    @foreach ($creators as $user)
                        <div class="form-group col-md-6">
                            <div class="media-body ml-1">
                                <strong class="project-attachment-filename">{{ $user->name }} #{{ $user->id }}</strong>
                                <div class="text-muted small pt-1 pb-2">
                                    <a href="mailto:{{ $user->email }}" class="text-secondary"><span class="ion ion-md-mail"></span></a> &nbsp;&nbsp;
                                    <span class="text-lighter">|</span> &nbsp;&nbsp;
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
                                {{ Form::text($user->id, $submissions[$submissionCount], ['class' => 'form-control']) }}
                                <?php $submissionCount = $submissionCount + 1 ?>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ Form::hidden('_method', 'PUT') }}

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}

            {{--<div class="row no-gutters">

                @foreach ($creators as $user)
                    <div class="col-md-12 col-lg-6 col-xl-4 p-1">
                        <div class="project-attachment p-2">
                            <div class="project-attachment-img rounded-circle" style="background-image: url('{{ asset('storage/photos/avatars/'.$user->avatar) }}')"></div>
                            <div class="media-body ml-3">
                                <strong class="project-attachment-filename">Tyler Woonton</strong>
                                <div class="text-muted small pt-1 pb-2">
                                    <a href="mailto:{{ $user->email }}" class="text-secondary"><span class="ion ion-md-mail"></span></a> &nbsp;&nbsp;
                                    <span class="text-lighter">|</span> &nbsp;&nbsp;
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
                                <div>
                                    @if ($submissions[$submissionCount] != 'null' && $submissions[$submissionCount] != null)
                                        <a href="{{ $submissions[$submissionCount] }}">View Submission</a> &nbsp;
                                    @else
                                        Submission Not Ready
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>--}}
        </div>
    </div>

@endsection