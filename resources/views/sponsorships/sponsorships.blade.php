@extends('layouts.layout-2')


@section('styles')

    <!-- Title -->
    <title>Axiquo | Sponsorships</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Sponsorships</div>
        @role('admin')
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/sponsorships') }}'">
        <span class="ion ion-md-code"></span>&nbsp; Sponsorships Admin</button>
        @endrole
    </h4>

    @include('includes.messages')
    
    <div class="row">

        @if (count($sponsorships) > 0)

        @foreach ($sponsorships as $sponsorship)
            <div class="col-sm-6 col-xl-4">
                <div class="card mb-4">
                    <div class="w-100">
                        <a href="{{ $sponsorship->link }}" class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url('{{ asset("storage/photos/sponsorships/$sponsorship->image_url") }}')"></a>
                    </div>

                    <div class="card-body">
                        <h5 class="mb-3"><a href="{{ $sponsorship->link }}" class="text-dark">{{ $sponsorship->title }}</a></h5>
                        <p class="text-muted mb-3">{{ str_limit($sponsorship->description, 120) }}</p>
                        <div class="media">
                            <div class="text-muted small">
                                <i class="ion ion-md-done-all text-primary"></i>
                                <span class="pl-1">Powered By: {{ str_limit($sponsorship->added_by, 55) }}</span>
                            </div>
                            <br>
                        </div>
                        <div class="media">
                            <div class="text-muted small pt-1">
                                <i class="ion ion-md-clipboard text-primary"></i>
                                <span class="pl-2">Criteria: {{ str_limit($sponsorship->requirements, 55) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @else

            <p>No Sponsorships Found.</p>

        @endif

    </div>

    <hr class="border-light mt-2 mb-4">

    <nav>
        <ul class="pagination justify-content-center">
            {{ $sponsorships->links() }}
        </ul>
    </nav>

@endsection