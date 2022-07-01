@section('page_title', 'Order Review')
@section('page_class', 'page-order-review')


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
                        <section class="featured-banner featured-banner--details no-title">
                            <h1 class="featured-banner__hdr">Checkout</h1>
                        </section>
                    </div>
                </div>	

                <!-- CHECKOUT -->
                <div class="checkout">
                    <div class="row">
                        <div class="col-xs-12">
                            @include('checkout.steps-nav')
                        </div>
                    </div>
                    
                    @include('includes.flash')
                    
                    <div class="row">
                        <div class="col-sm-12">

                            <section class="checkout-input padded-dotted-line">
                                <h2 class="checkout-input__hdr hdr-section">Review your Order</h2>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4">
                                        <address class="order-details">

                                            <p class="order-details__hdr">Billing Address</p>
                                            <ul class="list">
                                                <li class="item">{{ $billingAddress->title . ' ' . $billingAddress->first_name . ' ' . $billingAddress->last_name }}</li>
                                                <li class="item">{{ $billingAddress->address_line1 }}</li>
                                                @if ($billingAddress->address_line2)
                                                <li class="item">{{ $billingAddress->address_line2 }}</li>
                                                @endif
                                                <li class="item">{{ $billingAddress->city }}</li>
                                                <li class="item">{{ $billingAddress->postcode }}</li>
                                                @if ($billingAddress->state)
                                                <li class="item">{{ getState($billingAddress->state)->title }}</li>
                                                @endif
                                                <li class="item">{{ getCountry($billingAddress->country)->title }}</li>
                                                @if ($billingAddress->phone)
                                                <li class="item">{{ $billingAddress->phone }}</li>
                                                @endif
                                            </ul>

                                        </address>
                                    </div>	

                                    <div class="col-xs-12 col-sm-4">
                                        <address class="order-details">

                                            <p class="order-details__hdr">Delivery Address</p>
                                            <ul class="list">
                                                <li class="item">{{ $deliveryAddress->title . ' ' . $deliveryAddress->first_name . ' ' . $deliveryAddress->last_name }}</li>
                                                <li class="item">{{ $deliveryAddress->address_line1 }}</li>
                                                @if ($deliveryAddress->address_line2)
                                                <li class="item">{{ $deliveryAddress->address_line2 }}</li>
                                                @endif
                                                <li class="item">{{ $deliveryAddress->city }}</li>
                                                <li class="item">{{ $deliveryAddress->postcode }}</li>
                                                @if ($deliveryAddress->state)
                                                <li class="item">{{ getState($deliveryAddress->state)->title }}</li>
                                                @endif
                                                <li class="item">{{ getCountry($deliveryAddress->country)->title }}</li>
                                                @if ($deliveryAddress->phone)
                                                <li class="item">{{ $deliveryAddress->phone }}</li>
                                                @endif
                                            </ul>

                                        </address>
                                    </div>	

                                    <div class="col-xs-12 col-sm-4">
                                        <address class="order-details">

                                            <p class="order-details__hdr">Payment Details</p>
                                            <ul class="list">
                                                <li class="item">{{ getCardType($payment->cardType) }}</li>
                                                @if ($payment->cardType !== 'PAYPAL')
                                                <li class="item">{{ $payment->cardHolder }}</li>
                                                <li class="item">{{ encryptCardNumber($payment->cardNumber) }}</li>
                                                <li class="item">{{ formatCardExpiryDate($payment->expiryDate) }}</li>
                                                @endif
                                            </ul>

                                        </address>
                                    </div>	
                                </div>					

                                <div class="row order-details-edit">
                                    <div class="col-xs-12 col-sm-4">
                                        <a href="{{ route('view.checkout.billing.address') }}" class="order-details__btn btn-tertiary btn-tertiary--gray"><span>Edit Billing Details</span></a>
                                    </div>

                                    <div class="col-xs-12 col-sm-4">
                                        <a href="{{ route('view.checkout.delivery.address') }}" class="order-details__btn btn-tertiary btn-tertiary--gray"><span>Edit Delivery Details</span></a>
                                    </div>      

                                    <div class="col-xs-12 col-sm-4">
                                        <a href="{{ route('view.checkout.payment') }}" class="order-details__btn btn-tertiary btn-tertiary--gray"><span>Edit Payment Details</span></a>
                                    </div>                                                                                                                                                              
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 boot-style-order-basket">
                            <section class="shopping">
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
                                                        <div class="head-col second">Type</div>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <div class="head-col third">Quantity</div>	
                                                    </div>
                                                    <div class="col-xs-3 col-sm-2">
                                                        <div class="head-col fourth">Total</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                    <div class="js-container-magnific body">
                                        @foreach ($basket as $item)
                                        @if (isBasketItemAColourAtlas($item))
                                        @include('checkout.item-colour-atlas')
                                        @elseif (isBasketItemASampleBook($item))
                                        @include('checkout.item-sample-book')
                                        @elseif (isBasketItemAPlainFabric($item))
                                        @include('checkout.item-plain-fabric')
                                        @else
                                        @if (isBasketItemASavedDesign($item))
                                        @include('checkout.item-row')
                                        @else
                                        @include('checkout.item-tmp-row')
                                        @endif
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                            <section class="col-xs-12 shopping no-pad">
                                <div class="col-md-6 col-sm-5">
                                    <p class="order-details__hdr">Delivery Method</p>
                                    <p class="para-main">{{ getShippingWeightBranding($deliveryAddress->weight_branding_id)->title }}</p>
                                </div>

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
                                            <!--- Begin Mention Me referee placeholder div --->
                                                <div class="mention-me">
                                                    <div id="mmWrapper"></div>
                                                </div>
                                            <!--- End Mention Me referee placeholder div --->
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>

                    <div class="row">
                        <form id="place-order-form" method="POST" action="{{ Request::url() }}" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="col-xs-12 col-sm-6">
                                <div class="checkbox-container">
                                    <input type="checkbox" id="sales_checkbox" class="checkbox-boolean" data-input="sales_email" name="sales_checkbox" value="1" checked />
                                    <span class="checkbox-overlay"></span>
                                    <label for="sales_checkbox" class="checkbox-text">I would like to receive email notifications about offers and promotions at Fashion Formula</label>
                                </div>	
                                <div class="checkbox-container">
                                    <input type="checkbox" id="email_checkbox" class="checkbox-boolean" data-input="email_notification" name="email_checkbox" value="1" checked />
                                    <span class="checkbox-overlay"></span>
                                    <label for="email_checkbox" class="checkbox-text">I would like to receive email notification about my order</label>
                                </div>
                                <div class="field-group">
                                    <label for="other_person_email">Email notification to other person</label>
                                    <input id="other_person_email" class="field-secondary" type="email" name="other_person_email" value="{{ old('other_person_email') }}" />
                                </div>                            
                            </div>

                            <!-- GRAND TOTAL -->
                            <div class="col-xs-12 col-sm-6">
                                <div class="grand-total grand-total--order-review">
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
                                    <div class="row">
                                        <div class="col-xs-6 boot-style-1">
                                            <p class="grand-total__title">Delivery:</p>
                                        </div>
                                        <div class="col-xs-6 boot-style-2">
                                            <p class="grand-total__expense">{{ getPriceText($deliveryPrice, getCurrentCurrencySymbol()) }}</p>
                                        </div>	                				
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6 boot-style-1">
                                            <p class="grand-total__title">VAT:</p>
                                        </div>
                                        <div class="col-xs-6 boot-style-2">
                                            <p class="grand-total__expense">{{ getCurrentCurrencySymbol() . $vat }}</p>
                                        </div>	                				
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="grand-total-extra clearfix">
                                    <a href="{{ route('view.basket') }}" class="grand-total-extra__link link-back-major">Edit your Basket</a>
                                    <p class="grand-total__grand-expense">Cart Total: <span>{{ getCurrentCurrencySymbol() . $total }}</span></p>
                                    <div class="checkbox-container">
                                        <input type="checkbox" id="tandc" name="terms" value="1" />
                                        <span class="checkbox-overlay"></span>
                                        <label for="tandc" class="checkbox-text">By completing your order you agree to the <a href="{{ route('view.terms.and.conditions') }}" target="_blank">terms and conditions</a></label>
                                    </div>
                                    <button class="grand-total__checkout btn-primary btn-primary--no-border--thick btn-complete-order" type="button">
                                        <span>Complete your order</span>
                                    </button>
                                </div>
                            </div>
                            <input id="sales_email" type="hidden" name="sales_email" value="1" />
                            <input id="email_notification" type="hidden" name="email_notification" value="1" />
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

</main>

<span data-id="process-payment-popup" class="js-popup-btn btn-process-payment-popup hidden"></span>
<div class="js-popup popup process-payment-popup">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-12">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p class="text-center">Please don't refresh this page or press back button while we process your order.</p>
            </div>      
        </div>
    </div>
</div>

@include('includes.footer')
@stop

@section('end_body')

<!--- Begin Mention Me referee integration --->
<script type="text/javascript" src="https://tag.mention-me.com/api/v2/refereefind/mm4ff24c87?implementation=link&situation=checkout&locale=en_GB"></script>
<!--- End Mention Me referee integration --->

<script type="text/javascript">
    $(function () {
        var $form = $('#place-order-form'),
                $btn = $form.find('.btn-complete-order'),
                $popupBtn = $('.btn-process-payment-popup');

        $btn.click(function () {
            $btn.prop('disabled', true);
            $popupBtn.click();
            setTimeout(function () {
                $form.submit();
            }, 100);
        });
    });
</script>
@stop