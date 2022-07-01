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
                                <h2 class="shopping__hdr hdr-section">My Shopping Basket: (0 Items)</h2>
                                <p class="shopping__para">Your shopping basket is empty. Click <a href="{{ route('view.shop.all') }}">here</a> to continue shopping.</p>
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