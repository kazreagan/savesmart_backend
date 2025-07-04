@extends('layouts.app')
@section('title')
    @lang('Settings')  @lang('Details') 
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>@lang('Settings') @lang('Details')</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('admin.settings.index') }}"
                 class="btn btn-primary form-btn float-right">@lang('Back')</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('admin.settings.show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection

