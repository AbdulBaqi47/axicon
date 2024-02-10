@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Dashboard - Edit</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Dashboard<span class="text-muted font-weight-light"> / Edit</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/home') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Edit Dashboard
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => ['HomeController@update', $home->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Featured Video Title</label>
                    {{ Form::text('name', $home->featured_video_name, ['class' => 'form-control', 'placeholder' => '1,000,000 Subscriber Special', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Featured Video Creator</label>
                    {{ Form::text('creator', $home->featured_video_creator, ['class' => 'form-control', 'placeholder' => 'PewDiePie', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Featured Video Link</label>
                    {{ Form::text('url', $home->featured_video_url, ['class' => 'form-control', 'placeholder' => 'https://www.youtube.com/watch?v=VY4wCi1pPkU would be VY4wCi1pPkU', 'required']) }}
                </div>

                {{ Form::hidden('_method', 'PUT') }}

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection