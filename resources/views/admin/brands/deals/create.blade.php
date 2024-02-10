@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Brands - {{ $brand->name }} - Create</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-duallistbox/bootstrap-duallistbox.css') }}">

@endsection

@section('scripts')

    <script src="{{ asset('assets/vendor/libs/bootstrap-duallistbox/bootstrap-duallistbox.js') }}"></script>

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
        <div>Brands<span class="text-muted font-weight-light"> / {{ $brand->name }} / Create</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/brands/'.$brand->id) }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Create Deal
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => 'BrandDealController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Deal Title</label>
                    {{ Form::text('title', '', ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    {{ Form::textarea('description', '', ['class' => 'form-control', 'rows' => '3']) }}
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Budget</label>
                        {{ Form::text('price', '', ['class' => 'form-control', 'placeholder' => '5000']) }}
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Status</label>
                        {{ Form::select('status', ['Proposed' => 'Proposed', 'Negotiating' => 'Negotiating', 'In Progress' => 'In Progress', 'Complete' => 'Complete'], '', ['class' => 'custom-select', 'required']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label pb-2">Creators</label>
                    <select multiple="multiple" size="8" name="creators[]" id="creators-select">
                        @foreach ($unassignedCreatorArray as $uCreator)
                            <option value="{{ $uCreator->id }}">{{ $uCreator->name }}</option>
                        @endforeach
                    </select>
                </div>                

                {{ Form::hidden('brand_id', $brand->id) }}

                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection