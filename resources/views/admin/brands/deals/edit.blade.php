@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Brands - {{ $brand->name }} - Edit</title>

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
        $('#creators-select').bootstrapDualListbox({
            nonSelectedListLabel: 'Not Assigned',
            selectedListLabel: 'Assigned',
            preserveSelectionOnMove: 'false'
        });
    </script>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Brands<span class="text-muted font-weight-light"> / {{ $brand->name }} / Edit</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/brands/'.$brand->id) }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Edit Deal
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => ['BrandDealController@update', $brandDeal->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Deal Title</label>
                    {{ Form::text('title', $brandDeal->title, ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    {{ Form::textarea('description', $brandDeal->description, ['class' => 'form-control', 'rows' => '3']) }}
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Status</label>
                        {{ Form::select('status', ['Proposed' => 'Proposed', 'Negotiating' => 'Negotiating', 'In Progress' => 'In Progress', 'Complete' => 'Complete'], $brandDeal->status, ['class' => 'custom-select', 'required']) }}
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Budget</label>
                        {{ Form::text('price', $brandDeal->price, ['class' => 'form-control', 'placeholder' => '5000']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label pb-2">Creators</label>
                    <select multiple="multiple" size="8" name="creators[]" id="creators-select">
                        @foreach ($unassignedCreatorArray as $uCreator)
                            <option value="{{ $uCreator->id }}">{{ $uCreator->name }}</option>
                        @endforeach
                        @foreach ($creatorArray as $creator)
                            <option value="{{ $creator->id }}" selected="selected">{{ $creator->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{ Form::hidden('brand_id', $brand->id) }}

                {{ Form::hidden('_method', 'PUT') }}

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection