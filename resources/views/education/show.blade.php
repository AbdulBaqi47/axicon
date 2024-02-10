@extends('layouts.layout-2')


@section('styles')

    <title>Axiquo | Education - {{ title_case($education->title) }}</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4"> 
        <div>Education</div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/education') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    <div class="row">

        <div class="col-xl-4">

            <!-- Side info -->
            <div class="card mb-4">
                <img class="card-img-top" src="{{ asset("storage/photos/education/$education->image_url") }}" alt="Card image cap">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body pt-2">
                            <h4 class="mb-4">{{ $education->title }}</h4>
                        </div>
                    </div>
                    <div class="mt-1 mb-2">
                        <span class="text-muted">Author:</span>&nbsp;
                        {{ $education->added_by }}
                    </div>
                    <div>
                        <span class="text-muted">Last Updated:</span>&nbsp;
                        {{ date_format($education->updated_at,"d F Y") }}
                    </div>
                </div>
            </div>
            <!-- / Side info -->
        </div>

        <div class="col">
            <!-- Post -->
            <div class="card mb-4">
                <div class="card-body">
                    {!! $education->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection