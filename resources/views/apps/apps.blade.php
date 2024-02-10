@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Apps</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Applications</div>
        @role('admin')
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/apps') }}'">
        <span class="ion ion-md-code"></span>&nbsp; App Admin</button>
        @endrole
    </h4>

    @include('includes.messages')
    
    <div class="row">

        @if (count($apps) > 0)

        @foreach ($apps as $app)
            <div class="col-sm-6 col-xl-4">
                <div class="card mb-4">
                    <div class="w-100">
                        <a href="{{ $app->link }}" class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url('{{ asset("storage/photos/apps/$app->image_url") }}')"></a>
                    </div>

                    <div class="card-body">
                        <h5 class="mb-3"><a href="{{ $app->link }}" class="text-dark">{{ $app->title }}</a></h5>
                        <p class="text-muted mb-3">{{ str_limit($app->description, 96) }}</p>
                        <div class="media">
                            <div class="text-muted small">
                                <i class="ion ion-md-done-all text-primary"></i>
                                <span class="pl-1">Powered By: {{ str_limit($app->added_by, 20) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @else

            <p>No Apps Found.</p>

        @endif

    </div>

    <hr class="border-light mt-2 mb-4">

    <nav>
        <ul class="pagination justify-content-center">
            {{ $apps->links() }}
        </ul>
    </nav>

@endsection