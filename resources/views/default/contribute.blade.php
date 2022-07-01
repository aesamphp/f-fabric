@section('page_title', 'Sell designs for commission | Contribute')
@section('page_class', 'contribute-page')
@section('meta_description', 'Contributing to the Fashion Formula is simple; all you need to do to earn commission is register, upload your design and create your online shop. Find out more.')
@section('meta_keywords', '')

@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern no-pad">
                <div class="row">
                    <div class="col-xs-12">		
                        <section class="featured-tiles">
                            <h1 class="featured-tiles__subhdr hdr-section">Contribute to Fashion Formula</h1>

                            <div class="sly-carousel sly-carousel-single sly-mobile-only container-single-tiles clearfix">
                                <div class="sly-content">
                                    <div class="sly-item col-md-3 col-sm-6 boot-style">
                                        <div class="single-tile single-tile--register ordered js-full-mobile-only-half js-full-height">
                                            <div class="vertical-outer">
                                                <div class="vertical-inner">

                                                    <div class="single-tile__number circle-number">
                                                        <div class="vertical-outer">
                                                            <div class="vertical-inner">1</div>
                                                        </div>
                                                    </div>	

                                                    <h2 class="single-tile__subhdr">Register your <br />account</h2>
                                                    <p class="single-tile__para">Pop in a couple of details to create your Fashion Formula account and personalised shop</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sly-item col-md-3 col-sm-6 boot-style">
                                        <div class="single-tile single-tile--upload ordered js-full-mobile-only-half js-full-height">
                                            <div class="vertical-outer">
                                                <div class="vertical-inner">

                                                    <div class="single-tile__number circle-number">
                                                        <div class="vertical-outer">
                                                            <div class="vertical-inner">2</div>
                                                        </div>
                                                    </div>	

                                                    <h2 class="single-tile__subhdr">Upload your <br />design</h2>
                                                    <p class="single-tile__para">Upload and manipulate your designs and prepare them for selling</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sly-item col-md-3 col-sm-6 boot-style">
                                        <div class="single-tile single-tile--online ordered js-full-mobile-only-half js-full-height">
                                            <div class="vertical-outer">
                                                <div class="vertical-inner">

                                                    <div class="single-tile__number circle-number">
                                                        <div class="vertical-outer">
                                                            <div class="vertical-inner">3</div>
                                                        </div>
                                                    </div>	

                                                    <h2 class="single-tile__subhdr">Create your online <br />shop</h2>
                                                    <p class="single-tile__para">Design you own personalised area to exhibit your wonderful designs and tell your story to the world</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sly-item col-md-3 col-sm-6 boot-style">
                                        <div class="single-tile single-tile--money ordered js-full-mobile-only-half js-full-height">
                                            <div class="vertical-outer">
                                                <div class="vertical-inner">

                                                    <div class="single-tile__number circle-number">
                                                        <div class="vertical-outer">
                                                            <div class="vertical-inner">4</div>
                                                        </div>
                                                    </div>	

                                                    <h2 class="single-tile__subhdr">Make money from your <br />design</h2>
                                                    <p class="single-tile__para">Earn commission of up t o 20% of any designs you sell ….easy peasy</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>																											
                                </div>
                                <div class='sly-bullets'></div>																							
                            </div>

                            <a href="{{ route('view.login') }}" class="featured-tiles__btn btn-primary"><span>Get started</span></a>
                        </section>
                    </div>								
                </div>
            </div>
        </div>
    </div>

</main>

@include('includes.footer')
@stop