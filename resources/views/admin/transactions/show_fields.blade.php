<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', __('user_id').':') !!}
    <p>{{ $transaction->user_id }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', __('amount').':') !!}
    <p>{{ $transaction->amount }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', __('description').':') !!}
    <p>{{ $transaction->description }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', __('created_at').':') !!}
    <p>{{ $transaction->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', __('updated_at').':') !!}
    <p>{{ $transaction->updated_at }}</p>
</div>

