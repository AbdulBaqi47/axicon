@extends('layouts.layout-2')


@section('styles')
    
    <title>Axiquo | Gear - {{ $gearCategory->name }}</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-3">
        <div>Gear<span class="text-muted font-weight-light"> / {{ $gearCategory->name }}</span></div>
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/gear') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
    </h4>

    @include('includes.messages')

    <div class="row">

        @if (count($gearItems) > 0)

        @foreach ($gearItems as $gearItem)
        
        <div class="col-sm-6 col-xl-3 pb-4">
            <div class="card">
                <img class="card-img-top" src="{{ asset("storage/photos/gear/items/$gearItem->image_url") }}" alt="Card image cap">
                <div class="card-body" style="min-height: 11rem;">
                    <h4 class="card-title">{{ $gearItem->title }}</h4>
                    <p class="card-text">{{ str_limit($gearItem->description, 80) }}</p>
                    <a href="{{ $gearItem->link }}" class="btn btn-warning" target="_blank"><span class="fa fab fa-amazon"></span>&nbsp;&nbsp; Buy with Amazon</a>
                </div>
            </div>
        </div>

        @endforeach

        @else

            <p>No Items Found.</p>

        @endif

    </div>

    <hr class="border-light mt-2 mb-4">

    <nav>
        <ul class="pagination justify-content-center">
            {{ $gearItems->links() }}
        </ul>
    </nav>

    {{-- 
    @foreach ($gearCategories as $gearCategory)
    {{ $gearCategory->name }}
    @endforeach
    --}}

    {{--
    @foreach ($gearItems as $gearItem)
        {{ $gearItem->title }}
    @endforeach
    --}}

@endsection