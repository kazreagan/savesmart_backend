@extends('layouts.app')

@section('title')
    @lang('savingGoals')
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@lang('savingGoals')</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('admin.savingGoals.create') }}" class="btn btn-primary form-btn">
                    @lang('add_new') <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form action="{{ route('admin.savingGoals.index') }}" method="GET" class="form-inline">
                                <div class="form-group mr-2">
                                    <select name="status" class="form-control">
                                        <option value="">@lang('all_status')</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>@lang('active')</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>@lang('completed')</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">@lang('filter')</button>
                                @if(request('status') || request('user_id'))
                                    <a href="{{ route('admin.savingGoals.index') }}" class="btn btn-light ml-2">@lang('clear')</a>
                                @endif
                            </form>
                        </div>
                    </div>
                    
                    @include('flash::message')
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="savingGoals-table">
                            <thead>
                                <tr>
                                    <th>@lang('id')</th>
                                    <th>@lang('user')</th>
                                    <th>@lang('title')</th>
                                    <th>@lang('target_amount')</th>
                                    <th>@lang('current_amount')</th>
                                    <th>@lang('progress')</th>
                                    <th>@lang('deadline')</th>
                                    <th>@lang('status')</th>
                                    <th>@lang('action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($savingGoals as $savingGoal)
                                    <tr>
                                        <td>{{ $savingGoal->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $savingGoal->user_id) }}">
                                                {{ $savingGoal->user->name }}
                                            </a>
                                        </td>
                                        <td>{{ $savingGoal->title }}</td>
                                        <td>${{ number_format($savingGoal->target_amount, 2) }}</td>
                                        <td>${{ number_format($savingGoal->current_amount, 2) }}</td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar {{ $savingGoal->completion_percentage >= 100 ? 'bg-success' : '' }}" 
                                                     role="progressbar" 
                                                     style="width: {{ $savingGoal->completion_percentage }}%;" 
                                                     aria-valuenow="{{ $savingGoal->completion_percentage }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $savingGoal->completion_percentage }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $savingGoal->deadline->format('M d, Y') }}
                                            @if(!$savingGoal->is_completed)
                                                <small class="text-muted d-block">
                                                    {{ $savingGoal->days_remaining }} days left
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($savingGoal->is_completed)
                                                <span class="badge badge-success">@lang('completed')</span>
                                            @else
                                                <span class="badge badge-primary">@lang('active')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class='btn-group'>
                                                <a href="{{ route('admin.savingGoals.show', [$savingGoal->id]) }}" 
                                                   class='btn btn-info btn-sm'>
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.savingGoals.edit', [$savingGoal->id]) }}" 
                                                   class='btn btn-warning btn-sm'>
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if(!$savingGoal->is_completed)
                                                    <a href="{{ route('admin.savingGoals.markCompleted', [$savingGoal->id]) }}" 
                                                       class='btn btn-success btn-sm'
                                                       onclick="return confirm('Are you sure you want to mark this goal as completed?')">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                @endif
                                                {!! Form::open(['route' => ['admin.savingGoals.destroy', $savingGoal->id], 'method' => 'delete', 'class' => 'd-inline']) !!}
                                                    {!! Form::button('<i class="fas fa-trash"></i>', [
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-sm',
                                                        'onclick' => "return confirm('Are you sure?')"
                                                    ]) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination justify-content-center">
                        {!! $savingGoals->appends(request()->input())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection