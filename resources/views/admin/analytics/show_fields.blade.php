<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', __('user_id').':') !!}
    <p>{{ $analytics->user_id }}</p>
</div>

<!-- Total Savings Field -->
<div class="form-group">
    {!! Form::label('total_savings', __('total_savings').':') !!}
    <p>{{ $analytics->total_savings }}</p>
</div>

<!-- Last Activity Field -->
<div class="form-group">
    {!! Form::label('last_activity', __('last_activity').':') !!}
    <p>{{ $analytics->last_activity }}</p>
</div>

