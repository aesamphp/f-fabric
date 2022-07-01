@section('page_title', 'Print your own Fabric, Wallpaper &amp; More')
@section('page_class', 'page-custom-printing')
@section('meta_description', 'At Fashion Formula, we have a wide range of prints and bases to choose from, so creating your very own unique masterpiece is as easy as 123. Get started.')
@section('meta_keywords', '')

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
                            <section class="featured-banner featured-banner--custom-printing featured-banner--center">
                                <h1 class="featured-banner__hdr">Custom printing</h1>
                            </section>
                        </div>
                    </div> 

                    <!-- FEATURED TEXTAREA -->               	
                    <div class="row">
                        <div class="col-xs-12">
                            <section class="featured-textarea">
                                <h1 class="featured-textarea__hdr hdr-section">How to custom print</h1>
                                <p class="featured-textarea__para para-main">Printing your own textiles and wallpaper couldn't be easier. Simply upload the image you want to produce, select the repeat layout and the fabric…and off you go.<br />We have a selection of 35 fabrics and 3 papers to produce your design upon. Additionally you can post your designs to your own shop and earn commission from any sales.</p>
                            </section>
                        </div>
                    </div>

                    <!-- VIDEO SECTION -->
                    <div class="row">
                        <div class="col-xs-12">

                            <section class="info-video info-video--mar-15">
                                <div class="row">
                                    <div class="col-md-7 col-md-push-5">
                                        <div class="info-video-player video-player">
                                            <video id="myVideo" class="info-video-player__video">
                                                <source src="" type="video/mp4">
                                            </video>

                                            <span class="js-play info-video-player__play paused"></span>
                                            <span class="js-background info-video-player__darken fade"></span>

                                        </div>							
                                    </div>
                                    <div class="col-md-5 col-md-pull-7">
                                        <div class="info-video-textarea">
                                            <h2 class="info-video-textarea__hdr">Create your Masterpiece</h2>
                                            <p class="info-video-textarea__para">
                                                Whether you are creating your next catwalk collection, child’s play costume, interiors range or simply exhibiting your designs skills, Fashion Formula can help you!<br />
                                                With lots of online master classes and a community dedicated to making, creating and selling, you can find everything you need to create your masterpiece.
                                            </p>
                                            <a href="{{ route('view.design.tips') }}" class="info-video-textarea__btn btn-primary"><span>Find out more</span></a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>            
                    </div>

                    <!-- LATEST PRODUCTS SECTION -->
                    <div class="row">
                        <div class="col-xs-12">
                            <section class="container-latest-products">
                                <div class="latest-products">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <h2 class="latest-products__hdr hdr-section">Latest Products</h2>
                                            <section class="latest-products-carousel">

                                                <div class="sly-carousel" data-controls-outside="true" data-cycle-by="pages">
                                                    <div class="sly-content item-carousel clearfix">	
                                                        @foreach ($latestDesigns as $item)
                                                        <div class="sly-item item-carousel__list-item">
                                                            <div class="products-grid-tile">

                                                                @if ($item->isShoppable())
                                                                <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $item->identifier]) }}"></a>
                                                                @endif
                                                                
                                                                <div class="product-thumbnail" style="background-image: url('{{ asset($item->getThumbnailImagePath()) }}');"></div>
                                                                
                                                                <div class="hover">
                                                                    <div class="vertical-outer">
                                                                        <div class="vertical-inner">

                                                                            <div class="hover__left">
                                                                                @if ($item->isFavouriteable())
                                                                                <a class="btn-favourite-design @if ($item->hasfavourited()) active @endif" href="{{ route('favourite.design', ['id' => $item->id]) }}">
                                                                                    @if ($item->hasfavourited())
                                                                                    <img src="{{ asset('images/svgs/heart-red.svg') }}" alt="Favourite Design" />
                                                                                    @else
                                                                                    <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />
                                                                                    @endif
                                                                                    <span>{{ $item->getFavouritesCount() }}</span>
                                                                                </a>
                                                                                @else
                                                                                <a href="#" class="js-popup-btn" data-id="authentication-required-popup">
                                                                                    <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $item->getFavouritesCount() }}
                                                                                </a>
                                                                                @endif
                                                                            </div>
                                                                            <div class="js-container-magnific hover__right">
                                                                                <a href="{{ asset($item->getWatermarkImagePath()) }}" title="{{ $item->getDesignerCopyrightText() }}">
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
                                                                                <p class="info-left__type">{{ $item->title }}</p>
                                                                                <p class="info-left__author">by <a href="{{ route('view.designer.store', ['username' => $item->user->username]) }}">{{ $item->user->username }}</a></p>
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

                                                                        @if ($item->isShoppable())
                                                                        <a href="{{ route('view.shop.design', ['designIdentifier' => $item->identifier]) }}">
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
                                                </div>
                                                <button class="sly-prev sly-prev--dark" type="button"></button>
                                                <button class="sly-next sly-next--dark" type="button"></button>


                                            </section>	

                                            <a href="{{ route('view.shop.all') }}" class="latest-products__btn btn-primary btn-primary--no-border"><span>See More</span></a>

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>            
                    </div>	                
                </div>
            </div>
        </div>
    </div>

</main>

@include('includes.footer')
@stop