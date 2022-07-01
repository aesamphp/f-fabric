@section('page_title', 'Your Basket')
@section('page_class', 'page-your-basket')

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
                            <h1 class="featured-banner__hdr">Your Basket</h1>
                        </section>
                    </div>
                </div>

                <div class="section-fill main-content-area">

                    <!-- MY SHOPPING BASKET -->
                    <div class="row">
                        <div class="col-xs-12">
                            <section class="shopping">
                                @include('includes.flash')
                                <h2 class="shopping__hdr hdr-section">My Shopping Basket: ({{ getBasketItemsCount() }} Items)</h2>

                                    <div class="shopping-basket">
                                        <div class="head">
                                            <div class="row single-row">
                                                <div class="col-xs-1">
                                                    <div class="head-col image">
                                                        <div class="head-col first">Product</div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-11">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                        </div>
                                                        <div class="col-xs-5 col-sm-3 col-md-4">
                                                            <div class="head-col second">Quantity</div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="head-col third">Type</div>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <div class="head-col fourth">Total</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="body">
                                            @foreach ($basket as $item)
                                                @if (isBasketItemAColourAtlas($item))
                                                    @include('basket.item-colour-atlas')
                                                @elseif (isBasketItemASampleBook($item))
                                                    @include('basket.item-sample-book')
                                                @elseif (isBasketItemAPlainFabric($item))
                                                    @include('basket.item-plain-fabric')
                                                @else
                                                    @if (isBasketItemASavedDesign($item))
                                                        @include('basket.item-row')
                                                    @else
                                                        @include('basket.item-tmp-row')
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                            </section>
                        </div>
                    </div>

                    <div class="row">

                        <!-- PROMOTIONAL CODE -->
                        <div class="col-md-6 col-sm-7">
                            <div class="promo-code">
                                <h2 class="promo-code__hdr hdr-section">Add promotional code</h2>
                                <div class="promo-code-inner">
                                    @if (isDiscountApplied())
                                    <p class="promo-code-inner__para">The promo code below is applied to your basket</p>
                                    <form class="delete-form" method="POST" action="{{ route('delete.basket.discount') }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <div class="row">
                                            <div class="col-xs-8 boot-style">{{ getAppliedDiscountCode()->code }}</div>
                                            <div class="col-xs-4">
                                                <button class="promo-code-inner__btn btn-secondary btn-secondary--gray" type="submit"><span>Remove</span></button>
                                            </div>
                                        </div>
                                    </form>
                                    @else
                                    <p class="promo-code-inner__para">If you have a promo code, please enter it here:</p>
                                    <form method="POST" action="{{ route('apply.basket.discount') }}" autocomplete="off">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-xs-8 boot-style">
                                                <input class="promo-code-inner__input field-secondary" type="text" name="promo_code" value="{{ old('promo_code') }}" placeholder="Promotional Code" />
                                            </div>
                                            <div class="col-xs-4">
                                                <button class="promo-code-inner__btn btn-secondary btn-secondary--gray" type="submit"><span>Apply</span></button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                                <a href="{{ route('view.shop') }}" class="promo-code__link link-back-major">Continue shopping</a>
                            </div>
                        </div>

                        <!-- GRAND TOTAL -->
                        <div class="col-md-6 col-sm-5">
                            <div class="grand-total">
                                <div class="row">
                                    <div class="col-xs-6 boot-style-1">
                                        <p class="grand-total__title">Sub Total:</p>
                                    </div>
                                    <div class="col-xs-6 boot-style-2">
                                        <p class="grand-total__expense">{{ getCurrentCurrencySymbol() . $subTotal }}</p>
                                    </div>
                                </div>
                                @if (isDiscountApplied())
                                <div class="row">
                                    <div class="col-xs-6 boot-style-1">
                                        <p class="grand-total__title">Discount:</p>
                                    </div>
                                    <div class="col-xs-6 boot-style-2">
                                        <p class="grand-total__expense">&ndash; {{ getCurrentCurrencySymbol() . getDiscountAmount(false, true) }}</p>
                                    </div>
                                </div>
                                @endif
                                @if (hasShippingPrice())
                                <div class="row">
                                    <div class="col-xs-6 boot-style-1">
                                        <p class="grand-total__title">Delivery:</p>
                                    </div>
                                    <div class="col-xs-6 boot-style-2">
                                        <p class="grand-total__expense">{{ getPriceText(getShippingNetPrice(true), getCurrentCurrencySymbol()) }}</p>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-xs-6 boot-style-1">
                                        <p class="grand-total__title">VAT:</p>
                                    </div>
                                    <div class="col-xs-6 boot-style-2">
                                        <p class="grand-total__expense">{{ getCurrentCurrencySymbol() . $vat }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p class="grand-total__grand-expense">Cart Total: <span>{{ getCurrentCurrencySymbol() . $total }}</span></p>
                                        <a href="{{ route('view.checkout.billing.address') }}" class="grand-total__checkout btn-primary btn-primary--no-border--thick"><span>Checkout Securely</span></a>
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