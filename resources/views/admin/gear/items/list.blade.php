@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Admin - Gear</title>

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
        <div><a href="/admin/gear" style="text-decoration: none; color: #4E5155;">Gear</a><span class="text-muted font-weight-light"> / {{ $gearCategory->name }}</span></div>
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/gear/'.$gearCategory->slug.'/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Create Item</button>
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
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($gearItems as $gearItem)
                <tr>
                    <th scope="row">{{ $gearItem->id }}</th>
                    <td>{{ $gearItem->title }}</td>
                    <td>{{ str_limit($gearItem->description, 55) }}</td>
                    <td><a href="{{ $gearItem->link }}" target="_blank">{{ $gearItem->link }}</a></td>
                    <td>{{ date_format($gearItem->created_at, 'd/m/Y @ H:m') }}</td>
                    <td>{{ date_format($gearItem->updated_at, 'd/m/Y @ H:m') }}</td>
                    <td>
                        {!! Form::open(['action' => ['GearController@destroyItem', $gearCategory->slug, $gearItem->id], 'method' => 'POST']) !!}
                        <a class="btn btn-sm btn-info md-btn-flat" href='/admin/gear/{{ $gearCategory->slug }}/edit/{{ $gearItem->id }}'>Edit</a>
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
                {{ $gearItems->links() }}
            </ul>
        </nav>

    </div>

@endsection