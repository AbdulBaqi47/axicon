@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Support - Create</title>

@endsection

@section('scripts')
    <!-- Dependencies -->
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
        <div>Support<span class="text-muted font-weight-light"> / Create</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/support') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Create Ticket
        </h6>
        <div class="card-body">
            {!! Form::open(['action' => 'TicketController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <div class="form-group">
                    <label class="form-label">Title</label>
                    {{ Form::text('title', '', ['class' => 'form-control', 'required']) }}
                </div>

                <div class="form-group">
                    <label class="form-label pb-1">Message</label>
                    {{ Form::textarea('message', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'rows' => '3', 'required']) }}
                    <small class="form-text text-muted">Outline your support request so our team can help you.</small>
                </div>
            
                <div class="form-group">
                    <label class="form-label">Priority</label>
                    {{ Form::select('priority', ['Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'], null, ['class' => 'custom-select', 'placeholder' => 'Select ticket priority...', 'required']) }}
                </div>

                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection