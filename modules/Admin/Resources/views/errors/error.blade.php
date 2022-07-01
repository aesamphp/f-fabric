@section('page_title', 'Error ' . $exception->getStatusCode())
@section('page_class', 'admin-error sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            <p>{{ $exception->getMessage() }}</p>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop