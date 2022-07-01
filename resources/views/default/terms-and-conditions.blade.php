@section('page_title', $page->title)
@section('page_class', 'page-delivery-and-returns')
@section('meta_description', 'Read our terms before you submit your order to us to understand who we are, how we will provide products to you, what to do if there is a problem &amp; more.')
@section('meta_keywords', '')

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
                            <section class="featured-banner featured-banner--terms">
                                <h1 class="featured-banner__hdr">{{ $page->title }}</h1>
                            </section>
                        </div>
                    </div>	

                    <!-- ORDERS AND SALES -->				
                    <div class="row">
                        <div class="col-xs-12">

                            <section class="faqs">
                                @include('includes.help-nav')

                                <div class="faqs-featured">

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="answers answers--no-aside page-content">{!! $page->content !!}</div>
                                        </div>
                                    </div>

                                </div>

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