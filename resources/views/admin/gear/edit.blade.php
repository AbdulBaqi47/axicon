@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Gear - Edit</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Gear<span class="text-muted font-weight-light"> / Edit</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/gear') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Edit Category
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => ['GearController@update',$gearCategory->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Category Name</label>
                    {{ Form::text('name', $gearCategory->name, ['class' => 'form-control', 'required']) }}
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