<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('Full Name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', __('Email Address').':') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', __('Password').':') !!}
    {!! Form::password('password', ['class' => 'form-control', isset($user) && $user->exists ? '' : 'required']) !!}
    @if(isset($user) && $user->exists)
        <small class="text-muted">{{ __('Leave blank to keep current password') }}</small>
    @endif
</div>

<!-- Phone Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone_number', __('Phone Number').':') !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role', __('User Role').':') !!}
    {!! Form::select('role', ['user' => 'Regular User', 'admin' => 'Administrator'], null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Profile Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('profile_image', __('Profile Image').':') !!}
    <div class="custom-file">
        {!! Form::file('profile_image', ['class' => 'custom-file-input']) !!}
        <label class="custom-file-label">{{ __('Choose file') }}</label>
    </div>
    @if(isset($user) && $user->profile_image)
        <div class="mt-2">
            <img src="{{ $user->profile_image }}" alt="Current Profile Image" class="img-thumbnail" style="max-height: 100px;">
        </div>
    @endif
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', __('Account Status').':') !!}
    {!! Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Submit Button -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.users.index') }}" class="btn btn-default">{{ __('Cancel') }}</a>
</div>