@extends('layouts.layout-2')


@section('styles')
    
    <title>Axiquo | Gear</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Gear</div>
        @role('admin')
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/gear') }}'">
        <span class="ion ion-md-code"></span>&nbsp; Gear Admin</button>
        @endrole
    </h4>

    @include('includes.messages')

    <div class="row">

        @if (count($gearCategories) > 0)

        @foreach ($gearCategories as $gearCategory)
            <div class="col-sm-6 col-xl-4">
                <div class="card mb-4">
                    <div class="w-100">
                        <a href="{{ url("/gear/$gearCategory->slug") }}" class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url('{{ asset("storage/photos/gear/$gearCategory->image_url") }}')"></a>
                    </div>

                    <div class="card-body">
                        <h5 class="mb-1"><a href="{{ url("/gear/$gearCategory->slug") }}" class="text-dark">{{ $gearCategory->name }}</a></h5>
                        {{--<div class="media">
                            <div class="text-muted small pt-1">
                                <i class="ion ion-md-alarm text-primary"></i>
                                <span class="pl-1">Updated: {{ date_format($gearCategory->updated_at,"d F Y") }}</span>
                            </div>
                        </div>--}}
                    </div>
                </div>
            </div>
        @endforeach

        @else

            <p>No Categories Found.</p>

        @endif

    </div>

    <hr class="border-light mt-2 mb-4">

    <nav>
        <ul class="pagination justify-content-center">
            {{ $gearCategories->links() }}
        </ul>
    </nav>

@endsection