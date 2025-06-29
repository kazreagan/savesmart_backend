@extends('layouts.app')

@section('title')
    @lang('models/savingGoals.singular') @lang('crud.details')
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@lang('models/savingGoals.singular') @lang('crud.details')</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('admin.savingGoals.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> @lang('crud.back')
                </a>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">@lang('models/savingGoals.fields.title'):</label>
                                        <p>{{ $savingGoal->title }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user">@lang('models/savingGoals.fields.user'):</label>
                                        <p>
                                            <a href="{{ route('admin.users.show', $savingGoal->user_id) }}">
                                                {{ $savingGoal->user->name }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">@lang('models/savingGoals.fields.description'):</label>
                                        <p>{{ $savingGoal->description ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="target_amount">@lang('models/savingGoals.fields.target_amount'):</label>
                                        <p>${{ number_format($savingGoal->target_amount, 2) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="current_amount">@lang('models/savingGoals.fields.current_amount'):</label>
                                        <p>${{ number_format($savingGoal->current_amount, 2) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="deadline">@lang('models/savingGoals.fields.deadline'):</label>
                                        <p>{{ $savingGoal->deadline->format('M d, Y') }}</p>
                                        
                                        @if(!$savingGoal->is_completed && $savingGoal->days_remaining > 0)
                                            <p><small class="text-muted">{{ $savingGoal->days_remaining }} days remaining</small></p>
                                        @elseif(!$savingGoal->is_completed && $savingGoal->days_remaining <= 0)
                                            <p><small class="text-danger">Deadline passed</small></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">@lang('models/savingGoals.fields.status'):</label>
                                        <p>
                                            @if($savingGoal->is_completed)
                                                <span class="badge badge-success">@lang('models/savingGoals.fields.completed')</span>
                                            @else
                                                <span class="badge badge-primary">@lang('models/savingGoals.fields.active')</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="created_at">@lang('crud.created_at'):</label>
                                        <p>{{ $savingGoal->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updated_at">@lang('crud.updated_at'):</label>
                                        <p>{{ $savingGoal->updated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5>@lang('models/savingGoals.fields.progress')</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-4">
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar {{ $savingGoal->completion_percentage >= 100 ? 'bg-success' : '' }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $savingGoal->completion_percentage }}%;" 
                                                 aria-valuenow="{{ $savingGoal->completion_percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                {{ $savingGoal->completion_percentage }}%
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <span>$0</span>
                                        <span>${{ number_format($savingGoal->target_amount, 2) }}</span>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="text-center mt-4">
                                        <h5>@lang('models/savingGoals.fields.amount_saved')</h5>
                                        <h3>${{ number_format($savingGoal->current_amount, 2) }}</h3>
                                        <p class="text-muted">
                                            @lang('models/savingGoals.fields.amount_remaining'): 
                                            ${{ number_format(max(0, $savingGoal->target_amount - $savingGoal->current_amount), 2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('admin.savingGoals.edit', [$savingGoal->id]) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> @lang('crud.edit')
                                </a>
                                
                                @if(!$savingGoal->is_completed)
                                    <a href="{{ route('admin.savingGoals.markCompleted', [$savingGoal->id]) }}" 
                                       class="btn btn-success"
                                       onclick="return confirm('Are you sure you want to mark this goal as completed?')">
                                        <i class="fas fa-check"></i> @lang('models/savingGoals.fields.mark_completed')
                                    </a>
                                @endif
                                
                                {!! Form::open(['route' => ['admin.savingGoals.destroy', $savingGoal->id], 'method' => 'delete']) !!}
                                    {!! Form::button('<i class="fas fa-trash"></i> ' . __('crud.delete'), [
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger',
                                        'onclick' => "return confirm('Are you sure you want to delete this goal?')"
                                    ]) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection