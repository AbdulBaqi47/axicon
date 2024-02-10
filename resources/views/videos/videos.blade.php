@extends('layouts.layout-2')


@section('styles')

    <title>Axiquo | Featured Videos</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/plyr/plyr.css') }}">

@endsection

@section('scripts')

<!-- Dependencies -->
<script src="{{ asset('assets/vendor/libs/plyr/plyr.js') }}"></script>
<script src="{{ asset('assets/js/ui_media-player.js') }}"></script>
<script src="{{ asset('assets/js/dashboards_dashboard-5.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

@endsection


@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Featured Videos</div>
        @hasanyrole('admin|partner-manager')
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/videos') }}'">
        <span class="ion ion-md-code"></span>&nbsp; Videos Admin</button>
        @endhasanyrole
    </h4>

    @include('includes.messages')

    <ul class="nav bg-lighter container-p-x py-1 pt-2 pb-2 container-m--x mb-4">
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'all' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos') }}">All</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'auto' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=auto') }}">Auto & Vehicles</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'beauty' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=beauty') }}">Beauty & Fashion</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'comedy' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=comedy') }}">Comedy</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'education' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=education') }}">Education</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'entertainment' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=entertainment') }}">Entertainment</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'gaming' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=gaming') }}">Gaming</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'music' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=music') }}">Music</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'blogs' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=blogs') }}">People & Blogs</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'tech' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=tech') }}">Science & Technology</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'sports' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/videos?category=sports') }}">Sports</a>
        </li>
    </ul>
    
    <div class="row">
    
        @if (count($videos) > 0)

        @foreach ($videos as $video)
            <div class="col-sm-6 col-xl-4">
                <div class="card mb-4">
                    <div class="w-100">
                        <div id="plyr-video-player" data-type="youtube" data-video-id="{{ $video->url }}"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="mb-2"><a href="https://youtube.com/watch?v={{ $video->url }}" target="_blank" class="text-dark">{{ str_limit($video->title, 35) }}</a></h5>
                        <div class="text-muted small text-truncate mb-2">by {{ $video->creator }}</div>
                        <p class="text-muted mb-3">{{ str_limit($video->description, 100) }}</p>
                        <div class="media">
                            <div class="text-muted small">
                                <i class="ion ion-md-time text-primary"></i>
                                <span>{{ $video->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @else

            <p>No Videos Found.</p>

        @endif

        <hr class="border-light mt-2 mb-4">

        <nav>
            <ul class="pagination justify-content-center">
                {{ $videos->links() }}
            </ul>
        </nav>

    </div>

@endsection