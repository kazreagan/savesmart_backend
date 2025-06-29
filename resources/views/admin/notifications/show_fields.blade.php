<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', __('user_id').':') !!}
    <p>{{ $notification->user_id }}</p>
</div>

<!-- Message Field -->
<div class="form-group">
    {!! Form::label('message', __('message').':') !!}
    <p>{{ $notification->message }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', __('created_at').':') !!}
    <p>{{ $notification->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', __('updated_at').':') !!}
    <p>{{ $notification->updated_at }}</p>
</div>

