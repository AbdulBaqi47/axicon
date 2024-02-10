@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Admin - Sponsorships</title>

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
        <div>Sponsorships</div>
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/sponsorships/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Create Sponsorship</button>
    </h4>

    @include('includes.messages')

    <div class="card">

        <div class="table-responsive mb-4">
            <table class="table card-table table-hover mb-0">

                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Link</th>
                    <th>Powered By</th>
                    <th>Criteria</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($sponsorships as $sponsorship)
                <tr>
                    <th scope="row">{{ $sponsorship->id }}</th>
                    <td>{{ $sponsorship->title }}</td>
                    <td>{{ str_limit($sponsorship->description, 55) }}</td>
                    <td><a target="_blank" href="{{ $sponsorship->link }}">{{ $sponsorship->link }}</a></td>
                    <td>{{ $sponsorship->added_by }}</td>
                    <td>{{ str_limit($sponsorship->requirements, 25) }}</td>
                    <td>
                        {!! Form::open(['action' => ['SponsorshipController@destroy', $sponsorship->id], 'method' => 'POST']) !!}
                        <button type="button" class="btn btn-sm btn-info md-btn-flat" onclick="location.href='{{ url('/admin/sponsorships/edit/'.$sponsorship->id) }}'">Edit</button>
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
                {{ $sponsorships->links() }}
            </ul>
        </nav>

    </div>

@endsection