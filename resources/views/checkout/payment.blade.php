@section('page_title', 'Payment')
@section('page_class', 'page-payment')


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
                            <h1 class="featured-banner__hdr">Checkout</h1>
                        </section>
                    </div>
                </div>	

                <!-- CHECKOUT -->
                <form method="POST" action="{{ Request::url() }}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="checkout">
                        <div class="row">
                            <div class="col-xs-12">
                                @include('checkout.steps-nav')
                            </div>
                        </div>
                        
                        @include('includes.flash')

                        <div class="row">
                            <div class="col-sm-8 col-md-8 col-xs-12">
                                <section class="checkout-input card">
                                    <h2 class="checkout-input__hdr mandatory hdr-section">Payment Details</h2>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="checkout-input-field field-group">
                                                @foreach ($cardTypes as $cardType)
                                                <div class="radio-container radio-inline">
                                                    <input id="{{ $cardType->id }}" type="radio" name="cardType" value="{{ $cardType->id }}" />
                                                    <span class="checkbox-overlay"></span>
                                                    <label for="{{ $cardType->id }}" class="checkbox-text">
                                                        <img src="{{ asset($cardType->icon) }}" alt="{{ $cardType->title }}" title="{{ $cardType->title }}" />
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                            <p class="para-main paypal-notice hidden">After the order review you will be redirected to Paypal Express Checkout.</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                                            <div class="payment-card-field-group">
                                                <div class="checkout-input-field field-group">
                                                    <label for="cardHolder">Card Holder Name*</label>
                                                    <input id="cardHolder" class="field-secondary field-secondary--input-central" name="cardHolder" type="text" maxlength="50" />
                                                </div>
                                                <div class="checkout-input-field field-group">
                                                    <label for="cardNumber">Card Number* (no spaces)</label>
                                                    <input id="cardNumber" class="field-secondary field-secondary--input-central" name="cardNumber" type="tel" maxlength="20" />
                                                </div>
                                                <div class="checkout-input-field field-group">
                                                    <label for="month">Expiry Date*</label>
                                                    <select id="month" name="month" class="card-details" style="width: 50%;">
                                                        <option value="">Month</option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                        @endfor
                                                    </select>
                                                    <select id="year" name="year" class="card-details" style="width: 50%;">
                                                        <option value="">Year</option>
                                                        @for ($i = $yearStart; $i <= $yearEnd; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="checkout-input-field field-group">
                                                    <label for="cv2">Security Code*</label>
                                                    <input id="cv2" class="field-secondary field-secondary--input-central" name="cv2" type="tel" maxlength="4" style="width: 50%;" />
                                                </div>
                                                <div class="checkout-input-field field-group">
                                                    <img class="img-responsive sagepay-logo" src="{{ asset('images/sagepay_logo.png') }}" alt="Sagepay" />
                                                </div>
                                            </div>
                                        </div>																		
                                    </div>					
                                </section>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <section class="checkout-previous">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-7 col-xs-12 pull-right">
                                            <div class="checkout-previous-cta">
                                                <a href="{{ route('view.checkout.delivery.address') }}" class="checkout-previous-cta__btn btn-primary btn-primary--no-border--thick"><span>Back</span></a>
                                                <button class="checkout-previous-cta__btn btn-primary btn-primary--no-border--thick" type="submit">
                                                    <span>Next</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>					
                    </div>
                </form>
            </div>
        </div>
    </div>

</main>


@include('includes.footer')
@stop

@section('end_body')
<script type="text/javascript">
    $(function() {
        $('input[name="cardType"]').change(function() {
            var $this = $(this),
                $cardFields = $('.payment-card-field-group'),
                $paypalNotice = $('.paypal-notice');
            if ($this.val() === 'PAYPAL') {
                $cardFields.addClass('hidden');
                $paypalNotice.removeClass('hidden');
            } else {
                $paypalNotice.addClass('hidden');
                $cardFields.removeClass('hidden');
            }
        });
    });
</script>
@stop