<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', __('Name').':') !!}
    <p>{{ $category->name }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', __('Description').':') !!}
    <p>{{ $category->description }}</p>
</div>

