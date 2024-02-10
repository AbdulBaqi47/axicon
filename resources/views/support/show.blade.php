@extends('layouts.layout-2')


@section('styles')

    <title>Axiquo | Support - {{ $ticket->title }}</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">

@endsection

@section('scripts')
    <!-- Dependencies -->
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    
    <script src="{{ asset('assets/js/misc_perfect-scrollbar.js') }}"></script>

    <script src="https://cdn.ckeditor.com/4.10.1/standard-all/ckeditor.js"></script>
    <script>
		CKEDITOR.replace( 'article-ckeditor', {
			extraPlugins: 'embed,autoembed,image2',
			height: 250,

			// Load the default contents.css file plus customizations for this sample.
			contentsCss: [ CKEDITOR.basePath + 'contents.css', 'https://sdk.ckeditor.com/samples/assets/css/widgetstyles.css' ],
			// Setup content provider. See https://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_media_embed
			embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',

			// Configure the Enhanced Image plugin to use classes instead of styles and to disable the
			// resizer (because image size is controlled by widget styles or the image takes maximum
			// 100% of the editor width).
			image2_alignClasses: [ 'image-align-left', 'image-align-center', 'image-align-right' ],
			image2_disableResizer: true
		} );
	</script>
    
@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Support<span class="text-muted font-weight-light"> / {{ $ticket->title }}</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/support') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    @include('includes.messages')

    <div class="row">
        
        <div class="col-md-4 col-xl-3"> 
            <!-- Ticket details -->
            <div class="card mb-4">
                <h6 class="card-header">Ticket details</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">User ID</div>
                        <div><a href="/admin/users/{{ $ticket->user_id }}">{{ $ticket->user_id }}</a></div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Created</div>
                        <div>{{ $ticket->created_at->diffForHumans() }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Last update</div>
                        <div>{{ $ticket->updated_at->diffForHumans() }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Priority</div>
                        @switch($ticket->priority)
                            @case("Low")
                                <div><span class="badge badge-outline-success">Low</span></div>
                                @break

                            @case("Medium")
                                <div><span class="badge badge-outline-warning">Medium</span></div>
                                @break

                            @case("High")
                                <div><span class="badge badge-outline-danger">High</span></div>
                                @break
                        @endswitch
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center pb-3">
                        <div class="text-muted">Status</div>
                        @switch($ticket->status)
                            @case("Opened")
                                <div><span class="badge badge-outline-default">Opened</span></div>
                                @break

                            @case("Update")
                                <div><span class="badge badge-outline-info">Update</span></div>
                                @break

                            @case("Closed")
                                <div><span class="badge badge-outline-success">Closed</span></div>
                                @break
                        @endswitch
                    </li>
                </ul>
            </div>
            <!-- / Request details -->

        </div>

        <div class="col">

            <!-- Description -->
            <div class="card mb-4">
                <h6 class="card-header">Ticket Message</h6>
                <div class="card-body">
                    <div id="perfect-scrollbar-example-1" style="height: 165px;">
                        {!! htmlspecialchars_decode($ticket->message) !!}
                    </div>
                </div>
            </div>
            <!-- / Description -->

        </div>
        
    </div>

    <div class="row">

        <hr class="pt-2 pb-2">

        <div class="col-md-12">

            @include('support.comments.comments', ['ticket' => $ticket, 'user' => $user, 'comments' => $comments])

            <!-- New Comment -->
            <div class="bg-white ui-bordered mb-2">
                <a href="#new-comment" class="d-flex justify-content-between text-dark py-3 px-4" data-toggle="collapse" aria-expanded="true"> 
                    <div><i class="ion ion-md-brush mr-1"></i> <b>Create New Comment</b></div>
                    <span class="collapse-icon d-inline-block ml-1"></span>
                </a>
                <div id="new-comment" class="collapse" style="">
                    <div class="mb-2">
                        <div class="card-body">
                            {!! Form::open(['action' => 'CommentController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                                <div class="form-group">
                                    <label class="form-label pb-1">Comment</label>
                                    {{ Form::textarea('comment', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'rows' => '3', 'required']) }}
                                    <small class="form-text text-muted">Your comment will be posted to this ticket immediately.</small>
                                </div>

                                {{ Form::hidden('ticket_id', $ticket->id) }}
                                {{ Form::hidden('user_id', Auth::user()->id) }}

                                {{ Form::button('<i class="ion ion-md-create"></i>&nbsp; Post Comment', ['type' => 'submit', 'class' => 'btn btn-primary'] )  }}

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- / New Comment -->

        </div>

    </div>

@endsection