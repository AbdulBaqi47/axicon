@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Gear - {{ $gearItem->title }} - Edit</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Gear<span class="text-muted font-weight-light"> - {{ $gearItem->title }} / Edit</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/gear/'.$gearCategory->slug) }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Edit Item
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => ['ItemController@update', $gearItem->id],'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Item Title</label>
                    {{ Form::text('title', $gearItem->title, ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Item Description</label>
                    {{ Form::textarea('description', $gearItem->description, ['class' => 'form-control', 'rows' => '3', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Amazon Link</label>
                    {{ Form::text('link', $gearItem->link, ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Category ID</label>
                    {{ Form::text('category_id', $gearCategory->id, ['class' => 'form-control', 'required', 'readonly']) }}
                </div>

                <div class="form-group pb-1">
                    <label class="form-label w-100 pb-2">Category Image (Max 2MB)</label>
                    {{ Form::file('image') }}
                    <small class="form-text text-muted">This image will be shown to users on the /gear page.</small>
                </div>

                {{ Form::hidden('_method', 'PUT') }}

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection