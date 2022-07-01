@section('page_title', 'Search results for "' . $keyword . '" | FAQ\'s')
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
                                <h1 class="featured-banner__hdr">Frequently asked questions</h1>
                            </section>
                        </div>
                    </div>	

                    <!-- ORDERS AND SALES -->				
                    <div class="row">
                        <div class="col-xs-12">

                            <section class="faqs">
                                <div class="faqs-head">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <a href="{{route('view.delivery.and.returns')}}" class="faqs-head__item">Delivery &amp; Returns</a>
                                        </div>
                                        <div class="col-xs-3">
                                            <a href="{{route('view.terms.and.conditions')}}" class="faqs-head__item">Terms &amp; Conditions</a>
                                        </div>
                                        <div class="col-xs-3">
                                            <a href="{{route('view.faqs')}}" class="faqs-head__item faqs-head__item--active">Frequently Asked Questions</a>
                                        </div>
                                        <div class="col-xs-3">
                                            <a href="{{route('view.privacy')}}" class="faqs-head__item">Privacy</a>
                                        </div>
                                    </div>
                                </div>		
                                <div class="faqs-search">
                                    <form method="POST" action="{{ route('search.faqs') }}">
                                        {{ csrf_field() }}
                                        <div class="input-grouped">
                                            <input type="search" name="keyword" value="{{ $keyword }}" placeholder="Search..." />
                                            <button class="btn-primary btn-primary--no-border" type="submit"><span>Search</span></button>
                                        </div>
                                    </form>
                                </div>

                                <div class="faqs-featured">

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-3">
                                            <aside class="category">
                                                <h3 class="category__hdr">MOST POPULAR FAQ's</h3>
                                                <ul class="list">
                                                    @foreach ($categories as $key => $category)
                                                    <li class="item">
                                                        <a href="{{ route('view.faqs.category', ['identifier' => $category->identifier]) }}">{{ $category->title }}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </aside>
                                        </div>
                                        <div class="col-xs-12 col-sm-9">
                                            <div class="answers">
                                                @foreach ($faqs as $faq)
                                                    <h2 class="category__hdr">{{ $faq->category->title }}</h2>
                                                    <div class="answers-single">
                                                        <h2 class="answers-single__hdr">{{ $faq->title }}</h2>
                                                        <div class="answer-content cms-editor-content">{!! $faq->content !!}</div>
                                                    </div>
                                                @endforeach
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