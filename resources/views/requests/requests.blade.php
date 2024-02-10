@extends('layouts.layout-2')


@section('styles')

    <title>Axiquo | Requests</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Requests</div>
        @hasanyrole('admin|partner-manager')
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/requests') }}'">
        <span class="ion ion-md-code"></span>&nbsp; Requests Admin</button>
        @else
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/requests/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Create Request</button>
        @endhasanyrole
    </h4>

    @include('includes.messages')

    @foreach ($channelrequests as $channelrequest)
        <div class="card mb-3">
            <div class="card-body">
                <div class="media align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        @if ($channelrequest->status == "1")
                            <div class="text-small font-weight-bolder line-height-1 my-2 badge badge-outline-success"> Complete</div>
                        @else
                            <div class="text-small font-weight-bolder line-height-1 my-2 badge badge-outline-primary"> Ongoing</div>
                        @endif

                        <!--<button type="button" class="btn btn-md btn-info md-btn-flat" onclick="location.href='{{ url('/requests/edit/'.$channelrequest->id) }}'">Edit</button>-->
                    </div>
                    <div class="media-body ml-4">
                        <a href="{{ url("/requests/$channelrequest->id") }}" class="text-big">{{ $channelrequest->type }}</a>
                        <div class="my-2">
                            {{ str_limit($channelrequest->extra_details, 140) }}
                        </div>
                        <div class="small">
                            <div class="text-muted pb-1"><i class="ion ion-md-calendar text-lighter text-big align-middle"></i>&nbsp; Created: {{ $channelrequest->created_at->diffForHumans() }}</div>
                            <div class="text-muted"><i class="ion ion-md-time text-lighter text-big align-middle"></i>&nbsp; Updated: {{ $channelrequest->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <hr class="border-light mt-4 mb-4">

    <nav>
        <ul class="pagination justify-content-center">
            {{ $channelrequests->links() }}
        </ul>
    </nav>

@endsection