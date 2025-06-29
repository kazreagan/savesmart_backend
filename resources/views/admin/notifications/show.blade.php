@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Notification Details</h3>
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary float-right">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 20%;">ID</th>
                                    <td>{{ $notification->id }}</td>
                                </tr>
                                <tr>
                                    <th>Title</th>
                                    <td>{{ $notification->title }}</td>
                                </tr>
                                <tr>
                                    <th>Message</th>
                                    <td>{{ $notification->message }}</td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td>
                                        @if($notification->is_broadcast)
                                            <span class="badge badge-success">All Users</span>
                                        @else
                                            {{ $notification->user ? $notification->user->name : 'N/A' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>
                                        <span class="badge badge-{{ $notification->type == 'Information' ? 'info' : ($notification->type == 'Success' ? 'success' : ($notification->type == 'Warning' ? 'warning' : 'danger')) }}">
                                            {{ $notification->type }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Is Broadcast</th>
                                    <td>{{ $notification->is_broadcast ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr>
                                    <th>Is Read</th>
                                    <td>{{ $notification->is_read ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $notification->created_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $notification->updated_at->format('M d, Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-warning">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            {!! Form::open(['route' => ['admin.notifications.destroy', $notification->id], 'method' => 'delete', 'class' => 'd-inline']) !!}
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection