@extends('layouts.app')
@section('title')
    @lang('edit') @lang('models/savingGoals.singular')
@endsection
@section('content')
    <section class="section">
            <div class="section-header">
                <h3 class="page__heading m-0">@lang('edit') @lang('models/savingGoals.singular')</h3>
                <div class="filter-container section-header-breadcrumb row justify-content-md-end">
                    <a href="{{ route('savingGoals.index') }}"  class="btn btn-primary">@lang('back')</a>
                </div>
            </div>
  <div class="content">
              @include('stisla-templates::common.errors')
              <div class="section-body">
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                             <div class="card-body ">
                                    {!! Form::model($savingGoal, ['route' => ['savingGoals.update', $savingGoal->id], 'method' => 'patch']) !!}
                                        <div class="row">
                                            @include('saving_goals.fields')
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
