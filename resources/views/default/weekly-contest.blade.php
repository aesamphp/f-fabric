@section('page_title', 'Weekly Contest')
@section('page_class', 'weekly-contest-page')


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
                            <section class="featured-banner featured-banner--favorites">
                                <h1 class="featured-banner__hdr no-title">Weekly Contest</h1>
                            </section>
                        </div>
                    </div>

                    <!-- WEEKLY CONTEST GRID -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="products-grid-likes add-pad">
                                <section class="products-grid">
                                    <a href="{{ route('view.community') }}" class="products-grid__back-btn link-back">Back to Community</a>
                                    <div class="row no-mar">
                                        @if ($contestDesigns)
                                        <div class="col-xs-12 padding-bottom-15">
                                            <h4 class="hdr-aside no-pad-bottom">{{ $liveContest->title }}</h4>
                                            <div class="blog-listing no-mar">{!! $liveContest->description !!}</div>
                                            <p class="brief-descriptions-single__para">Ending {{ formatDate($liveContest->to_date, 'jS F Y') }}</p>
                                        </div>
                                            @if (count($contestDesigns) > 0)
                                                @foreach ($contestDesigns as $design)
                                                <div class="col-lg-3 col-sm-4 boot-style">		
                                                    <div class="products-grid-tile">

                                                        @if ($design->isShoppable())
                                                        <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $design->identifier]) }}"></a>
                                                        @endif
                                                        
                                                        <div class="product-thumbnail" style="background-image: url('{{ asset($design->getThumbnailImagePath()) }}');"></div>

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

                                                        <div class="info info-likes">
                                                            <div class="vertical-outer">
                                                                <div class="vertical-inner">	
                                                                    <div class="info-left">
                                                                        <p class="info-left__type">{{ $design->title }}</p>
                                                                        <p class="info-left__author">by <a href="{{ route('view.designer.store', ['username' => $design->user->studio->username]) }}">{{ $design->user->username }}</a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="info-right">
                                                                @if ($design->isLikeable())
                                                                <a class="btn-like-design @if ($design->hasLiked()) active @endif" href="{{ route('like.design', ['id' => $design->id]) }}">
                                                                    @if ($design->hasLiked())
                                                                    <img class="info-right__img" src="{{ asset('images/svgs/like-highlight.svg') }}" alt="Like Design" />
                                                                    @else
                                                                    <img class="info-right__img" src="{{ asset('images/svgs/like.svg') }}" alt="Like Design" />
                                                                    @endif
                                                                    <span class="info-right__number">{{ $design->getContestLikesCount() }}</span>
                                                                </a>
                                                                @else
                                                                <a href="#" class="js-popup-btn" data-id="authentication-required-popup">
                                                                    <img class="info-right__img" src="{{ asset('images/svgs/like.svg') }}" alt="Like Design" />
                                                                    <span class="info-right__number">{{ $design->getContestLikesCount() }}</span>
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                            <h4>Currently there is no designs participating in this contest</h4>
                                            @endif
                                        @else
                                        <h4>Currently there is no live contest</h4>
                                        @endif
                                    </div>
                                </section>
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