@extends('layouts.app')
@section('title')
    @lang('transactions')  @lang('details') 
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>@lang('transactions') @lang('details')</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('transactions.index') }}"
                 class="btn btn-primary form-btn float-right">@lang('back')</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('admin.show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection

