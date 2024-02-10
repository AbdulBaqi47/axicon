@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Requests - Create</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Requests<span class="text-muted font-weight-light"> / Create</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/requests') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Create Request
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => 'ChannelRequestController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Request Type</label>
                    {{ Form::select('type', ['Channel Review' => 'Channel Review', 'Channel Graphics' => 'Channel Graphics'], null, ['class' => 'custom-select', 'placeholder' => 'Select request type...', 'required']) }}
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">User ID</label>
                        {{ Form::text('user_id', Auth::user()->id, ['class' => 'form-control', 'required', 'readonly']) }}
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Contact Email</label>
                        {{ Form::text('contact_details', Auth::user()->email, ['class' => 'form-control', 'required']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Request Details</label>
                    {{ Form::textarea('extra_details', '', ['class' => 'form-control', 'rows' => '3', 'required']) }}
                    <small class="form-text text-muted">Outline your request so our team know what you're looking for.</small>
                </div>

                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection