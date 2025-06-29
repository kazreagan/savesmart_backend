<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', __('user_id').':') !!}
    {!! Form::select('user_id', [], null, ['class' => 'form-control']) !!}
</div>

<!-- Message Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('message', __('message').':') !!}
    {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.notifications.index') }}" class="btn btn-light">@lang('cancel')</a>
</div>
