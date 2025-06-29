@extends('layouts.app')
@section('title')
    @lang('savingGoals')  @lang('details') 
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>@lang('savingGoals') @lang('details')</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('savingGoals.index') }}"
                 class="btn btn-primary form-btn float-right">@lang('back')</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection

