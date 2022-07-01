@section('page_title', $zone->title)
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
                    <li class="tab col s6"><a href="#countries">Countries</a></li>
                    <li class="tab col s6"><a href="#weight-brandings">Brandings</a></li>
                </ul>
            </div>

            <div id="general" class="col s12">
                <div class="row">
                    @include('admin::setting.shipping.shipping-zone-general')
                </div>
            </div>
            <div id="countries" class="col s12">
                <div class="row">
                    @include('admin::setting.shipping.shipping-zone-countries')
                </div>
            </div>
            <div id="weight-brandings" class="col s12">
                <div class="row">
                    @include('admin::setting.shipping.shipping-zone-weight-brandings')
                </div>
            </div>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop