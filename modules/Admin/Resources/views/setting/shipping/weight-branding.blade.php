@section('page_title', $weightBranding->title)
@section('page_class', 'admin-settings sticky-footer')

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
                    <li class="tab col s6"><a href="#packages">Packages</a></li>
                </ul>
            </div>

            <div id="general" class="col s12">
                <div class="row">
                    @include('admin::setting.shipping.weight-branding-general')
                </div>
            </div>
            <div id="packages" class="col s12">
                <div class="row">
                    @include('admin::setting.shipping.weight-branding-packages')
                </div>
            </div>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop