@section('page_title', 'My Account - Orders')
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
                            @include('includes.flash')
                            <section class="order-sales">

                                <div class="order-sales-head">
                                    <ul class="list">
                                        <li class="item item--orders"><a class="active" href="{{ route('view.orders') }}">My Orders</a></li>
                                        <li class="item item--sales"><a href="{{ route('view.orders.sales') }}">My Sales</a></li>
                                    </ul>
                                </div>

                                @if (count($orders) > 0)
                                <div class="row order-list">
                                    <div class="col-md-9 col-xs-12">
                                        @foreach ($orders as $order)
                                        <div class="order-process">
                                            <div class="single">
                                                <div class="order-process-head">
                                                    <div class="row">
                                                        <div class="col-xs-6 col-sm-3 boot-style">
                                                            <div class="head-col">
                                                                <h3 class="head-col__hdr">Order Placed</h3>
                                                                <time class="head-col__subhdr">{{ formatDate($order->created_at, 'd F Y') }}</time>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-2 boot-style">
                                                            <div class="head-col">
                                                                <h3 class="head-col__hdr">Total</h3>
                                                                <p class="head-col__subhdr">{{ $order->getCurrency()->symbol . formatPrice($order->getTotalAmount()) }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-0 col-sm-2 boot-style">
                                                            <div class="head-col head-col--dispatch">
                                                                <h3 class="head-col__hdr">Dispatch to</h3>
                                                                <p class="head-col__subhdr">{{ $order->shippingAddress->getFullName() }}</p>
                                                            </div>	
                                                        </div>
                                                        <div class="col-xs-12 col-sm-5 boot-style">
                                                            <div class="head-col head-col--orders">
                                                                <h3 class="head-col__hdr">Order Number #{{ $order->friendly_id }}</h3>
                                                                <span class="head-col__dropdown hidden">Order Details</span>
                                                                <a href="{{ route('print.order', ['friendlyId' => $order->friendly_id]) }}" class="head-col__link" target="_blank">Invoice</a>
                                                            </div>	
                                                        </div>			                    						
                                                    </div>                    						
                                                </div>
                                                <div class="order-process-body">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <h3 class="order-process-body__hdr hdr-section--minor {{ $order->getStatusClass() }}">Order {{ $order->getStatus() }} - {{ formatDate($order->created_at, 'd F Y') }}</h3>
                                                            <p class="order-process-body__shipping-method">Shipping Method - {{ $order->shippingAddress->branding->title }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8">
                                                            <div class="order-process-details">
                                                                @foreach ($order->orderItems as $item)
                                                                <div class="single-desc js-container-magnific">
                                                                    @if ($item->isColourAtlas())
                                                                    <a href="{{ asset(getColourAtlasImagePath()) }}">
                                                                        <div class="order-process-details__img magnify-hover" style="background-image: url('{{ asset(getColourAtlasImagePath()) }}');"></div>
                                                                    </a>
                                                                    @elseif ($item->isSampleBook())
                                                                    <a href="{{ asset(getSampleBookImagePath()) }}">
                                                                        <div class="order-process-details__img magnify-hover" style="background-image: url('{{ asset(getSampleBookImagePath()) }}');"></div>
                                                                    </a>
                                                                    @elseif ($item->isPlainFabric())
                                                                    <a href="{{ asset(getPlainFabricImagePath()) }}">
                                                                        <div class="order-process-details__img magnify-hover" style="background-image: url('{{ asset(getSampleBookImagePath()) }}');"></div>
                                                                    </a>
                                                                    @else
                                                                    <a href="{{ asset($item->design->getWatermarkImagePath()) }}" title="{{ $item->design->getDesignerCopyrightText() }}">
                                                                        <div class="order-process-details__img magnify-hover" style="background-image: url('{{ asset($item->design->getThumbnailImagePath()) }}');"></div>
                                                                    </a>
                                                                    @endif
                                                                    <div class="description">
                                                                        <ul class="list">
                                                                            <li class="item">{{ $item->product->title }}</li>
                                                                            @if ($item->isDesign())
                                                                            <li class="item">{{ $item->material->title . ' (' . $item->product->width_text . ' x ' . $item->product->height_text . ')' }}</li>
                                                                            <li class="item">{{ $item->getRepeatType() }}, DPI - {{ $item->getDpi() }}</li>
                                                                            <li class="item">Design Number: #{{ $item->design->friendly_id }}</li>
                                                                            @elseif ($item->isColourAtlas() || $item->isPlainFabric())
                                                                            <li class="item">{{ $item->material->title }}</li>
                                                                            @endif
                                                                            <li class="item">SKU - {{ $item->product->sku }} - {{ $order->getCurrency()->symbol . formatPrice($item->unit_price) }}</li>
                                                                        </ul>
                                                                        @if ($item->isColourAtlas())
                                                                        <a href="{{ route('view.shop.colour.atlas') }}" class="description__link btn-primary btn-primary--minor"><span>Buy it again</span></a>
                                                                        @elseif ($item->isSampleBook())
                                                                        <a href="{{ route('view.shop.sample.books') }}" class="description__link btn-primary btn-primary--minor"><span>Buy it again</span></a>
                                                                        @elseif ($item->isPlainFabric())
                                                                        <a href="{{ route('view.shop.plain.fabrics') }}" class="description__link btn-primary btn-primary--minor"><span>Buy it again</span></a>
                                                                        @else
                                                                        <a href="{{ route('view.shop.design', ['designIdentifier' => $item->design->identifier]) }}" class="description__link btn-primary btn-primary--minor"><span>Buy it again</span></a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-4 boot-style">
                                                            <div class="order-process-cta">
                                                                @if ($order->isDispatched())
                                                                    @if ($order->isTrackable())
                                                                    <a href="{{ $order->getTrackingLink() }}" data-id="order-tracking-popup" data-tracking-number="{{ $order->tracking_number }}" class="order-process-cta__btn btn-primary btn-primary--minor js-popup-btn"><span>Track Package</span></a>
                                                                    @else
                                                                    <a href="#" data-id="order-no-tracking-popup" class="order-process-cta__btn btn-primary btn-primary--minor js-popup-btn"><span>Track Package</span></a>
                                                                    @endif
                                                                @endif
                                                                <a href="{{ route('view.faqs') }}" class="order-process-cta__btn btn-tertiary btn-tertiary--options"><span>Return or replace items</span></a>
                                                                <a href="{{ route('feedback.order', ['id' => $order->id]) }}" data-id="order-feedback-popup" class="order-process-cta__btn btn-tertiary btn-tertiary--options js-popup-btn"><span>Leave package | delivery feedback</span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="products-grid-pagination pagination--list">
                                            <div class="pagination">
                                                {!! $orders->render() !!}
                                            </div>
                                        </div>
                                    </div> <!-- col-md-9 col-xs-12 -->

                                    <div class="col-md-3 col-xs-0">
                                        <aside class="aside-bordered">
                                            <h2 class="aside-bordered__hdr hdr-section">Popular Designs</h2>
                                            @foreach ($popularDesigns as $design)
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
                                                    <div class="info-right hidden">
                                                        <!-- Mobile & Tablet Only -->
                                                        <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{'images/svgs/heart.svg'}}" />
                                                        <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{'images/svgs/magnify.svg'}}" />
                                                        <!---->
                                                        <img class="info-right__img" src="{{ 'images/svgs/cart.svg' }}" />
                                                        <img class="info-right__img--bg" src="{{'images/svgs/cart-highlight.svg'}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </aside>
                                    </div>
                                </div>

                                @else
                                <div class="order-sales-empty">
                                    <h2 class="order-sales-empty__hdr hdr-section">You Don't Have Any Orders Yet</h2>
                                    <p class="order-sales-empty__para">Maybe you want to Checkout Products from your Basket?</p>
                                    <a href="{{ route('view.basket') }}" class="order-sales-empty__btn btn-primary"><span>Go to basket</span></a>
                                </div>

                                <div class="separator">OR</div>

                                <div class="latest-products">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p class="latest-products__para">You may be interested in these Products:</p>
                                            <section class="latest-products-carousel">

                                                <div class="sly-carousel" data-controls-outside="true" data-cycle-by="pages" style="overflow: hidden;">
                                                    <div class="sly-content item-carousel clearfix">
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
                                                <button class="sly-next sly-next--dark disabled" type="button"></button>
                                            </section>	

                                            <a href="{{ route('view.orders.sales') }}" class="latest-products__btn btn-primary"><span>My Sales</span></a>

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

<div class="js-popup popup order-feedback-popup">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-10">
                <h2 class="upload-popup__hdr hdr-section--minor">Submit your feedback</h2>
            </div>
            <div class="col-xs-2">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row">
            <form id="order-feedback-form" method="POST" action="" autocomplete="off">
                {{ csrf_field() }}
                <input id="rating" type="hidden" name="rating" />
                <div class="upload-popup-fields clearfix">
                    <div class="col-xs-12">
                        <textarea name="comment" class="comments-form__textarea report-textarea" cols="30" rows="7" placeholder="Write your comment"></textarea>
                    </div>
                </div>
                <div class="upload-popup-fields clearfix">
                    <div class="col-xs-12 text-center">
                        <div class="star-label" data-id="1"></div>
                        <div class="star-label" data-id="2"></div>
                        <div class="star-label" data-id="3"></div>
                        <div class="star-label" data-id="4"></div>
                        <div class="star-label" data-id="5"></div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <button type="submit" class="upload-popup__send btn-primary btn-primary--minor"><span>Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="js-popup popup order-no-tracking-popup">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-10">
                <h2 class="upload-popup__hdr hdr-section--minor">Track your package</h2>
            </div>
            <div class="col-xs-2">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row">
            <div class="upload-popup-fields clearfix"></div>
            <div class="col-xs-12 text-center">
                <p>Unfortunately this feature is not available for this order.</p>
            </div>
        </div>
    </div>
</div>

<div class="js-popup popup order-tracking-popup">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-10">
                <h2 class="upload-popup__hdr hdr-section--minor">Track your package</h2>
            </div>
            <div class="col-xs-2">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row">
            <div class="upload-popup-fields clearfix"></div>
            <div class="col-xs-12 text-center">
                <p>To track your package copy the unique tracking number and follow the link provided below.</p>
            </div>
            <div class="upload-popup-fields clearfix"></div>
            <div class="col-xs-12 text-center">
                <span class="tracking-number"></span>
            </div>
            <div class="upload-popup-fields clearfix"></div>
            <div class="col-xs-12">
                <a id="tracking-link" href="" class="upload-popup__send btn-primary btn-primary--minor" target="_blank"><span>Visit Link</span></a>
            </div>
        </div>
    </div>
</div>

@include('includes.footer')
@stop

@section('end_body')
<script type="text/javascript">
    $(function() {
        $('.star-label').click(function() {
            var $star = $(this);
            if ($star.hasClass('active')) {
                $('.star-label').removeClass('active');
                $('#rating').val('');
            } else {
                $('#rating').val($star.data('id'));
                $('.star-label').each(function(index) {
                    var $this = $(this);
                    if (index < $star.data('id')) {
                        $this.addClass('active');
                    } else {
                        $this.removeClass('active');
                    }
                });
            }
        });
    });
</script>
@stop