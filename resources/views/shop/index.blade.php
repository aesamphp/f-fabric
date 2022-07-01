@section('page_title', 'Shop')
@section('page_class', 'shop-page')


@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">

                    <!-- FEATURED BANNER -->
                    <div class="row">
                        <div class="col-xs-12">
                            <section class="featured-banner featured-banner--shop">
                                <h1 class="featured-banner__hdr">Shop</h1>
                                <p class="featured-banner__para">Choose from thousands of designs available by talented independent designers</p>
                            </section>
                        </div>
                    </div>

                    <!-- FABRIC INFO AND IMAGE -->
                    <section class="info-image">
                        @foreach ($categories as $key => $category)
                        <div class="row @if ($key & 1) even @else odd @endif">
                            <div class="col-xs-12">

                                <div class="col-sm-6 @if ($key & 1) even-col col-sm-push-6 @else odd-col @endif">
                                    <div class="info-image-textarea @if ($key & 1) -right- @else -left- @endif">
                                        <h2 class="info-image-textarea__hdr">{{ $category->title }}</h2>
                                        <div class="info-content">{!! $category->description !!}</div>

                                        <div class="row text-center-xs">
                                            <div class="col-lg-6">
                                                <a class="info-image-textarea__btn -left- btn-primary" href="{{ route('view.shop.all', ['category[]' => $category->id]) }}"><span>Shop {{ $category->title }} Now</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 @if ($key & 1) even-col col-absolute-left-xs @else odd-col col-absolute-right-xs @endif">
                                    <div class="info-image-cta js-full-mobile-only-half js-full-height" style="background-image:url(' {{ asset($category->image_path) }} ');">
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </section> 					

                </div>
            </div>
        </div>
    </div>

</main>

@include('includes.footer')
@stop