<!-- Key Field -->
<div class="form-group col-sm-6">
    {!! Form::label('key', __('Key').':') !!}
    {!! Form::text('key', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('value', __('Value').':') !!}
    {!! Form::textarea('value', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.settings.index') }}" class="btn btn-light">@lang('Cancel')</a>
</div>
