<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', __('Full Name').':') !!}
    <p>{{ $user->name }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', __('Email Address').':') !!}
    <p>{{ $user->email }}</p>
</div>

<!-- Phone Number Field -->
<div class="form-group">
    {!! Form::label('phone_number', __('Phone Number').':') !!}
    <p>{{ $user->phone_number }}</p>
</div>

<!-- Account Number Field -->
<div class="form-group">
    {!! Form::label('account_number', __('Account Number').':') !!}
    <p>{{ $user->account_number }}</p>
</div>

<!-- Role Field -->
<div class="form-group">
    {!! Form::label('role', __('User Role').':') !!}
    <p>{{ $user->role === 'admin' ? 'Administrator' : 'Regular User' }}</p>
</div>

<!-- Profile Image Field -->
<div class="form-group">
    {!! Form::label('profile_image', __('Profile Image').':') !!}
    @if($user->profile_image)
        <div class="mb-2">
            <img src="{{ $user->profile_image }}" alt="Profile Image" class="img-thumbnail" style="max-height: 100px;">
        </div>
    @else
        <p>No profile image available</p>
    @endif
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', __('Account Status').':') !!}
    <p>{{ $user->status === 'active' ? 'Active' : 'Inactive' }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', __('Created At').':') !!}
    <p>{{ $user->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', __('Updated At').':') !!}
    <p>{{ $user->updated_at }}</p>
</div>