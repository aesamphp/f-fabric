@section('page_title', $carousel->title)
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')
            
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s6"><a class="active" href="#general">General</a></li>
                    <li class="tab col s6"><a href="#slides">Slides</a></li>
                </ul>
            </div>

            <div id="general" class="col s12">
                <div class="row">
                    @include('admin::carousel.carousel-general')
                </div>
            </div>
            <div id="slides" class="col s12">
                <div class="row">
                    @include('admin::carousel.carousel-slides')
                </div>
            </div>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop