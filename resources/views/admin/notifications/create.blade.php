@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Create New Notification</h3>
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-primary float-right">
                            <i class="fa fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {!! Form::open(['route' => 'admin.notifications.store']) !!}
                        
                        <div class="form-group">
                            {!! Form::label('title', 'Title:') !!}
                            {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('message', 'Message:') !!}
                            {!! Form::textarea('message', null, ['class' => 'form-control', 'required', 'rows' => 3]) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('user', 'User:') !!}
                            <div class="input-group">
                                <div class="form-check form-check-inline">
                                    {!! Form::checkbox('send_to_all', '1', false, ['class' => 'form-check-input', 'id' => 'send_to_all']) !!}
                                    {!! Form::label('send_to_all', 'Send to All Users', ['class' => 'form-check-label']) !!}
                                </div>
                                <div id="user_select_container">
                                    {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'placeholder' => 'Select User', 'required', 'id' => 'user_id']) !!}
                                </div>
                            </div>
                            <small class="text-danger user-id-error" style="display: none;">The user id field is required.</small>
                        </div>

                        <div class="form-group">
                            {!! Form::label('type', 'Type:') !!}
                            {!! Form::select('type', ['Information' => 'Information', 'Success' => 'Success', 'Warning' => 'Warning', 'Error' => 'Error'], 'Information', ['class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Create Notification', ['class' => 'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle the "Send to All Users" checkbox
        $('#send_to_all').change(function() {
            if($(this).is(':checked')) {
                $('#user_id').prop('required', false);
                $('#user_select_container').hide();
                $('.user-id-error').hide();
            } else {
                $('#user_id').prop('required', true);
                $('#user_select_container').show();
            }
        });
        
        // Form validation
        $('form').submit(function(e) {
            if(!$('#send_to_all').is(':checked') && !$('#user_id').val()) {
                e.preventDefault();
                $('.user-id-error').show();
            }
        });
    });
</script>
@endpush