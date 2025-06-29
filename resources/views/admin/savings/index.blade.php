@extends('layouts.app')
@section('title')
     @lang('Savings')
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>@lang('Savings')</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('admin.savings.create')}}" class="btn btn-primary form-btn">@lang('Add_new')<i class="fas fa-plus"></i></a>
            </div>
        </div>
    <div class="section-body">
       <div class="card">
            <div class="card-body">
                @include('admin.savings.table')
            </div>
       </div>
   </div>
    
    </section>
@endsection



