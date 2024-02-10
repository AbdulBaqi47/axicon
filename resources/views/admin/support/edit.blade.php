@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Support - Edit</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Support<span class="text-muted font-weight-light"> / Edit</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/support') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Edit Ticket
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => ['TicketController@update', $ticket->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Title</label>
                    {{ Form::text('title', $ticket->title, ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Message</label>
                    {{ Form::textarea('message', $ticket->message, ['class' => 'form-control', 'rows' => '3', 'required']) }}
                    <small class="form-text text-muted">Outline your support request so our team can help you.</small>
                </div>
            
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Priority</label>
                        {{ Form::select('priority', ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'], $ticket->priority, ['class' => 'custom-select', 'required']) }}
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Status</label>
                        {{ Form::select('status', ['Opened' => 'Opened', 'Closed' => 'Closed'], $ticket->priority, ['class' => 'custom-select', 'required']) }}
                    </div>
                </div>

                {{ Form::hidden('_method', 'PUT') }}

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection