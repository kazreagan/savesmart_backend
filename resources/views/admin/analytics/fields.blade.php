<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', __('User_id').':') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Total Savings Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_savings', __('Total_Savings').':') !!}
    {!! Form::number('total_savings', null, ['class' => 'form-control']) !!}
</div>

<!-- Last Activity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('last_activity', __('Last_Activity').':') !!}
    {!! Form::date('last_activity', null, ['class' => 'form-control','id'=>'last_activity']) !!}
</div>

@push('scripts')
    <script type="text/javascript">
        $('#last_activity').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endpush

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.analytics.index') }}" class="btn btn-light">@lang('Cancel')</a>
</div>
