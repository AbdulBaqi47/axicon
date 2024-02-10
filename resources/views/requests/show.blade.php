@extends('layouts.layout-2')


@section('styles')

    <title>Axiquo | Requests</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Requests</div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/requests') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    @include('includes.messages')

    <div class="row">
        
        <div class="col-md-4 col-xl-3">

            <!-- Request details -->
            <div class="card mb-4">
                <h6 class="card-header">Project details</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">User ID</div>
                        <div><a href="/admin/users/{{ $channelrequest->user_id }}">{{ $channelrequest->user_id }}</a></div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Type</div>
                        <div><strong>{{ $channelrequest->type }}</strong></div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Email</div>
                        <div>{{ $channelrequest->contact_details }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Created</div>
                        <div>{{ $channelrequest->created_at->diffForHumans() }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Last update</div>
                        <div>{{ $channelrequest->updated_at->diffForHumans() }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Status</div>
                        @if ($channelrequest->status == "1")
                            <div class="text-small font-weight-bolder line-height-1 my-2 badge badge-outline-success"> Complete</div>
                        @else
                            <div class="text-small font-weight-bolder line-height-1 my-2 badge badge-outline-primary"> Ongoing</div>
                        @endif
                    </li>
                </ul>
            </div>
            <!-- / Request details -->

        </div>

        <div class="col">

            <!-- Description -->
            <div class="card mb-4">
                <h6 class="card-header">Request Description</h6>
                <div class="card-body">
                    <textarea rows="3" class="form-control" readonly>{{ $channelrequest->extra_details }}</textarea>
                </div>
            </div>
            <!-- / Description -->

            @if ($channelrequest->request_link != null)
                <div class="card bg-success text-white mb-4">
                    <h6 class="card-header">Request Link</h6>
                    <div class="card-body">
                        <p class="pb-2"><em>Your request has been fulfilled, please see the link for more:</em></p>
                        <a class="text-white" href="{{ $channelrequest->request_link }}">{{ $channelrequest->request_link }}</a>
                    </div>
                </div>
            @endif

        </div>
        
    </div>

@endsection