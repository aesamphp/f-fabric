@section('page_title', 'Search results for "' . $keyword . '" | Design Tips')
@section('page_class', 'page-faqs')


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
                            <section class="featured-banner featured-banner--questions">
                                <h1 class="featured-banner__hdr">Design Tips</h1>
                                <p class="featured-banner__para">Advice and hints to help you create your masterpiece</p>
                            </section>
                        </div>
                    </div>	

                    <!-- ORDERS AND SALES -->				
                    <div class="row">
                        <div class="col-xs-12">

                            <section class="faqs">	
                                <div class="faqs-search faqs-search--no-border-top">
                                    <form class="ajax-search-form" method="GET" action="{{ route('search.design.tips') }}" data-container="answers" data-page-title="Design Tips">
                                        <div class="input-grouped">
                                            <input type="search" name="keyword" placeholder="Search..." />
                                            <button class="btn-primary btn-primary--no-border" type="submit"><span>Search</span></button>
                                        </div>
                                    </form>
                                </div>

                                <div class="faqs-featured">

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-3">
                                            <aside class="category">
                                                <h3 class="category__hdr">MOST POPULAR TIPS</h3>
                                                @include('design-tip.categories-aside')
                                            </aside>
                                        </div>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="answers ajax-container">
                                                @include('design-tip.search-questions')
                                            </div>
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