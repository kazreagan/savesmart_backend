<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', __('user_id').':') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', __('title').':') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', __('description').':') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
</div>

<!-- Target Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('target_amount', __('target_amount').':') !!}
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">$</span>
        </div>
        {!! Form::number('target_amount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
    </div>
</div>

<!-- Current Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('current_amount', __('current_amount').':') !!}
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">$</span>
        </div>
        {!! Form::number('current_amount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
    </div>
</div>

<!-- Deadline Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deadline', __('deadline').':') !!}
    {!! Form::date('deadline', null, ['class' => 'form-control','id'=>'deadline']) !!}
</div>

<!-- Is Completed Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_completed', __('is_completed').':') !!}
    <div class="form-check">
        {!! Form::checkbox('is_completed', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('is_completed', __('mark_completed'), ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.savingGoals.index') }}" class="btn btn-light">@lang('cancel')</a>
</div>

@push('scripts')
<script type="text/javascript">
    $('#deadline').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: true,
        sideBySide: true,
        minDate: moment().startOf('day')
    });
</script>
@endpush