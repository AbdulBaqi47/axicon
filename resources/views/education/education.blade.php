@extends('layouts.layout-2')


@section('styles')

    <title>Axiquo | Education</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Education</div>
        @hasanyrole('admin|partner-manager')
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/education') }}'">
        <span class="ion ion-md-code"></span>&nbsp; Education Admin</button>
        @endhasanyrole
    </h4>

    @include('includes.messages')
    
    <div class="row">

        @if (count($educations) > 0)

        @foreach ($educations as $education)
            <div class="col-sm-6 col-xl-4">
                <div class="card mb-4">
                    <div class="w-100">
                        <a href="{{ url("/education/$education->slug") }}" class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url('{{ asset("storage/photos/education/$education->image_url") }}')"></a>
                    </div>

                    <div class="card-body">
                        <h5 class="mb-3"><a href="{{ url("/education/$education->slug") }}" class="text-dark">{{ $education->title }}</a></h5>
                        <div class="media">
                            <div class="text-muted small">
                                <i class="ion ion-md-people text-primary"></i>
                                <span class="pl-1">Author: {{ str_limit($education->added_by, 55) }}</span>
                            </div>
                            <br>
                        </div>
                        <div class="media">
                            <div class="text-muted small pt-1">
                                <i class="ion ion-md-alarm text-primary"></i>
                                <span class="pl-1">Updated: {{ date_format($education->updated_at,"d F Y") }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @else

            <p>No Posts Found.</p>

        @endif

    </div>

    <hr class="border-light mt-2 mb-4">

    <nav>
        <ul class="pagination justify-content-center">
            {{ $educations->links() }}
        </ul>
    </nav>

@endsection