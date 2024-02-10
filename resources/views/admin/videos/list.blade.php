@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Admin - Featured Videos</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-table/bootstrap-table.css') }}">

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
        <div>Featured Videos</div>
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/videos/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Add Video</button>
    </h4>

    @include('includes.messages')

    <ul class="nav bg-lighter container-p-x py-1 pt-2 pb-2 container-m--x mb-4">
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'all' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos') }}">All</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'auto' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=auto') }}">Auto & Vehicles</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'beauty' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=beauty') }}">Beauty & Fashion</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'comedy' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=comedy') }}">Comedy</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'education' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=education') }}">Education</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'entertainment' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=entertainment') }}">Entertainment</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'gaming' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=gaming') }}">Gaming</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'music' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=music') }}">Music</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'blogs' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=blogs') }}">People & Blogs</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'tech' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=tech') }}">Science & Technology</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $category == 'sports' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/videos?category=sports') }}">Sports</a>
        </li>
    </ul>

    <div class="card">

        <div class="table-responsive mb-4">
            <table class="table card-table table-hover mb-0">

                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($videos as $video)
                <tr>
                    <th scope="row">{{ $video->id }}</th>
                    <td><a href="https://youtube.com/watch?v={{ $video->url }}" target="_blank">{{ $video->title }}</a></td>
                    <td>{{ ucfirst($video->category) }}</td>
                    <td>{{ $video->updated_at->diffForHumans() }}</td>
                    <td>
                        {!! Form::open(['action' => ['FeaturedVideoController@destroy', $video->id], 'method' => 'POST']) !!}
                        <button type="button" class="btn btn-sm btn-info md-btn-flat" onclick="location.href='{{ url('/admin/videos/edit/'.$video->id) }}'">Edit</button>
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::Submit('Delete', ['class' => 'btn btn-sm btn-danger md-btn-flat'])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
                
                </tbody>

            </table>

        </div>

        <hr class="border-light mt-2 mb-4">

        <nav>
            <ul class="pagination justify-content-center">
                {{ $videos->links() }}
            </ul>
        </nav>

    </div>

@endsection