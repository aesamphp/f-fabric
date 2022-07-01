@section('page_title', 'Favorites')
@section('page_class', 'favorites-page')


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
                            <section class="featured-banner featured-banner--drawing no-title">
                                <h1 class="featured-banner__hdr">Your Favorites</h1>
                            </section>
                        </div>
                    </div>

                    <!-- FAVORITES GRID -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="products-grid-likes no-top-link add-pad">
                                @include('includes.flash')
                                @if (count($favouriteDesigns) > 0)
                                <section class="products-grid">
                                    <a href="{{ route('view.user.studio') }}" class="products-grid__back-btn link-back">Back to My Studio</a>
                                    <div class="js-grid-products-container row no-mar">
                                        
                                        @foreach ($favouriteDesigns as $favouriteDesign)
                                        <div class="col-lg-3 col-md-4 col-xs-6 boot-style">		
                                            <div class="products-grid-tile">

                                                @if ($favouriteDesign->design->isShoppable())
                                                <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $favouriteDesign->design->identifier]) }}"></a>
                                                @endif

                                                <div class="product-thumbnail height-xs-full" style="background-image: url('{{ asset($favouriteDesign->design->getThumbnailImagePath()) }}');"></div>
                                                
                                                <div class="hover">
                                                    <div class="vertical-outer">
                                                        <div class="vertical-inner">

                                                            <div class="hover__left">
                                                                <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $favouriteDesign->design->getFavouritesCount() }}
                                                            </div>
                                                            <div class="js-container-magnific hover__right">
                                                                <a href="{{ asset($favouriteDesign->design->getWatermarkImagePath()) }}" title="{{ $favouriteDesign->design->getDesignerCopyrightText() }}">
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
                                                                <p class="info-left__type">{{ $favouriteDesign->design->title }}</p>
                                                                <p class="info-left__author">by <a href="{{ route('view.designer.store', ['username' => $favouriteDesign->design->user->studio->username]) }}">{{ $favouriteDesign->design->user->username }}</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="info-right">
                                                        <!-- Mobile & Tablet Only -->
                                                        <div class="hidden">
                                                            <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/heart.svg') }}" />
                                                        </div>
                                                        <a class="tablet-magnify hidden" href="{{ asset('images/pattern1.png') }}"><img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/magnify.svg') }}" /></a>
                                                        <!---->

                                                        @if ($favouriteDesign->design->isShoppable())
                                                        <a href="{{ route('view.shop.design', ['designIdentifier' => $favouriteDesign->design->identifier]) }}">
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
                                </section>

                                <!-- FAVORITES EDIT LIST -->	
                                <div class="base-customise">
                                    <form class="delete-form" action="{{ route('delete.user.favorites') }}" method="POST" data-message="Are you sure you want to clear your favorites list?">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="base-customise__link link-remove">clear favorites list</button>
                                    </form>
                                </div>
                                @else
                                <div class="col-xs-12">
                                    <p>You don't have any designs saved in your favorites list.</p>
                                </div>
                                @endif
                            </div>
                        </div> 
                    </div>			

                </div>
            </div>
        </div>
    </div>

</main>

@include('includes.footer')
@stop