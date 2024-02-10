@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Admin - Requests</title>

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

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Requests</div>
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/requests/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Create Request</button>
    </h4>

    @include('includes.messages')

    <div class="card">

        <div class="table-responsive mb-4">
            <table class="table card-table table-hover mb-0">

                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Type</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($channelrequests as $channelrequest)
                <tr>
                    <th scope="row">{{ $channelrequest->id }}</th>
                    <td><a href="/users/{{ $channelrequest->user_id }}">{{ $channelrequest->user_id }}</a></td>
                    <td><a href="/requests/{{ $channelrequest->id }}">{{ $channelrequest->type }}</a></td>
                    <td>{{ str_limit($channelrequest->extra_details, 100) }}</td>
                    @if ($channelrequest->status == "1")
                        <td><span class="text-small font-weight-bolder line-height-1 my-2 badge badge-outline-success"> Complete</span></td>
                        @else
                        <td><span class="text-small font-weight-bolder line-height-1 my-2 badge badge-outline-primary"> Ongoing</span></td>
                        @endif
                    <td>{{ $channelrequest->created_at->diffForHumans() }}</td>
                    <td>
                        {!! Form::open(['action' => ['ChannelRequestController@destroy', $channelrequest->id], 'method' => 'POST']) !!}
                        <button type="button" class="btn btn-sm btn-success md-btn-flat" onclick="location.href='{{ url('/admin/requests/edit/'.$channelrequest->id) }}'">Update</button>
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
                {{ $channelrequests->links() }}
            </ul>
        </nav>

    </div>

@endsection