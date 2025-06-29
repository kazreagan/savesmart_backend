@extends('layouts.app')
@section('title')
    @lang('Edit') @lang('Settings')
@endsection
@section('content')
    <section class="section">
            <div class="section-header">
                <h3 class="page__heading m-0">@lang('Edit') @lang('Settings')</h3>
                <div class="filter-container section-header-breadcrumb row justify-content-md-end">
                    <a href="{{ route('admin.settings.index') }}"  class="btn btn-primary">@lang('Back')</a>
                </div>
            </div>
  <div class="content">
              @include('stisla-templates::common.errors')
              <div class="section-body">
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                             <div class="card-body ">
                                    {!! Form::model($settings, ['route' => ['admin.settings.update', $settings->id], 'method' => 'patch']) !!}
                                        <div class="row">
                                            @include('admin.settings.fields')
                                        </div>

                                    {!! Form::close() !!}
                            </div>
                         </div>
                    </div>
                 </div>
              </div>
   </div>
  </section>
@endsection
