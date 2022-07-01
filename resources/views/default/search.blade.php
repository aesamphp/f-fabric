@extends('layouts.master')

@section('page_title', 'Search')
@section('page_class', 'search-designs')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>
    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">
                    <!-- FEATURED BANNER -->  
                	<div class="col-md-12 clearfix no-pad">
                        <section class="featured-banner featured-banner--contact">
                            <h1 class="featured-banner__hdr">Search results for {{ $keyword }}</h1>
                        </section>
                    </div>            		
                </div>
                <div class="row">

                    <!-- LATEST DESIGNS -->
                    <div class="col-md-12 clearfix no-pad">
                        <section class="products-grid shop-fabrics">
                            <div class="row no-mar js-grid-products-container">

                                @foreach ($designs as $design)
                                <div class="col-lg-3 col-md-4 col-xs-6 boot-style">		
                                    <div class="products-grid-tile">

                                        @if ($design->isShoppable())
                                        <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $design->identifier]) }}"></a>
                                        @endif
                                        
                                        <div class="product-thumbnail height-xs-full" style="background-image: url('{{ asset($design->getThumbnailImagePath()) }}');"></div>

                                        <div class="hover">
                                            <div class="vertical-outer">
                                                <div class="vertical-inner">

                                                    <div class="hover__left">
                                                        @if ($design->isFavouriteable())
                                                        <a class="btn-favourite-design @if ($design->hasfavourited()) active @endif" href="{{ route('favourite.design', ['id' => $design->id]) }}">
                                                            @if ($design->hasfavourited())
                                                            <img src="{{ asset('images/svgs/heart-red.svg') }}" alt="Favourite Design" />
                                                            @else
                                                            <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />
                                                            @endif
                                                            <span>{{ $design->getFavouritesCount() }}</span>
                                                        </a>
                                                        @else
                                                        <a href="#" class="js-popup-btn" data-id="authentication-required-popup">
                                                            <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $design->getFavouritesCount() }}
                                                        </a>
                                                        @endif
                                                    </div>
                                                    <div class="js-container-magnific hover__right">
                                                        <a href="{{ asset($design->getWatermarkImagePath()) }}" title="{{ $design->getDesignerCopyrightText() }}">
                                                            <img src="{{ asset('images/svgs/magnify.svg') }}" alt="Magnify" />Quick Look
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="info">
                                            <div class="vertical-outer">
                                                <div class="vertical-inner">	
                                                    <div class="info-left">
                                                        <p class="info-left__type">{{ $design->title }}</p>
                                                        <p class="info-left__author">by <a href="{{ route('view.designer.store', ['username' => $design->user->studio->username]) }}">{{ $design->user->username }}</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-right">
                                                <!-- Mobile & Tablet Only -->
                                                <div class="hidden">
                                                    <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/heart.svg') }}" />
                                                </div>
                                                <a class="tablet-magnify hidden" href="{{ asset('images/pattern1.png') }}"><img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/magnify.svg') }}"></a>
                                                <!---->

                                                @if ($design->isShoppable())
                                                <a href="{{ route('view.shop.design', ['designIdentifier' => $design->identifier]) }}">
                                                    <img class="info-right__img" src="{{ asset('images/svgs/cart.svg') }}" />
                                                    <img class="info-right__img--bg" src="{{ asset('images/svgs/cart-highlight.svg') }}" />
                                                </a>
                                                @else
                                                <a href="#" class="js-popup-btn" data-id="design-not-for-sale-popup">
                                                    <img class="info-right__img" src="{{ asset('images/svgs/eye-icon.svg') }}" />
                                                </a>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                            </div>

                                @if(count($users) > 0)
                                    <div class="row no-mar js-grid-products-container">
                                    <h1>Designers</h1>
                                        @foreach ($users as $user)
                                            <div class="col-lg-3 col-md-4 col-xs-6 boot-style search-img ">
                                                <div class="products-grid-tile">
                                                    <div class="aside-store-main__img" style="background-image: url('{{ asset($user->getImagePath()) }}');"></div>
                                                    <div class="info">
                                                        <div class="vertical-outer">
                                                            <div class="vertical-inner">
                                                                <div class="info-left">
                                                                    <p class="info-left__author user-info">
                                                                        <a href="{{ route('view.designer.store', ['username' => $user->username]) }}">{{ $user->getFullName() }}</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="info-right">
                                                            <!-- Mobile & Tablet Only -->
                                                            <div class="hidden">
                                                                <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/heart.svg') }}"/>
                                                            </div>
                                                            <a class="tablet-magnify hidden" href="{{ asset('images/pattern1.png') }}">
                                                                <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/magnify.svg') }}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                        </section>
                    </div>   
                </div>
            </div>
        </div>
    </div>

</main>

@include('includes.footer')
@stop
