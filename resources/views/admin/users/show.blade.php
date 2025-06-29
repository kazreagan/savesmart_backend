@extends('layouts.app')
@section('title')
    @lang('users')  @lang('details') 
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>@lang('users') @lang('details')</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('admin.users.index') }}"
                 class="btn btn-primary form-btn float-right">@lang('back')</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
            @include('admin.users.fields')
                    <div class="form-group mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-default">{{ __('Back') }}</a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                    </div>
            </div>
            </div>
    </div>
    </section>
@endsection

