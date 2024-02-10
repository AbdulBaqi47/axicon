@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Admin - Brands</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-table/bootstrap-table.css') }}">

@endsection

@section('scripts')

    <!-- Dependencies -->
    <script src="{{ asset('assets/vendor/libs/tableexport/tableexport.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    
    <script src="{{ asset('assets/vendor/libs/bootstrap-table/bootstrap-table.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-table/extensions/export/export.js') }}"></script>
    
    <script src="{{ asset('assets/js/tables_bootstrap-table.js') }}"></script>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Brands</div>
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/brands/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Create Brand</button>
    </h4>

    @include('includes.messages')

    <div class="card">

        <div class="table-responsive mb-4">
            <table class="table card-table table-hover mb-0">

                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Brand</th>
                    <th>Representative</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($brands as $brand)
                <tr>
                    <th scope="row">{{ $brand->id }}</th>
                    <td><a href="/admin/brands/{{ $brand->id }}">{{ $brand->name }}</td>
                    <td>{{ $brand->representative->name }}</td>
                    <td>{{ $brand->email }}</td>
                    <td>{{ $brand->phone }}</td>
                    <td><a target="_blank" href="{{ $brand->website }}">{{ $brand->website }}</a></td>
                    <td>
                        {!! Form::open(['action' => ['BrandController@destroy', $brand->id], 'method' => 'POST']) !!}
                        <button type="button" class="btn btn-sm btn-info md-btn-flat" onclick="location.href='{{ url('/admin/brands/edit/'.$brand->id) }}'">Edit</button>
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::Submit('Delete', ['class' => 'btn btn-sm btn-danger md-btn-flat'])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
                
                </tbody>

            </table>

        </div>

        <hr class="border-light mt-2 mb-4">

        <nav>
            <ul class="pagination justify-content-center">
                {{ $brands->links() }}
            </ul>
        </nav>

    </div>

@endsection