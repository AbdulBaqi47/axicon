@extends('layouts.layout-2')

<?php use App\User; ?>

@section('styles')

    <title>Axiquo | Admin - Tasks</title>

@endsection

@section('content')

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mb-4">
        <div>Tasks</div>
        @hasrole('admin')
        <button type="button" class="btn btn-primary btn-round d-block" onclick="location.href='{{ url('/admin/tasks/create') }}'">
        <span class="ion ion-md-add"></span>&nbsp; Create Task</button>
        @endhasrole
    </h4>

    @include('includes.messages')

    <ul class="nav bg-lighter container-p-x py-1 pt-2 pb-2 container-m--x mb-4">
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $filter == 'all' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/tasks') }}">All</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $filter == 'incomplete' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/tasks?filter=incomplete') }}">Incomplete</a>
        </li>
        <li class="pt-2 pr-4 pb-2">
            <a class="{{ $filter == 'complete' ? 'text-dark font-weight-bold pl-0' : 'text-muted' }}" href="{{ url('/admin/tasks?filter=complete') }}">Complete</a>
        </li>
    </ul>

    <div class="row">

        @foreach ($tasks as $task)
        
            <div class="col-sm-12 col-md-6 col-xl-6">
                <div class="card mb-4">
                    <div class="card-body d-flex justify-content-between align-items-start pb-3">
                        <div>
                            <a href="{{ url('/admin/tasks/'.$task->id) }}" class="text-dark text-big font-weight-semibold">{{ $task->name }}</a>
                            <br>
                            @if ($task->due_date !== null)
                                <div class="text-muted small mt-1">Due: <span class="font-weight-bold">{{ date_format(new DateTime($task->due_date), 'jS F Y') }}</span></div>
                            @else
                                <div class="text-muted small mt-1">Due: <span class="font-weight-bold">Not Set</span></div>
                            @endif
                            @switch($task->completed)
                                @case("0")
                                    <span class="badge badge-danger align-text-bottom mt-2">Incomplete</span>
                                @break
                                @case("1")
                                    <span class="badge badge-success align-text-bottom mt-2">Complete</span>
                                @break
                            @endswitch
                        </div>
                        <div class="btn-group project-actions">
                            {!! Form::open(['action' => ['TaskController@destroy', $task->id], 'method' => 'POST']) !!}
                            <button type="button" class="btn btn-sm btn-info md-btn-flat" onclick="location.href='{{ url('/admin/tasks/edit/'.$task->id) }}'">Edit</button>
                            {{ Form::hidden('_method', 'DELETE')}}
                            {{ Form::Submit('Delete', ['class' => 'btn btn-sm btn-danger md-btn-flat'])}}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="card-body pt-1 pb-3">
                        <div class="d-flex flex-wrap">
                            <?php 
                                if (null !== $task->staff) { 
                                    $staffs = explode(',', $task->staff); 
                                } else {
                                    $staffs = [];
                                }
                            ?>
                            @foreach ($staffs as $staff)
                                <?php $staff = User::where('id', $staff)->first(); ?>
                                @hasrole('admin')
                                    <a href="{{ url('/admin/users/'.$staff->id) }}" target="_blank" class="d-block mr-1 mb-1">
                                        <img src="{{ asset('storage/photos/avatars/'.$staff->avatar) }}" alt="" class="ui-w-30 rounded-circle">
                                    </a>
                                @else
                                    <div class="d-block mr-1 mb-1">
                                        <img src="{{ asset('storage/photos/avatars/'.$staff->avatar) }}" alt="" class="ui-w-30 rounded-circle">
                                    </div>
                                @endhasrole
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

    <hr class="border-light mt-4 mb-4">

    <nav>
        <ul class="pagination justify-content-center">
            {{ $tasks->links() }}
        </ul>
    </nav>

@endsection