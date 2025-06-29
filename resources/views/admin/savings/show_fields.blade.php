<!-- Name Field -->
<div class="form-group">
    {!! Form::label('Name', __('Name').':') !!}
    <p>{{ $saving->name }}</p>
</div>

<!-- Target Amount Field -->
<div class="form-group">
    {!! Form::label('Target_Amount', __('Target_Amount').':') !!}
    <p>{{ $saving->target_amount }}</p>
</div>

<!-- Current Amount Field -->
<div class="form-group">
    {!! Form::label('Current_Amount', __('Current_Amount').':') !!}
    <p>{{ $saving->current_amount }}</p>
</div>

<!-- Target Date Field -->
<div class="form-group">
    {!! Form::label('Target_Date', __('Target_Date').':') !!}
    <p>{{ $saving->target_date }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('Description', __('Description').':') !!}
    <p>{{ $saving->description }}</p>
</div>

<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('User_id', __('User_id').':') !!}
    <p>{{ $saving->user_id }}</p>
</div>

