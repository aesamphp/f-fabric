@section('page_title', 'Print your own Fabric | How It Works')
@section('page_class', 'how-it-works-page')
@section('meta_description', 'If you\'re still unsure as to how the Fashion Formula platform works, click here to take a look at our step-by-step guide and begin your creative journey.')
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

                    <section class="featured-tiles major">
                        <h1 class="featured-tiles__subhdr hdr-section">How does fashion formula work?</h1>

                        <div class="sly-carousel sly-carousel-single sly-mobile-only container-single-tiles container-single-tiles--major clearfix">
                            <div class="sly-content">
                                <div class="sly-item col-sm-4 boot-style">
                                    <div class="single-tile ordered js-full-mobile-only-half js-full-height" style="background-image: url('{{ asset('images/tri-wall.png') }}');">
                                        <div class="vertical-outer">
                                            <div class="vertical-inner">

                                                <div class="single-tile__number circle-number">
                                                    <div class="vertical-outer">
                                                        <div class="vertical-inner">
                                                            1
                                                        </div>
                                                    </div>
                                                </div>	

                                                <h2 class="single-tile__subhdr">Start with <br />a design</h2>
                                                <p class="single-tile__para">Select a design from thousands available, created by our highly talented design community or design something yourself.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sly-item col-sm-4 boot-style">
                                    <div class="single-tile ordered js-full-mobile-only-half js-full-height" style="background-image: url('{{ asset('images/hat-woman.png') }}');">
                                        <div class="vertical-outer">
                                            <div class="vertical-inner">

                                                <div class="single-tile__number circle-number">
                                                    <div class="vertical-outer">
                                                        <div class="vertical-inner">
                                                            2
                                                        </div>
                                                    </div>
                                                </div>	

                                                <h2 class="single-tile__subhdr">Choose a <br />product</h2>
                                                <p class="single-tile__para">Select the product and quantity you would like to purchase</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sly-item col-sm-4 boot-style">
                                    <div class="single-tile ordered js-full-mobile-only-half js-full-height" style="background-image: url('{{ asset('images/print-paper.png') }}');">
                                        <div class="vertical-outer">
                                            <div class="vertical-inner">

                                                <div class="single-tile__number circle-number">
                                                    <div class="vertical-outer">
                                                        <div class="vertical-inner">
                                                            3
                                                        </div>
                                                    </div>
                                                </div>	

                                                <h2 class="single-tile__subhdr">We print it <br />to order</h2>
                                                <p class="single-tile__para">All designs are produced to your exact requirements and will be delivered in 5-10 working days…perfect!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>																										
                            </div>
                            <div class='sly-bullets'></div>																							
                        </div>

                        <a href="{{ route('view.shop') }}" class="featured-tiles__btn btn-primary"><span>Get started</span></a>
                    </section>					

                </div>
            </div>
        </div>
    </div>

</main>

@include('includes.footer')
@stop