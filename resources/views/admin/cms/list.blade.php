<?php use Illuminate\Support\Facades\DB; ?>

@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Admin - Dailymotion CMS</title>

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
        <div>Dailymotion CMS</div>
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('https://www.dailymotion.com/partner/x1lvw98/channel/network') }}'">
        <span class="ion ion-md-link"></span>&nbsp; Visit CMS</button>
    </h4>

    @include('includes.messages')

    <div class="nav-responsive-lg">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#cms-link">CMS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#invite-link">Invite Channel(s)</a>
            </li>
        </ul>
    </div>

    <div class="tab-content mt-2">
        <div class="tab-pane fade show active" id="cms-link">
            <div class="card">

                <div class="table-responsive mb-4">
                    <table class="table card-table table-hover mb-0">

                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Channel ID</th>
                            <th>Channel URL</th>
                            <th>Updated</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($channels as $channel)
                        <tr>
                            <th scope="row">{{ $channel->id }}</th>
                            <td><a href="https://dailymotion.com/{{ $channel->channel_url }}">{{ $channel->channel_id }}</td>
                            <td>{{ $channel->channel_url }}</td>

                            <td>{{ $channel->updated_at }}</td>
                        </tr>
                        @endforeach
                        
                        </tbody>

                    </table>

                </div>

                <hr class="border-light mt-2 mb-4">

                <nav>
                    <ul class="pagination justify-content-center">
                        {{ $channels->links() }}
                    </ul>
                </nav>

            </div>
        </div>

        <div class="tab-pane fade" id="invite-link">
            <div class="card">

                <div class="table-responsive mb-4">
                    <table class="table card-table table-hover mb-0">

                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Channel Owner</th>
                            <th>Channel ID</th>
                            <th>Channel URL</th>
                            <th>Subscribers</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($dmusers as $dmuser)
                        <tr>
                            <th scope="row">{{ $dmuser->id }}</th>
                            <td>{{ $dmuser->user->name }}</td>
                            <td><a href="https://dailymotion.com/{{ $dmuser->channel_url }}">{{ $dmuser->channel_id }}</td>
                            <td>{{ $dmuser->channel_url }}</td>
                            <td>{{ $dmuser->subscriber_count }}</td>
                            <td>{{ $dmuser->view_count }}</td>
                            
                            @if (DB::table('cms')->where('channel_id', $dmuser->channel_id)->exists())
                                <td><span class="badge badge-outline-success">In CMS</span></td>
                            @else
                                <td><span class="badge badge-outline-danger">Not In CMS</span></td>
                            @endif

                            @if (DB::table('cms')->where('channel_id', $dmuser->channel_id)->exists())
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger md-btn-flat" onclick="location.href='{{ url('/admin/cms/invite/'.$dmuser->id) }}'">Remove</button>
                                </td>
                            @else
                                <td>
                                    <button type="button" class="btn btn-sm btn-info md-btn-flat" onclick="location.href='{{ url('/admin/cms/invite/'.$dmuser->id) }}'">Invite</button>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                        
                        </tbody>

                    </table>

                </div>

                <hr class="border-light mt-2 mb-4">

                <nav>
                    <ul class="pagination justify-content-center">
                        {{ $dmusers->links() }}
                    </ul>
                </nav>

            </div>
        </div>

    </div>

@endsection