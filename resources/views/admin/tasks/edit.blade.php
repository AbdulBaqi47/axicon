@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Tasks - {{ $task->name }} - Edit</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-duallistbox/bootstrap-duallistbox.css') }}">

@endsection

@section('scripts')

    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-duallistbox/bootstrap-duallistbox.js') }}"></script>

    <script>
        // Datepicker
        $(function() {
            $('#datepicker').datepicker({
                calendarWeeks:         true,
                clearBtn:              true,
                todayHighlight:        true,
                format:                'yyyy-mm-dd',
                orientation:           'left',
            });
        });
    </script>

    <script>
        $('#staff-select').bootstrapDualListbox({
            nonSelectedListLabel: 'Not Assigned',
            selectedListLabel: 'Assigned',
            preserveSelectionOnMove: 'false'
        });

        $('#creators-select').bootstrapDualListbox({
            nonSelectedListLabel: 'Not Assigned',
            selectedListLabel: 'Assigned',
            preserveSelectionOnMove: 'false'
        });
    </script>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Tasks <span class="text-muted font-weight-light"> / Edit</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/tasks/'.$task->id) }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Update Task
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => ['TaskController@update',$task->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Task Name</label>
                    {{ Form::text('name', $task->name, ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Task Description</label>
                    {{ Form::textarea('description', $task->description, ['class' => 'form-control', 'rows' => '3', 'required']) }}
                    <small class="form-text text-muted">What does the task involve? What detail can you provide to team members about the task?</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Importance</label>
                        {{ Form::select('importance', ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'], $task->importance, ['class' => 'custom-select', 'placeholder' => 'Select importance...', 'required']) }}
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Due Date</label>
                        {{ Form::text('due_date', date_format(new DateTime($task->due_date), 'Y-m-d'), ['class' => 'form-control', 'id' => 'datepicker']) }}
                    </div>
                </div>

                <div class="pt-2 pb-2">
                    <hr>
                </div>

                <div class="form-group">
                    <label class="form-label pb-2">Task Staff</label>
                    <select multiple="multiple" size="8" name="staff[]" id="staff-select">
                        @foreach ($unassignedStaffArray as $uStaff)
                            <option value="{{ $uStaff->id }}">{{ $uStaff->name }}</option>
                        @endforeach
                        @foreach ($staffArray as $staff)
                            <option value="{{ $staff->id }}" selected="selected">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label pb-2">Task Creators</label>
                    <select multiple="multiple" size="8" name="creators[]" id="creators-select">
                        @foreach ($unassignedCreatorArray as $uCreator)
                            <option value="{{ $uCreator->id }}">{{ $uCreator->name }}</option>
                        @endforeach
                        @foreach ($creatorArray as $creator)
                            <option value="{{ $creator->id }}" selected="selected">{{ $creator->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{ Form::hidden('_method', 'PUT') }}

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection