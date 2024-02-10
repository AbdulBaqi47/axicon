@extends('layouts.layout-2')


@section('styles')

    <title>Axiquo | Education - Edit</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
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
        <div>Education<span class="text-muted font-weight-light"> / Edit</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/education') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="card">
        <div class="card-body media align-items-center">
            <div class="media-body">
                <strong>Edit Article</strong>
            </div>
        </div>
        <hr class="m-0">
        {!! Form::open(['action' => ['EducationController@update',$education->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="card-body pb-4">

            <div class="form-group">
                <label class="form-label">Title</label>
                {{ Form::text('title', $education->title, ['class' => 'form-control', 'required']) }}
            </div>

            <div class="form-group">
                <label class="form-label">Author</label>
                {{ Form::text('added_by', $education->added_by, ['class' => 'form-control', 'required']) }}
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                {{ Form::select('published', ['1' => 'Published', '0' => 'Draft'], $education->published, ['class' => 'custom-select']) }}
            </div>

            <div class="form-group">
                <label class="form-label">Content</label>
                  {{ Form::textarea('content', $education->content, ['id' => 'article-ckeditor', 'class' => 'form-control']) }}
            </div>

            <div class="form-group pb-1">
                <label class="form-label w-100 pb-2">Post Image (Max 2MB)</label>
                {{ Form::file('image') }}
                <small class="form-text text-muted">This image will be shown to users on the post's page.</small>
            </div>

            {{ Form::hidden('_method', 'PUT') }}

            {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}

        </div>

    </div>

    {!! Form::close() !!}

@endsection