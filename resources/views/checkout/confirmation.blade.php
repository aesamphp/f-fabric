@section('page_title', 'Order Confirmation')
@section('page_class', 'page-confirmation')

@section('js')
    <script type=text/javascript
            src="https://services.xg4ken.com/js/kenshoo.js?cid=35b61595-d2d4-4818-9541-09beabd058d2"></script>
    <script type=text/javascript>
        kenshoo.trackConversion('5035', '35b61595-d2d4-4818-9541-09beabd058d2',
            {
                conversionType: 'purchase', /*specific conversion type*/
                revenue: '{{ $order->getSubtotalAmount() }}', /*conversion value ecommerce expression*/
                currency: 'GBP', /*currency ecommerce expression*/
                orderId: '{{ $order->id }}', /*order Id ecommerce expression*/
                promoCode: '{{ $order->hasDiscount() ? $order->getDiscountCode() : '' }}', /*promo code ecommerce expression*/
                customParamN: ''
            });
    </script>
    <noscript>
    <img src="https://5035.xg4ken.com/pixel/v1?track=1&
    token=35b61595-d2d4-4818-9541-09beabd058d2&
    conversionType=purchase&
    revenue={{ $order->getSubtotalAmount() }}&
    currency=GBP&
    orderId={{ $order->id }}&
    promoCode={{ $order->hasDiscount() ? $order->getDiscountCode() : '' }}"
     width="1" height="1"/></noscript><!--End of Yell PPC Plus Tag for Purchase Conversion Page -->
@stop

@extends('layouts.master')

@section('content')
    @include('includes.mobile-nav')
    @include('includes.header')

    <main>

        <div class="container container-global">
            <div class="row">

                <div class="col-xs-12 container-dotted-pattern no-pad">

                    <!-- FEATURED BANNER -->
                    <div class="row">
                        <div class="col-xs-12">
                            <section class="featured-banner featured-banner--basket no-title">
                                <h1 class="featured-banner__hdr">Confirmation</h1>
                            </section>
                        </div>
                    </div>

                    <!-- CHECKOUT -->
                    <div class="checkout">
                        <div class="row">
                            <div class="col-xs-12">
                                <section class="thank-you">
                                    <a href="{{ route('print.order', ['friendlyId' => $order->friendly_id]) }}"
                                       class="thank-you__print" target="_blank">Print your order</a>
                                    <h2 class="thank-you__hdr">Thank you!</h2>
                                    <p class="thank-you__para">YOUR ORDER HAS BEEN SUCCESSFULLY PLACED.<br/>ORDER
                                        reference NUMBER #{{ $order->friendly_id }}</p>
                                    <a href="{{ route('view.shop.all') }}"
                                       class="thank-you__btn btn-primary btn-primary--no-border--thick"><span>Continue Shopping</span></a>
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">

                                <section class="checkout-input padded-dotted-line">
                                    <div class="row">
                                        <div class="order-details-row col-sm-12 col-md-6 clearfix no-pad">
                                            <div class="col-sm-6">
                                                <address class="order-details">

                                                    <p class="order-details__hdr hdr-section--minor">Date Placed</p>
                                                    <ul class="list">
                                                        <li class="item">{{ formatDate($order->created_at, 'd/m/Y \a\t H:i') }}</li>
                                                    </ul>

                                                </address>
                                            </div>

                                            <div class="col-sm-6">
                                                <address class="order-details">

                                                    <p class="order-details__hdr hdr-section--minor">Payment Details</p>
                                                    <ul class="list">
                                                        <li class="item">{{ getCardType($payment->cardType) }}</li>
                                                        <li class="item">{{ $payment->cardHolder }}</li>
                                                        <li class="item">{{ encryptCardNumber($payment->cardNumber) }}</li>
                                                        <li class="item">{{ formatCardExpiryDate($payment->expiryDate) }}</li>
                                                    </ul>

                                                </address>
                                            </div>
                                        </div>

                                        <div class="order-details-row col-sm-12 col-md-6 clearfix no-pad">
                                            <div class="col-sm-6">
                                                <address class="order-details">

                                                    <p class="order-details__hdr hdr-section--minor">Delivery
                                                        Address</p>
                                                    {!! formatAddress($order->shippingAddress, $order->getAddressAttributes()) !!}

                                                </address>
                                            </div>

                                            <div class="col-sm-6">
                                                <address class="order-details">

                                                    <p class="order-details__hdr hdr-section--minor">Billing Address</p>
                                                    {!! formatAddress($order->billingAddress, $order->getAddressAttributes()) !!}

                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 boot-style-order-basket">
                                <section class="shopping">

                                    <div class="shopping-delivery-type"><span>{{ $order->shippingAddress->branding->title }}
                                            -</span> Delivered within 3-5 working days
                                    </div>

                                    <div class="shopping-basket">
                                        <div class="head">
                                            <div class="row single-row">
                                                <div class="col-xs-1">
                                                    <div class="head-col image">
                                                        <div class="head-col first">Product</div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-11">
                                                    <div class="row no-mar">
                                                        <div class="col-xs-4 col-sm-5">
                                                        </div>
                                                        <div class="col-xs-3 col-sm-3 col-md-3">
                                                            <div class="head-col second">Price</div>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <div class="head-col third" style="display:block;">
                                                                Quantity
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-3 col-sm-2">
                                                            <div class="head-col fourth">Total</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="js-container-magnific body">
                                            @foreach ($order->orderItems as $item)
                                                <div class="row single-row">
                                                    <div class="col-xs-1 boot-style">
                                                        <div class="body-col image">
                                                            @if ($item->isColourAtlas())
                                                                <a href="{{ asset(getColourAtlasImagePath()) }}">
                                                                    <div class="thumb-image-contain"
                                                                         style="background-image:url({{ asset(getColourAtlasImagePath()) }});"></div>
                                                                </a>
                                                            @elseif ($item->isSampleBook())
                                                                <a href="{{ asset(getSampleBookImagePath()) }}">
                                                                    <div class="thumb-image-contain"
                                                                         style="background-image:url({{ asset(getSampleBookImagePath()) }});"></div>
                                                                </a>
                                                            @elseif ($item->isPlainFabric())
                                                                <a href="{{ asset(getPlainFabricImagePath()) }}">
                                                                    <div class="thumb-image-contain"
                                                                         style="background-image:url({{ asset(getPlainFabricImagePath()) }});"></div>
                                                                </a>
                                                            @else
                                                                <a href="{{ asset($item->design->getWatermarkImagePath()) }}">
                                                                    <div class="thumb-image-contain"
                                                                         style="background-image: url('{{ asset($item->design->getThumbnailImagePath()) }}');"></div>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-11">
                                                        <div class="row row-minus-25">
                                                            <div class="col-xs-5">
                                                                <div class="body-col first">
                                                                    <div class="row">
                                                                        <div class="col-xs-12">
                                                                            <div class="body-col-textarea">
                                                                                <p class="body-col-textarea__item">{{ $item->product->title }}</p>
                                                                                @if ($item->isDesign())
                                                                                    <p class="body-col-textarea__type">{{ $item->getRepeatType() . ' ' . $item->material->title . ' (' . $item->product->width_text . ' x ' . $item->product->height_text . ')' }}</p>
                                                                                    <p class="body-col-textarea__code">
                                                                                        DPI - {{ $item->getDpi() }}</p>
                                                                                    <p class="body-col-textarea__code">
                                                                                        Design Number:
                                                                                        #{{ $item->design->friendly_id }}</p>
                                                                                @elseif ($item->isColourAtlas() || $item->isPlainFabric())
                                                                                    <p class="body-col-textarea__type">{{ $item->material->title }}</p>
                                                                                @endif
                                                                                <p class="body-col-textarea__code">SKU
                                                                                    - {{ $item->product->sku }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-3 col-md-3">
                                                                <div class="body-col second">
                                                                    <p class="body-col__type">{{ $order->getCurrency()->symbol . formatPrice($item->unit_price) }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <div class="body-col third" style="display: block;">
                                                                    <p class="body-col__qty">{{ $item->quantity }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-2 col-sm-2">
                                                                <div class="body-col fourth">
                                                                    <p class="body-col__total">{{ $order->getCurrency()->symbol . formatPrice($item->getPrice()) }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <a href="{{ route('home') }}" class="confirm-back link-back-major">Return Home</a>
                            </div>

                            <!-- GRAND TOTAL -->
                            <div class="col-xs-12 col-sm-6">


                                <div class="grand-total grand-total--order-review">

                                    <div class="row">
                                        <div class="col-xs-6 boot-style-1">
                                            <p class="grand-total__title">Sub Total:</p>
                                        </div>
                                        <div class="col-xs-6 boot-style-2">
                                            <p class="grand-total__expense">{{ $order->getCurrency()->symbol . formatPrice($order->getSubtotalAmount()) }}</p>
                                        </div>
                                    </div>
                                    @if ($order->hasDiscount())
                                        <div class="row">
                                            <div class="col-xs-6 boot-style-1">
                                                <p class="grand-total__title">Discount:</p>
                                            </div>
                                            <div class="col-xs-6 boot-style-2">
                                                <p class="grand-total__expense">
                                                    &ndash; {{ $order->getCurrency()->symbol . formatPrice($order->getDiscountAmount()) }}
                                                    <br/>{{ $order->getDiscountCode() }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-xs-6 boot-style-1">
                                            <p class="grand-total__title">Delivery:</p>
                                        </div>
                                        <div class="col-xs-6 boot-style-2">
                                            <p class="grand-total__expense">{{ getPriceText($order->getShippingAmount(), $order->getCurrency()->symbol) }}</p>
                                        </div>
                                    </div>
                                    @if ($order->hasVAT())
                                        <div class="row">
                                            <div class="col-xs-6 boot-style-1">
                                                <p class="grand-total__title">VAT:</p>
                                            </div>
                                            <div class="col-xs-6 boot-style-2">
                                                <p class="grand-total__expense">{{ $order->getCurrency()->symbol . formatPrice($order->vat) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($order->surcharge > 0)
                                        <div class="row">
                                            <div class="col-xs-6 boot-style-1">
                                                <p class="grand-total__title">Surcharge:</p>
                                            </div>
                                            <div class="col-xs-6 boot-style-2">
                                                <p class="grand-total__expense">{{ $order->getCurrency()->symbol . formatPrice($order->surcharge) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p class="grand-total__grand-expense">Cart Total:
                                                <span>{{ $order->getCurrency()->symbol . formatPrice($order->getTotalAmount()) }}</span>
                                            </p>
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

    <script type="text/javascript"
            src="https://tag.mention-me.com/api/v2/referreroffer/mm4ff24c87?implementation=popup&email={!! urlencode($user->email) !!}&order_number={{ $order->id }}&order_total={{ formatPrice($order->getSubtotalAmount()) }}&order_currency=GBP&situation=postpurchase&firstname={{ $user->first_name }}&surname={{ $user->last_name }}&customer_id={{ $user->id }}&locale=en_GB"></script>

    @include('includes.footer')
@stop