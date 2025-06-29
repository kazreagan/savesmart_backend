@extends('layouts.app')
@section('title')
    @lang('Analytics')  @lang('Details') 
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>@lang('Analytics') @lang('Details')</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('admin.analytics.index') }}"
                 class="btn btn-primary form-btn float-right">@lang('Back')</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('admin.analytics.show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection

