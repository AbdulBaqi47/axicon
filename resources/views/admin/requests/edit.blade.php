@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Requests - Create</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Requests<span class="text-muted font-weight-light"> / Update</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/requests') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Update Request
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => ['ChannelRequestController@update',$channelrequest->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Request Type</label>
                    {{ Form::select('type', ['Channel Review' => 'Channel Review', 'Channel Graphics' => 'Channel Graphics'], $channelrequest->type, ['class' => 'custom-select', 'placeholder' => 'Select request type...', 'required', 'disabled']) }}
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">User ID</label>
                        {{ Form::text('user_id', $channelrequest->user_id, ['class' => 'form-control', 'required', 'disabled']) }}
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Contact Email</label>
                        {{ Form::text('contact_details', $channelrequest->contact_details, ['class' => 'form-control', 'required', 'disabled']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Request Details</label>
                    {{ Form::textarea('extra_details', $channelrequest->extra_details, ['class' => 'form-control', 'rows' => '3', 'required', 'disabled']) }}
                    <small class="form-text text-muted">Outline your request so our team know what you're looking for.</small>
                </div>

                <div class="pt-2 pb-2">
                    <hr>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                            <label class="form-label">Request Link</label>
                            {{ Form::text('request_link', $channelrequest->request_link, ['class' => 'form-control', 'required']) }}
                        <small class="form-text text-muted">Provide the link to the channel review report or a download link for graphics.</small>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Status</label>
                        {{ Form::select('status', ['1' => 'Complete', '0' => 'Ongoing'], $channelrequest->status, ['class' => 'custom-select', 'required']) }}
                    </div>
                </div>

                {{ Form::hidden('_method', 'PUT') }}

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection