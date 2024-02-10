@extends('layouts.layout-2')


@section('styles')

    <title>Axiquo | Support</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Support</div>
        @hasanyrole('admin|partner-manager|support')
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/support') }}'">
        <span class="ion ion-md-code"></span>&nbsp; Support Admin</button>
        @else
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/support/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Create Ticket</button>
        @endhasanyrole
    </h4>

    @include('includes.messages')

    @foreach ($tickets as $ticket)
        <div class="card mb-3">
            <div class="card-body">
                <div class="media align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        @switch($ticket->status)
                        @case("Opened")
                            <div class="mt-3 mb-3"><span class="badge badge-outline-default">Opened</span></div>
                            @break

                        @case("Update")
                            <div class="mt-3 mb-3"><span class="badge badge-outline-info">Update</span></div>
                            @break

                        @case("Closed")
                            <div class="mt-3 mb-3"><span class="badge badge-outline-success">Closed</span></div>
                            @break
                        @endswitch

                        <!--<button type="button" class="btn btn-md btn-info md-btn-flat" onclick="location.href='{{ url('/support/edit/'.$ticket->id) }}'">Edit</button>-->
                    </div>
                    <div class="media-body ml-4">
                        <a href="{{ url("/support/$ticket->id") }}" class="text-big">{{ $ticket->title }}</a>
                        <div class="small my-2">
                            @switch($ticket->priority)
                            @case("Low")
                            <div class="text-muted pb-1"><i class="ion ion-md-notifications-outline text-success text-big align-middle"></i>&nbsp; Priority: Low</div>
                                @break
    
                            @case("Medium")
                            <div class="text-muted pb-1"><i class="ion ion-md-notifications-outline text-warning text-big align-middle"></i>&nbsp; Priority: Medium</div>
                                @break
    
                            @case("High")
                            <div class="text-muted pb-1"><i class="ion ion-md-notifications-outline text-danger text-big align-middle"></i>&nbsp; Priority: High</div>
                                @break
                            @endswitch
                            <div class="text-muted pb-1"><i class="ion ion-md-calendar text-lighter text-big align-middle"></i>&nbsp; Created: {{ $ticket->created_at->diffForHumans() }}</div>
                            <div class="text-muted"><i class="ion ion-md-time text-lighter text-big align-middle"></i>&nbsp; Updated: {{ $ticket->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <hr class="border-light mt-4 mb-4">

    <nav>
        <ul class="pagination justify-content-center">
            {{ $tickets->links() }}
        </ul>
    </nav>

@endsection