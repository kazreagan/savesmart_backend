@extends('layouts.app')
@section('title')
    @lang('Savings')  @lang('details') 
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>@lang('Savings') @lang('details')</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('admin.savings.index') }}"
                 class="btn btn-primary form-btn float-right">@lang('Back')</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('admin.savings.show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection

