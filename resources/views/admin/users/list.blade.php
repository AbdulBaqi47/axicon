@extends('layouts.layout-2')

@section('styles')

    <title>Axiquo | Admin - Users</title>

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

    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-1 mt-1 mb-4">
        <div>Users</div>
    </h4>

    @include('includes.messages')

    <div class="card">

        <div class="table-responsive mb-4">
            <table class="table card-table table-hover mb-0">

                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subscription</th>
                    <th>Role</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td><a href="/admin/users/{{ $user->id }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    
                    @if ($user->subscribed('influencer') and $user->subscription('influencer')->onGracePeriod())
                        <td>Cancelling</td>
                    @elseif ($user->subscribed('influencer'))
                        <td>Active</td>
                    @else
                        <td>None</td>
                    @endif

                    @if ($user->hasRole('admin'))
                    <td>Admin</td>
                    @elseif ($user->hasRole('partner-manager'))
                    <td>Partner Manager</td>
                    @elseif ($user->hasRole('support'))
                    <td>Support</td>
                    @else
                    <td>User</td>
                    @endif


                    <td>{{ date_format($user->updated_at,"d/m/Y") }}</td>
                    <td>
                        {!! Form::open(['action' => ['UserController@destroy', $user->id], 'method' => 'POST']) !!}
                        <button type="button" class="btn btn-sm btn-info md-btn-flat" onclick="location.href='{{ url('/admin/users/edit/'.$user->id) }}'">Edit</button>
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::Submit('Delete', ['class' => 'btn btn-sm btn-danger md-btn-flat'])}}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
                
                </tbody>

            </table>

        </div>

        <hr class="border-light mt-2 mb-4">

        <nav>
            <ul class="pagination justify-content-center">
                {{ $users->links() }}
            </ul>
        </nav>

    </div>

@endsection