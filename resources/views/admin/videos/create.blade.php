@extends('layouts.layout-2')


@section('styles')

    <title>Axiquo | Featured Videos - Create</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Featured Videos<span class="text-muted font-weight-light"> / Create</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/videos') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card">
        <div class="card-body media align-items-center">
            <div class="media-body">
                <strong>New Video</strong>
            </div>
        </div>
        <hr class="m-0">
        {!! Form::open(['action' => 'FeaturedVideoController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="card-body pb-4">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Video Title</label>
                    {{ Form::text('title', '', ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">YouTube URL</label>
                    {{ Form::text('url', '', ['class' => 'form-control', 'placeholder' => 'e.g. youtube.com/watch?v=VY4wCi1pPkU would be VY4wCi1pPkU', 'required']) }}
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Video Creator</label>
                    {{ Form::text('creator', '', ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">Category</label>
                    {{ Form::select('category', ['auto' => 'Auto & Vehicles', 'beauty' => 'Beauty & Fashion', 'comedy' => 'Comedy', 'education' => 'Education', 'entertainment' => 'Entertainment', 'gaming' => 'Gaming', 'music' => 'Music', 'blogs' => 'People & Blogs', 'tech' => 'Science & Technology', 'sports' => 'Sports'], 'auto', ['class' => 'custom-select']) }}
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Video Description</label>
                {{ Form::textarea('description', '', ['class' => 'form-control', 'rows' => '4', 'required']) }}
            </div>

            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}

        </div>

    </div>

    {!! Form::close() !!}

@endsection