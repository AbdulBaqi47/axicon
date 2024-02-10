@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Tasks - {{ $task->name }}</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/projects.css') }}">

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Tasks <span class="text-muted font-weight-light">/ {{ $task->name }}</span></div>
        @hasanyrole('admin|partner-manager|support')
        <button type="button" class="btn btn-secondary btn-round d-block" onclick="location.href='{{ url('/admin/tasks') }}'">
        <span class="ion ion-md-undo"></span>&nbsp; Return</button>
        @endhasanyrole
    </h4>

    @include('includes.messages')

    <div class="row">
        <div class="col">

            <!-- Description -->
            <div class="card mb-4">
                <div class="card-body">
                    <p class="text-muted small">Task Description</p>
                    {!! $task->description !!}
                </div>
                <div class="card-footer py-3">
                    @if ($task->completed != '1')
                        <button type="button" class="btn btn-success" onclick="location.href='{{ url('/admin/tasks/'.$task->id.'/complete') }}'"><i class="ion ion-md-checkmark"></i>&nbsp; Mark As Complete</button>&emsp;
                    @else
                        <button type="button" class="btn btn-secondary" onclick="location.href='{{ url('/admin/tasks/'.$task->id.'/complete') }}'"><i class="ion ion-md-undo"></i>&nbsp; Mark As Incomplete</button>&emsp;
                    @endif
                </div>
            </div>
            <!-- / Description -->

        </div>
        <div class="col-md-4 col-xl-3">

            <!-- Task Details -->
            <div class="card mb-4">
                <h6 class="card-header">Task Details</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Assigned by</div>
                        <div>{{ $assigner->name }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Created at</div>
                        <div>{{ date_format($task->created_at, 'd/m/Y') }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Last update</div>
                        <div>{{ date_format($task->updated_at, 'd/m/Y') }}</div>
                    </li>
                    @if (null !== $task->due_date)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">Due Date</div>
                            <div><strong>{{ date_format(new DateTime($task->due_date), 'jS F Y') }}</strong></div>
                        </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Priority</div>
                        <div class="project-priority btn-group">
                            @switch($task->importance)
                            @case("Low")
                                <td><span class="badge badge-outline-success">Low</span></td>
                                @break
        
                            @case("Medium")
                                <td><span class="badge badge-outline-warning">Medium</span></td>
                                @break
        
                            @case("High")
                                <td><span class="badge badge-outline-danger">High</span></td>
                                @break
                            @endswitch
                        </div>
                    </li>
                </ul>
                @hasrole('admin')
                <div class="mt-2 mb-2 pl-2">
                    {!! Form::open(['action' => ['TaskController@destroy', $task->id], 'method' => 'POST']) !!}
                    <button type="button" class="btn btn-primary md-btn-flat" onclick="location.href='{{ url('/admin/tasks/edit/'.$task->id) }}'">Edit</button>
                    {{ Form::hidden('_method', 'DELETE')}}
                    {{ Form::Submit('Delete', ['class' => 'btn btn-danger md-btn-flat'])}}
                    {!! Form::close() !!}
                </div>
                @endhasrole
            </div>
            <!-- / Task Details -->

            <!-- Staff -->
            <div class="card mb-4">
                <h6 class="card-header with-elements">
                    <span class="card-header-title">Staff</span>
                    <div class="card-header-elements ml-auto"></div>
                </h6>
                <ul class="list-group list-group-flush">
                    @foreach ($staffArray as $staff)
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <img src="{{ asset('storage/photos/avatars/'.$staff->avatar) }}" class="d-block ui-w-30 rounded-circle" alt="">
                                <div class="media-body px-2 text-dark">
                                    {{ $staff->name }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- / Staff -->

            <!-- Creators -->
            <div class="card mb-4">
                <h6 class="card-header with-elements">
                    <span class="card-header-title">Creators</span>
                    <div class="card-header-elements ml-auto"></div>
                </h6>
                <ul class="list-group list-group-flush">
                    @foreach ($creatorArray as $creator)
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <img src="{{ asset('storage/photos/avatars/'.$creator->avatar) }}" class="d-block ui-w-30 rounded-circle" alt="">
                                <div class="media-body px-2 text-dark">
                                    {{ $creator->name }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- / Creators -->

        </div>
    </div>

@endsection