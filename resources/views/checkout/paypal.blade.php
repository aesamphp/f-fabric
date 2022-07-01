@section('page_title', 'Paypal Authentication')
@section('page_class', 'page-paypal')


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
                            <section class="thank-you">
                                <h2 class="thank-you__hdr">Paypal Authentication</h2>
                                <p class="thank-you__para thank-you__para--3d">Please click button below to proceed to Paypal.</p>
                                <a href="{{ route('view.checkout.order.review') }}" class="checkout-previous-cta__btn btn-primary btn-primary--no-border--thick"><span>Back</span></a>
                                <a href="{{ $paypalData->PayPalRedirectURL }}" class="checkout-previous-cta__btn btn-primary btn-primary--no-border--thick"><span>Proceed</span></a>
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