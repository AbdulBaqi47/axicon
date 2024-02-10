@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Brands - Create</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Brands<span class="text-muted font-weight-light"> / Create</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/brands') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Create Brand
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => 'BrandController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Brand Name</label>
                        {{ Form::text('name', '', ['class' => 'form-control', 'required']) }}
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Brand Website</label>
                        {{ Form::text('website', '', ['class' => 'form-control']) }}
                    </div>  
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label">Contact Email</label>
                        {{ Form::text('email', '', ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Phone Number</label>
                        {{ Form::text('phone', '', ['class' => 'form-control']) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Brand Representative</label>
                    <select class="custom-select" name="representative_id" id="representative_id" required>
                        @foreach ($userList as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} #{{ $user->id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    {{ Form::textarea('notes', '', ['class' => 'form-control', 'rows' => '3']) }}
                </div>

                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection