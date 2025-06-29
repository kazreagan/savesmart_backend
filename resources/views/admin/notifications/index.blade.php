@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Notifications</h3>
                        <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary float-right">
                            <i class="fa fa-plus"></i> Create New
                        </a>
                    </div>
                    <div class="card-body">
                        @include('flash::message')
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="notifications-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Is Broadcast</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notifications as $notification)
                                    <tr>
                                        <td>{{ $notification->id }}</td>
                                        <td>{{ $notification->title }}</td>
                                        <td>{{ Str::limit($notification->message, 50) }}</td>
                                        <td>
                                            @if($notification->is_broadcast)
                                                <span class="badge badge-success">All Users</span>
                                            @else
                                                {{ $notification->user ? $notification->user->name : 'N/A' }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $notification->type == 'Information' ? 'info' : ($notification->type == 'Success' ? 'success' : ($notification->type == 'Warning' ? 'warning' : 'danger')) }}">
                                                {{ $notification->type }}
                                            </span>
                                        </td>
                                        <td>{{ $notification->is_broadcast ? 'Yes' : 'No' }}</td>
                                        <td>{{ $notification->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class='btn-group'>
                                                <a href="{{ route('admin.notifications.show', $notification->id) }}" class='btn btn-info btn-sm'>
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.notifications.edit', $notification->id) }}" class='btn btn-warning btn-sm'>
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                {!! Form::open(['route' => ['admin.notifications.destroy', $notification->id], 'method' => 'delete', 'class' => 'd-inline']) !!}
                                                <button type="submit" class='btn btn-danger btn-sm' onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="pagination justify-content-center">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection