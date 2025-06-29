<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Name', __('Name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Target Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Target_Amount', __('Target_Amount').':') !!}
    {!! Form::number('target_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Current Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Current_Amount', __('Current_Amount').':') !!}
    {!! Form::number('current_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Target Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Target_Date', __('Target_Date').':') !!}
    {!! Form::date('target_date', null, ['class' => 'form-control','id'=>'target_date']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#target_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endpush

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('Description', __('Description').':') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('User_id', __('User_id').':') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.savings.index') }}" class="btn btn-light">@lang('Cancel')</a>
</div>
