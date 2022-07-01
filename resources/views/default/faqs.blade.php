@section('page_title', $category->title . ' | FAQ\'s')
@section('page_class', 'page-faqs')
@section('meta_description', 'Got a custom print related question? Then head over to our FAQs section or drop our team of experts an email on hello@fashion-formula.com any time for help.')
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
                            <section class="featured-banner featured-banner--questions">
                                <h1 class="featured-banner__hdr">Frequently asked questions</h1>
                            </section>
                        </div>
                    </div>

                    <!-- ORDERS AND SALES -->				
                    <div class="row">
                        <div class="col-xs-12">

                            <section class="faqs">
                                @include('includes.help-nav')
                                <div class="faqs-search">
                                    <form method="POST" action="{{ route('search.faqs') }}">
                                        {{ csrf_field() }}
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
                                                <h3 class="category__hdr">MOST POPULAR FAQ's</h3>
                                                <ul class="list">
                                                    @foreach ($categories as $cat)
                                                    <li class="item @if ($cat->id === $category->id) active @endif">
                                                        @if ($cat->id === $category->id)
                                                        {{ $cat->title }}
                                                        @else
                                                        <a href="{{ route('view.faqs.category', ['identifier' => $cat->identifier]) }}">{{ $cat->title }}</a>
                                                        @endif
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </aside>
                                        </div>
                                        <div class="col-xs-12 col-sm-9"> 
                                           
                                            <div class="answers">
                                                <div class="answers-single">
                                                    <div class="accordion">
                                                    @foreach ($category->faqs as $faq)
                                                        <h2 class="answers-single__hdr">{{ $faq->title }}</h2>
                                                        <div class="answer-content cms-editor-content">{!! $faq->content !!}</div>
                                                    @endforeach
                                                    </div>
                                                </div>
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