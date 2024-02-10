@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Brands - {{ $brand->name }}</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-table/bootstrap-table.css') }}">

@endsection

@section('scripts')

    <!-- Dependencies -->
    <script src="{{ asset('assets/vendor/libs/tableexport/tableexport.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    
    <script src="{{ asset('assets/vendor/libs/bootstrap-table/bootstrap-table.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-table/extensions/export/export.js') }}"></script>
    
    <script src="{{ asset('assets/js/tables_bootstrap-table.js') }}"></script>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div><a href="/admin/brands" style="text-decoration: none; color: #4E5155;">Brands</a><span class="text-muted font-weight-light"> / {{ $brand->name }}</span></div>
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/brands/'. $brand->id .'/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Create Deal</button>
    </h4>

    @include('includes.messages')

    <div class="row">
        
        <div class="col-md-4 col-xl-3">

            <!-- Request details -->
            <div class="card mb-4">
                <h6 class="card-header">Brand Details</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">ID</div>
                        <div>{{ $brand->id }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Name</div>
                        <div><strong>{{ $brand->name }}</strong></div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Rep.</div>
                        <div>{{ $brand->representative->name }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Email</div>
                        <div>{{ $brand->email }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Phone</div>
                        <div>{{ $brand->phone }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Web</div>
                        <div><a href="{{ $brand->website }}">{{ $brand->website }}</a></div>
                    </li>
                </ul>
            </div>
            <!-- / Brand details -->

        </div>

        <div class="col">

            <!-- Request details -->
            <div class="card mb-4">
                <h6 class="card-header">Brand Notes</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <textarea class="form-control pt-1 mb-2" rows="11" readonly>{{ $brand->notes }}</textarea>
                    </li>
                </ul>
            </div>
            <!-- / Brand details -->

        </div>
        
    </div>

    <hr class="pt-2 pb-2">

    <div class="col">

        <div class="card">

            @foreach ($brandDeals as $brandDeal)
                
                <div class="pt-2 pb-2 p-md-5">
                    <h3 class="text-dark text-large font-weight-semibold">{{ $brandDeal->title }}</h3>
                    <div class="d-flex flex-wrap mt-3">
                        @if (null !== $brandDeal->creators)
                            <?php $creators = explode(',', $brandDeal->creators); ?>
                            <div class="mr-3"><i class="vacancy-tooltip ion ion-md-contacts text-light" title="Creators"></i>&nbsp; Creators: {{ count($creators) }}</div>
                        @else
                            <div class="mr-3"><i class="vacancy-tooltip ion ion-md-contacts text-light" title="Creators"></i>&nbsp; Creators: 0</div>
                        @endif

                        @if (null !== $brandDeal->price)
                            <div class="mr-3"><i class="vacancy-tooltip ion ion-md-time text-primary" title="Budget"></i>&nbsp; Budget: £{{ number_format($brandDeal->price) }}</div>
                        @else
                            <div class="mr-3"><i class="vacancy-tooltip ion ion-md-time text-primary" title="Budget"></i>&nbsp; Budget: Not Set</div>
                        @endif
                    </div>
                    @if ($brandDeal->approved == 1)
                        <div class="mt-3 mb-3"><span class="badge badge-outline-success">BRAND APPROVED</span></div>
                    @else
                        @switch($brandDeal->status)
                            @case("Proposed")
                                <div class="mt-3 mb-3"><span class="badge badge-outline-default">Proposed</span></div>
                                @break

                            @case("Negotiating")
                                <div class="mt-3 mb-3"><span class="badge badge-outline-primary">Negotiating</span></div>
                                @break

                            @case("In Progress")
                                <div class="mt-3 mb-3"><span class="badge badge-outline-info">In Progress</span></div>
                                @break

                            @case("Complete")
                                <div class="mt-3 mb-3"><span class="badge badge-outline-success">Complete</span></div>
                                @break
                        @endswitch
                    @endif

                    <div class="mt-2 mb-3">
                        <textarea class="form-control" rows="3" readonly>{{ $brandDeal->description }}</textarea>
                    </div>
                    {!! Form::open(['action' => ['BrandDealController@destroy', $brandDeal->id], 'method' => 'POST']) !!}
                    <a class="btn btn-sm btn-primary md-btn-flat" href="/admin/brands/{{ $brandDeal->brand_id }}/{{ $brandDeal->id }}/submissions">View</a>
                    <a class="btn btn-sm btn-info md-btn-flat" href="/admin/brands/{{ $brandDeal->brand_id }}/edit/{{ $brandDeal->id }}">Edit</a>
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::Submit('Delete', ['class' => 'btn btn-sm btn-danger md-btn-flat'])}}
                    {!! Form::close() !!}
                </div>

            @endforeach

        </div>

        <hr class="border-light mt-2 mb-4">

        <nav>
            <ul class="pagination justify-content-center">
                {{ $brandDeals->links() }}
            </ul>
        </nav>

    </div>

@endsection