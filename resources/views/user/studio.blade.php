@section('page_title', 'My Studio')
@section('page_class', 'my-studio')


@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">

                    <!-- ASIDE -->
                    <div class="col-md-3 aside-boot">
                        <div class="sidebar">
                            <aside class="aside-store">
                                <div class="aside-store-main">
                                    <div class="aside-store-main__img" style="background-image: url('{{ asset($shop->getImagePath()) }}');"></div>
                                    <div class="row no-mar">
                                        <div class="col-md-12 col-sm-4 no-pad">
                                            <a href="{{ route('edit.user.shop') }}" class="aside-store-main__btn btn-primary"><span>Manage store settings</span></a>
                                            <a href="{{ route('view.design.upload') }}" class="aside-store-main__btn aside-store-main__btn--second btn-tertiary"><span>Add a new design</span></a>
                                        </div>
                                        <div class="col-md-12 col-sm-8 no-pad">
                                            <ul class="list">
                                                <li class="item">{{ $shop->getFullName() }}</li>
                                                <li class="item">{{ $shop->getLocation() }}</li>
                                            </ul>
                                            @if ($shop->store_link)
                                            <a href="{{ $shop->store_link }}" class="aside-store-main__link link-addr" target="_blank">{{ extractDomainFromURL($shop->store_link) }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="aside-store-qty clearfix">
                                    <div class="col-xs-6 no-pad">
                                        <p class="aside-store-qty__para">Top Sales</p>
                                        <p class="aside-store-qty__number">{{ $user->getSalesCount() }}</p>
                                    </div>
                                    <div class="col-xs-6 no-pad">
                                        <p class="aside-store-qty__para">Top Sales</p>
                                        <p class="aside-store-qty__number">&pound;{{ formatPrice($user->getSalesTotal()) }}</p>
                                    </div>
                                </div>

                                <div class="aside-store-category">
                                    <ul class="list">
                                        <li class="item"><a href="{{ route('view.user.designs') }}">All ({{ $designsTotalCount }})</a></li>
                                        @foreach ($categories as $category)
                                        <li class="item"><a href="{{ route('view.user.category.designs', ['categoryId' => $category->id]) }}">{{ $category->title }} ({{ $user->getCategoryDesignsCount($category->id) }})</a></li>
                                        @endforeach
                                        <li class="item"><a href="{{ route('view.user.category.designs', ['categoryId' => 'not-for-sale']) }}">Not For Sale ({{ $designsNotForSaleCount }})</a></li>
                                    </ul>
                                </div>
                            </aside>
                            <div class="hidden-sm hidden-xs">
                                @include('includes.blog-article-aside', ['articles' => getBlogArticles(2)])
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 boot-style">
                        <!-- FEATURED BANNER -->
                        <div class="col-md-12 clearfix no-pad">
                            <section class="border-featured-banner">
                                <div class="featured-banner featured-banner--designs" style="background-image: url('{{ asset($shop->getHeaderImagePath()) }}');">
                                    <h1 class="featured-banner__hdr minor">My Studio</h1>
                                </div>
                            </section>
                        </div>

                        <!-- LATEST DESIGNS -->
                        <div class="col-md-12 clearfix no-pad">
                            <section class="design-approvals">
                                <h2 class="design-approvals__hdr hdr-section">Latest Designs</h2>
                                <a href="{{ route('view.user.designs') }}" class="link-side">View all</a>
                                <div class="row no-mar">

                                    @foreach ($latestDesigns as $design)
                                    <div class="col-lg-3 col-sm-6 boot-style">
                                        <div class="products-grid-tile approvals">

                                            <div class="product-thumbnail" style="background-image: url('{{ asset($design->getThumbnailImagePath()) }}');"></div>

                                            <div class="hover">
                                                <div class="vertical-outer">
                                                    <div class="vertical-inner">

                                                        <div class="hover__left">
                                                            <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $design->getFavouritesCount() }}
                                                        </div>
                                                        <div class="js-container-magnific hover__right">
                                                            <a href="{{ asset($design->getWatermarkImagePath()) }}" title="{{ $design->getDesignerCopyrightText() }}">
                                                                <img src="{{ asset('images/svgs/magnify.svg') }}" alt="Magnify" />Quick Look
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="info approvals">
                                                <div class="approvals-top">
                                                    <p class="approvals-top__type">{{ $design->title }}</p>
                                                </div>

                                                <div class="approvals-bottom clearfix">
                                                    <div class="col-xs-7 clearfix no-pad">
                                                        <p class="approvals-bottom__status {{ $design->getStatusClass() }}"></p>
                                                    </div>
                                                    <div class="col-xs-5 clearfix no-pad">
                                                        <form class="delete-form" method="POST" action="{{ route('view.delete.design', ['id' => $design->id]) }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button class="approvals-bottom__btn btn-primary" type="submit"><span>Delete</span></button>
                                                        </form>
                                                        <a href="{{ route('view.edit.design', ['id' => $design->id]) }}" class="approvals-bottom__btn btn-primary margin-top"><span>Edit</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </section>
                        </div>

                        <!-- MY FAVORITES -->
                        <div class="col-md-12 clearfix no-pad">
                            <div class="products-grid-likes no-top-link add-pad">
                                <section class="products-grid">
                                    <h2 class="design-approvals__hdr hdr-section">My Favorites</h2>
                                    <a href="{{ route('view.user.favorites') }}" class="link-side">View all</a>
                                    <div class="row no-mar">

                                        @foreach ($favouriteDesigns as $favouriteDesign)
                                        <div class="col-lg-3 col-xs-6 boot-style">
                                            <div class="products-grid-tile">

                                                @if ($favouriteDesign->design->isShoppable())
                                                    <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $favouriteDesign->design->identifier]) }}"></a>
                                                @endif

                                                <div class="product-thumbnail height-xs-full" style="background-image: url('{{ asset($favouriteDesign->design->getThumbnailImagePath()) }}');"></div>

                                                <div class="hover">
                                                    <div class="vertical-outer">
                                                        <div class="vertical-inner">

                                                            <div class="hover__left">
                                                                @if ($favouriteDesign->design->isFavouriteable())
                                                                <a class="btn-favourite-design @if ($favouriteDesign->design->hasfavourited()) active @endif" href="{{ route('favourite.design', ['id' => $favouriteDesign->design->id]) }}">
                                                                    @if ($favouriteDesign->design->hasfavourited())
                                                                    <img src="{{ asset('images/svgs/heart-red.svg') }}" alt="Favourite Design" />
                                                                    @else
                                                                    <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />
                                                                    @endif
                                                                    <span>{{ $favouriteDesign->design->getFavouritesCount() }}</span>
                                                                </a>
                                                                @else
                                                                <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $favouriteDesign->design->getFavouritesCount() }}
                                                                @endif
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
                            </div>
                        </div>

                        <!-- RECOMMENDED PRODUCTS -->
                        <div class="col-md-12 clearfix no-pad">
                            <div class="products-grid-likes no-top-link add-pad">
                                <section class="products-grid">
                                    <h2 class="design-approvals__hdr hdr-section">Recommended Products</h2>
                                    <a href="{{ route('view.shop.all', ['filter' => 'most-popular']) }}" class="link-side">View all</a>
                                    <div class="row no-mar">

                                        @foreach ($recommendedDesigns as $design)
                                        <div class="col-lg-3 col-xs-6 boot-style">
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
                                                                <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $design->getFavouritesCount() }}
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
                                                        <a class="tablet-magnify hidden" href="{{ asset('images/pattern1.png') }}"><img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/magnify.svg') }}" /></a>
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
                                </section>
                            </div>
                        </div>

                        <!-- TWO COLUMN AREA -->
                        <div class="col-md-12 clearfix no-pad">
                            <div class="bottom-two-col" data-match="container-not-tablet">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="fancy-button" data-match="height">
                                            <h2 class="fancy-button__hdr hdr-section">Order History</h2>

                                            @if (count($recentOrders) > 0)
                                                @foreach ($recentOrders as $order)
                                                <p class="fancy-button__sub-para"><span>Order # </span>{{ $order->friendly_id }}</p>
                                                <p class="fancy-button__sub-para"><span>Amount </span>{{ $order->getCurrency()->symbol . formatPrice($order->amount) }}</p>
                                                <p class="fancy-button__sub-para"><span>Date </span>{{ formatDate($order->created_at) }}</p>
                                                @endforeach
                                                <a href="{{ route('view.orders') }}" class="fancy-button__btn btn-primary btn-primary--minor"><span>View All</span></a>
                                            @else
                                            <img class="fancy-button__img" src="{{ asset('images/fancy-btn.png') }}" alt="You don't have any orders yet..." />
                                            <p class="fancy-button__para">Get out there and create something!</p>
                                            <a href="{{ route('view.design.upload') }}" class="fancy-button__btn btn-primary btn-primary--minor"><span>Get Started</span></a>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="hidden-sm hidden-xs">
                                        <div class="col-md-6">
                                            <div class="social-box" data-match="height">
                                                <h2 class="social-box__hdr">Connect with us</h2>
                                                <p class="social-box__para">Follow us on social media to discover inspiring projects and how-tos, and to share your thoughts and ideas with us. Participate in our weekly Design Challenge by submitting an entry, or voting for your favorite prints.<br /><br />
                                                    Browse the marketplace and connect with indie designers by favoriting or commenting on designs you love. Watch how the connections you make inspire, support and spark your creativity!</p>
                                                <div class="social-container">
                                                    <a href="{{ getSettingValue('social_media/facebook_link') }}" class="btn-social fb"></a>
                                                    <a href="{{ getSettingValue('social_media/twitter_link') }}" class="btn-social tw"></a>
                                                    <a href="{{ getSettingValue('social_media/pinterest_link') }}" class="btn-social pn"></a>
                                                    <a href="{{ getSettingValue('social_media/google_plus_link') }}" class="btn-social in"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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