<!-- Key Field -->
<div class="form-group">
    {!! Form::label('key', __('models/settings.fields.key').':') !!}
    <p>{{ $settings->key }}</p>
</div>

<!-- Value Field -->
<div class="form-group">
    {!! Form::label('value', __('models/settings.fields.value').':') !!}
    <p>{{ $settings->value }}</p>
</div>

