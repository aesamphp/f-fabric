@section('page_title', $product->title)
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s3"><a class="active" href="#general">General</a></li>
                    <li class="tab col s3"><a href="#material">Material</a></li>
                    <li class="tab col s3"><a href="#quantity">Quantity</a></li>
                    <li class="tab col s3"><a href="#package-types">Packages</a></li>
                </ul>
            </div>

            <div id="general" class="col s12">
                <div class="row">
                    @include('admin::product.product-general')
                </div>
            </div>
            <div id="material" class="col s12">
                <div class="row">
                    @include('admin::product.product-materials')
                </div>
            </div>
            <div id="quantity" class="col s12">
                <div class="row">
                    @include('admin::product.product-quantities')
                </div>
            </div>
            <div id="package-types" class="col s12">
                <div class="row">
                    @include('admin::product.product-package-types')
                </div>
            </div>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop