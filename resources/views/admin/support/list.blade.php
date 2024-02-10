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
        <div>Support Tickets</div>
        <!--<button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/support/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Create Ticket</button>-->
    </h4>

    @include('includes.messages')

    <div class="card">

        <div class="table-responsive mb-4">
            <table class="table card-table table-hover mb-0">

                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>User ID</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($tickets as $ticket)
                <tr>
                    <th scope="row">{{ $ticket->id }}</th>
                    <td><a href="/support/{{ $ticket->id }}">{{ str_limit($ticket->title, 35) }}</a></td>
                    <td>{{ str_limit($ticket->message, 80) }}</td>
                    <td>{{ $ticket->user_id }}</td>
                    @switch($ticket->priority)
                    @case("Low")
                        <td><span class="badge badge-outline-success">Low</span></td>
                        @break

                    @case("Medium")
                        <td><span class="badge badge-outline-warning">Medium</span></td>
                        @break

                    @case("High")
                        <td><span class="badge badge-outline-danger">High</span></td>
                        @break
                    @endswitch

                    @switch($ticket->status)
                    @case("Opened")
                        <td><span class="badge badge-outline-default">Opened</span></td>
                        @break

                    @case("Update")
                        <td><span class="badge badge-outline-info">Update</span></td>
                        @break

                    @case("Closed")
                        <td><span class="badge badge-outline-success">Closed</span></td>
                        @break
                    @endswitch
                    
                    <td>
                        {!! Form::open(['action' => ['TicketController@destroy', $ticket->id], 'method' => 'POST']) !!}
                        <button type="button" class="btn btn-sm btn-info md-btn-flat" onclick="location.href='{{ url('/admin/support/edit/'.$ticket->id) }}'">Edit</button>
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
                {{ $tickets->links() }}
            </ul>
        </nav>

    </div>

@endsection