@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Downloads - Edit</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Downloads<span class="text-muted font-weight-light"> / Edit</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/downloads') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Edit Download
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => ['DownloadController@update', $download->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Download Title</label>
                    {{ Form::text('title', $download->title, ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    {{ Form::textarea('description', $download->description, ['class' => 'form-control', 'rows' => '3']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Access Level</label>
                    {{ Form::select('access', ['admin' => 'Admin Only', 'all' => 'All Users'], $download->access, ['class' => 'custom-select']) }}
                </div>

                <div class="form-group pb-1">
                    <label class="form-label w-100 pb-2">File Upload (Max 2MB)</label>
                    {{ Form::file('file') }}
                    <small class="form-text text-muted">This is the file that users will be able to download.</small>
                </div>

                {{ Form::hidden('_method', 'PUT') }}

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection