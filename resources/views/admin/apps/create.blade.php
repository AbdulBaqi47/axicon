@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Apps - Create</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Apps<span class="text-muted font-weight-light"> / Create</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/apps') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Create App
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => 'AppController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">App Title</label>
                        {{ Form::text('title', '', ['class' => 'form-control', 'required']) }}
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">App Link</label>
                        {{ Form::text('link', '', ['class' => 'form-control', 'required']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    {{ Form::textarea('description', '', ['class' => 'form-control', 'rows' => '3', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Powered By</label>
                    {{ Form::text('added_by', '', ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group pb-1">
                    <label class="form-label w-100 pb-2">App Image (Max 2MB)</label>
                    {{ Form::file('image', ['required']) }}
                    <small class="form-text text-muted">This image will be shown to users on the /apps page.</small>
                </div>

                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection