@section('page_title', 'My Account - Sales')
@section('page_class', 'page-orders-and-sales')

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
                            <section class="featured-banner featured-banner--basket no-title">
                                <h1 class="featured-banner__hdr">My Account - Orders &amp; Sales</h1>
                            </section>
                        </div>
                    </div>

                    <!-- ORDERS AND SALES -->
                    <div class="row">
                        <div class="col-xs-12">

                            <section class="order-sales">

                                <div class="order-sales-head">
                                    <ul class="list">
                                        <li class="item item--orders"><a href="{{ route('view.orders') }}">My Orders</a></li>
                                        <li class="item item--sales"><a class="active" href="{{ route('view.orders.sales') }}">My Sales</a></li>
                                    </ul>
                                </div>

                                @if (count($sales) > 0)

                                    <div class="global-container-order-list js-container-magnific">
                                        <div class="container-order-header">
                                            <div class="order-list">
                                                <div class="order-list-item">
                                                    <div class="row boot-style-row order-summation">

                                                        <div class="col-xs-12 col-md-12 boot-style boot-style-first">
                                                            <h3> This is a summation of your sales : </h3>
                                                        </div>

                                                        <div class="col-xs-12 col-md-12 boot-style boot-style-first">
                                                            This Month : {{ getCurrentCurrencySymbol() . $monthTotal ? $monthTotal : '0.00' }}
                                                        </div>

                                                        <div class="col-xs-12 col-md-12 boot-style boot-style-first">
                                                            Last Month : {{ getCurrentCurrencySymbol() . $lastMonthTotal ? $lastMonthTotal : '0.00' }}
                                                        </div>

                                                        <div class="col-xs-12 col-md-12 boot-style boot-style-first">
                                                            All Time   :{{ getCurrentCurrencySymbol() . $totalCommissions ? $totalCommissions : '0.00' }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="global-container-order-list js-container-magnific">

                                    @foreach ($sales as $sale)
                                    <div class="container-order-list">
                                        <div class="order-list">
                                            <div class="order-list-head">
                                                <div class="row boot-style-row">
                                                    <div class="col-xs-3 col-md-4 boot-style boot-style-first">
                                                        <div class="order-list-head__title order-list-head__title--prod">Product</div>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-2 col-md-2 boot-style">
                                                        <div class="order-list-head__title">Order Number</div>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-2 col-md-2 boot-style">
                                                        <div class="order-list-head__title">Commission Status</div>
                                                        <div class="js-dropdown-container hidden">
                                                            <div class="js-dropdown order-list-head__title order-list-head__title--sort"><p>Commission Status</p></div>
                                                            <div class="js-sort sort">
                                                                <p class="sort__hdr">Sort as:</p>
                                                                <div class="sort__check checkbox-container">
                                                                    <input name="sort" type="radio" value="1" />
                                                                    <span class="checkbox-overlay"></span>
                                                                    <span class="checkbox-text">Pending</span>
                                                                </div>
                                                                <div class="sort__check checkbox-container">
                                                                    <input name="sort" type="radio" value="1" />
                                                                    <span class="checkbox-overlay"></span>
                                                                    <span class="checkbox-text">Declined</span>
                                                                </div>
                                                                <div class="sort__check checkbox-container">
                                                                    <input name="sort" type="radio" value="1" />
                                                                    <span class="checkbox-overlay"></span>
                                                                    <span class="checkbox-text">Approved</span>
                                                                </div>
                                                                <div class="sort__check checkbox-container">
                                                                    <input name="sort" type="radio" value="1" />
                                                                    <span class="checkbox-overlay"></span>
                                                                    <span class="checkbox-text">Paid</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3 col-md-2 boot-style">
                                                        <div class="order-list-head__title">Commission Earned</div>
                                                    </div>
                                                    <div class="col-xs-0 col-sm-2 col-md-2 boot-style">
                                                        <div class="order-list-head__title order-list-head__title--update">Last Update</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="order-list-item">
                                                <div class="row boot-style-row">
                                                    <div class="col-xs-3 col-md-4 boot-style boot-style-first">
                                                        <a href="{{ asset($sale->orderItem->design->getWatermarkImagePath()) }}" title="{{ $sale->orderItem->design->getDesignerCopyrightText() }}">
                                                            <div class="order-list-item__img magnify-hover" style="background-image: url('{{ asset($sale->orderItem->design->getThumbnailImagePath()) }}');"></div>
                                                        </a>
                                                        <div class="order-list-item__desc">
                                                            <span>{{ $sale->orderItem->design->title }} by {{ $user->username }}</span>
                                                            {{ $sale->orderItem->design->type->title . ' ' . $sale->orderItem->material->title . ' (' . $sale->orderItem->product->width_text . ' x ' . $sale->orderItem->product->height_text . ')' }} - {{ $sale->orderItem->product->sku }}
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-2 col-md-2 boot-style">
                                                        <div class="order-list-item__deats order-list-item__deats--number">#{{ $sale->orderItem->order->friendly_id }}</div>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-2 col-md-2 boot-style">
                                                        <div class="order-list-item__deats order-list-item__deats--status"><p class="{{ $sale->getStatusClass() }}">{{ $sale->getStatus() }}</p></div>
                                                    </div>
                                                    <div class="col-xs-3 col-md-2 boot-style">
                                                        <div class="order-list-item__deats order-list-item__deats--earned">{{ getCurrentCurrencySymbol() . convertPriceToCurrentCurrency($sale->amount) }}</div>
                                                    </div>
                                                    <div class="col-xs-0 col-sm-2 col-md-2 boot-style">
                                                        <div class="order-list-item__deats order-list-item__deats--update">{{ formatDate($sale->created_at, 'jS F Y') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="products-grid-pagination pagination--list">
                                    <div class="pagination">
                                        {!! $sales->render() !!}
                                    </div>
                                </div>

                                @else

                                <div class="order-sales-empty">
                                    <h2 class="order-sales-empty__hdr hdr-section">You Don't Have Any Sales Yet</h2>
                                    <p class="order-sales-empty__para">Why not add some more designs to your profile</p>
                                    <a href="{{ route('view.design.upload') }}" class="order-sales-empty__btn btn-primary"><span>Create a design</span></a>
                                </div>

                                <div class="separator">OR</div>

                                <div class="latest-products">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p class="latest-products__para">You may be interested in these Products:</p>
                                            <section class="latest-products-carousel">

                                                <div class="sly-carousel" data-controls-outside="true" data-cycle-by="pages" style="overflow: hidden;">
                                                    <div class="sly-content item-carousel clearfix" style="transform: translateZ(0px) translateX(-930px); width: 1880px;">
                                                        @foreach ($recommendedDesigns as $design)
                                                            <div class="sly-item item-carousel__list-item">
                                                                <div class="products-grid-tile">

                                                                    @if ($design->isShoppable())
                                                                        <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $design->identifier]) }}"></a>
                                                                    @endif

                                                                    <div class="product-thumbnail" style="background-image: url('{{ asset($design->getThumbnailImagePath()) }}');"></div>

                                                                    <div class="info">
                                                                        <div class="vertical-outer">
                                                                            <div class="vertical-inner">
                                                                                <div class="info-left">
                                                                                    <p class="info-left__type">{{ $design->title }}</p>
                                                                                    <p class="info-left__author">by <a href="{{ route('view.designer.store', ['username' => $design->user->studio->username]) }}">{{ $design->user->username }}</a></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="js-container-magnific info-right hidden">
                                                                            <!-- Mobile & Tablet Only -->
                                                                            <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/heart.svg') }}" />
                                                                            <a class="tablet-magnify" href="{{ asset('images/pattern1.png') }}"><img src="{{ asset('images/svgs/magnify.svg') }}" class="info-right__img info-right__img--minor hidden-md hidden-lg" /></a>
                                                                            <!---->

                                                                            <img class="info-right__img" src="{{ asset('images/svgs/cart.svg') }}" />
                                                                            <img class="info-right__img--bg" src="{{ asset('images/svgs/cart-highlight.svg') }}" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <button class="sly-prev sly-prev--dark" type="button"></button>
                                                <button class="sly-next sly-next--dark disabled" type="button" disabled=""></button>
                                            </section>

                                            <a href="{{route('view.orders')}}" class="latest-products__btn btn-primary"><span>My Orders</span></a>

                                        </div>
                                    </div>
                                </div>
                                @endif

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