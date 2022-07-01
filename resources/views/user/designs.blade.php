@section('page_title', 'My Designs')
@section('page_class', 'my-designs')


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
                <div class="col-md-12 clearfix no-pad">
                        <section class="featured-banner featured-banner--designs">
                            <h1 class="featured-banner__hdr">My Designs</h1>
                        </section>
                    </div>            		
                </div>
                <div class="row">
                    @include('includes.flash')
                </div>
                <div class="row">

                    <!-- ASIDE -->
                    <div class="col-md-3 aside-boot">
                        <div class="sidebar">
                            <aside class="aside-store">
                                <div class="aside-store-main">
                                    @if ($shop->image_path)
                                    <h2 class="aside-store-main__hdr hdr-section hidden-xs">These Designs Belong To:</h2>
                                    @endif
                                    <div class="aside-store-main__img" style="background-image:url('{{ asset($shop->getImagePath()) }}');"></div>
                                    <div class="row no-mar">
                                        <div class="col-md-12 col-sm-8 no-pad">
                                            <ul class="list">
                                                <li class="item">{{ $shop->getFullName() }}</li>
                                                <li class="item">{{ $shop->getLocation() }}</li>
                                            </ul>
                                            @if ($shop->store_link)
                                            <a href="{{ $shop->store_link }}" class="aside-store-main__link link-addr" target="_blank">{{ extractDomainFromURL($shop->store_link) }}</a>
                                            @endif
                                        </div>
                                        <div class="col-md-12 col-sm-4 no-pad">
                                            <a href="{{ route('view.design.upload') }}" class="aside-store-main__btn aside-store-main__btn--second btn-tertiary"><span>Add a new design</span></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="aside-store-category">
                                    <ul class="list">
                                        <li class="item @if ($categoryId === null) active @endif">
                                            @if ($categoryId === null)
                                            All ({{ $designsTotalCount }})
                                            @else
                                            <a href="{{ route('view.user.designs') }}">All ({{ $designsTotalCount }})</a>
                                            @endif
                                        </li>
                                        @foreach ($categories as $key => $category)
                                        <li class="item @if ($category->id == $categoryId) active @endif">
                                            @if ($category->id == $categoryId)
                                            {{ $category->title }} ({{ $user->getCategoryDesignsCount($category->id) }})
                                            @else
                                            <a href="{{ route('view.user.category.designs', ['categoryId' => $category->id]) }}">{{ $category->title }} ({{ $user->getCategoryDesignsCount($category->id) }})</a>
                                            @endif
                                        </li>
                                        @endforeach
                                        <li class="item @if ($categoryId === 'not-for-sale') active @endif">
                                            @if ($categoryId === 'not-for-sale')
                                            Not For Sale ({{ $designsNotForSaleCount }})
                                            @else
                                            <a href="{{ route('view.user.category.designs', ['categoryId' => 'not-for-sale']) }}">Not For Sale ({{ $designsNotForSaleCount }})</a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </aside>
                            <div class="hidden-sm hidden-xs">
                                @include('includes.blog-article-aside', ['articles' => getBlogArticles(2)])
                            </div>
                        </div>    		                                        
                    </div> 

                    <div class="col-md-9 boot-style">	

                        <!-- LATEST DESIGNS -->
                        <div class="col-md-12 clearfix no-pad">
                            <section class="design-approvals">

                                <div class="navbar-sort clearfix">
                                    <div class="col-xs-3 no-pad hidden-sm">
                                        <div class="js-grid-container navbar-sort-grid">
                                            <img src="{{ asset('images/6x6.png') }}" class="js-grid-thumb navbar-sort-grid__img" />
                                            <img src="{{ asset('images/4x4.png') }}" class="js-grid-tile navbar-sort-grid__img" />
                                        </div>
                                    </div>

                                    <div class="col-md-5 col-sm-6 col-xs-12 no-pad pull-right">
                                        <form method="GET" action="{{ route('view.user.designs') }}">
                                            <div class="navbar-sort-input input-grouped">
                                                <input class="navbar-sort-input__text" type="search" name="keyword" value="{{ $keyword }}" />
                                                <button class="navbar-sort-input__btn btn-primary btn-primary--no-border" type="submit">
                                                    <span>Search</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 no-pad hidden">
                                        <div class="navbar-sort-filter">
                                            <div class="single-filter">
                                                <select class="single-filter__select">
                                                    <option value="Option1">All Designs</option>
                                                </select>
                                            </div>									
                                        </div>
                                    </div>
                                </div>	

                                <div class="row no-mar js-grid-products-container">
                                    @foreach ($designs as $design)
                                    <div class="col-lg-3 col-sm-6 col-xs-12 boot-style">		
                                        <div class="products-grid-tile approvals">

                                            <div class="product-thumbnail" style="background-image: url('{{ asset($design->getThumbnailImagePath()) }}');"></div>
                                            
                                            <div class="hover">
                                                <div class="vertical-outer">
                                                    <div class="vertical-inner">

                                                        <div class="hover__left">
                                                            <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $design->getFavouritesCount() }}
                                                        </div>
                                                        <div class="js-container-magnific hover__right">
                                                            <a href="{{ asset($design->getWatermarkImagePath()) }}" title="{{ $design->getDesignerCopyrightText() }}">
                                                                <img src="{{ asset('images/svgs/magnify.svg') }}" alt="Magnify" />Quick Look
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="info approvals">
                                                <div class="approvals-top">
                                                    <p class="approvals-top__type">{{ $design->title }}</p>
                                                </div>

                                                <div class="approvals-bottom clearfix">
                                                    <div class="col-xs-7 clearfix no-pad">
                                                        <p class="approvals-bottom__status {{ $design->getStatusClass() }}"></p>
                                                    </div>
                                                    <div class="col-xs-5 clearfix no-pad">
                                                        <form class="delete-form" method="POST" action="{{ route('view.delete.design', ['id' => $design->id]) }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button class="approvals-bottom__btn btn-primary" type="submit"><span>Delete</span></button>
                                                        </form>
                                                        <a href="{{ route('view.edit.design', ['id' => $design->id]) }}" class="approvals-bottom__btn btn-primary margin-top"><span>Edit</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="products-grid-pagination">
                                    <div class="pagination">
                                        {!! $designs->appends($appends)->render() !!}
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