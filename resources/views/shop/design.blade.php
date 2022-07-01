@section('page_title', $design->title)
@section('page_class', 'shop-main-info-page')


@extends('layouts.master')

@section('content')
@include('includes.mobile-nav')
@include('includes.header')

<main>

    <div class="container container-global">
        <div class="row">

            <div class="col-xs-12 container-dotted-pattern">
                <div class="row">

                    <div class="inner-section clearfix">
                        <div class="row">
                            <div class="col-sm-12">

                                <section class="featured-info">
                                    @include('includes.flash')
                                    <div class="row">
                                        <div class="col-md-7">
                                            <section class="design-selected">
                                                <div class="design-selected-image height-700 center-block loading-container" data-design="{{ $design->id }}">
                                                    <div class="icon-loading">
                                                        <div class="loader">Loading...</div>
                                                        <p class="para-main text-center">Preview Loading...<br />It can take up to a minute...</p>
                                                    </div>
                                                </div>
                                                @include('design.design-mask-buttons')
                                            </section>
                                            @if (count($design->getAdditionalImages()) > 0)
                                            <div class="featured-info-carousel">
                                                <div class="sly-carousel" data-controls-outside="true" data-cycle-by="pages">
                                                    <div class="sly-content clearfix item-carousel">
                                                        @foreach ($design->getAdditionalImages() as $image)
                                                        <div class="sly-item">       
                                                            <div class="item-carousel__list-item">
                                                                <div class="products-grid-tile js-container-magnific" style="background-image: url('{{ asset($image->path) }}');">
                                                                    <a class="link-area" href="{{ asset($image->path) }}"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <button class="sly-prev sly-prev--pickout minor" type="button"></button>
                                                <button class="sly-next sly-next--pickout minor" type="button"></button>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="col-md-5">
                                            <div class="featured-info-details">
                                                <div class="row">
                                                    <div class="col-sm-6 col-xs-8">
                                                        <div class="mobile-inline">
                                                            <h1 class="featured-info-details__hdr hdr-section">{{ $design->title }}</h1>
                                                            <a href="{{ route('view.designer.store', ['username' => $design->user->studio->username]) }}" class="featured-info-details__author">by {{ $design->user->username }}</a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-xs-4">
                                                        <div class="favorites-section">
                                                            @if ($design->isFavouriteable())
                                                            <a class="no-underline btn-favourite-design @if ($design->hasfavourited()) active @endif" href="{{ route('favourite.design', ['id' => $design->id]) }}">
                                                                @if ($design->hasfavourited())
                                                                <img src="{{ asset('images/svgs/heart-red.svg') }}" alt="Favourite Design" />
                                                                @else
                                                                <img src="{{ asset('images/svgs/heart-grey.svg') }}" alt="Favourite Design" />
                                                                @endif
                                                                <span class="para-main">{{ $design->getFavouritesCount() }}</span>
                                                            </a>
                                                            @else
                                                            <a href="#" class="no-underline js-popup-btn" data-id="authentication-required-popup">
                                                                <img src="{{ asset('images/svgs/heart-grey.svg') }}" alt="Favourite Design" />
                                                                <span class="para-main">{{ $design->getFavouritesCount() }}</span>
                                                            </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="design-options-tabs clearfix">
                                                    <h3 class="design-options-tabs__hdr  hdr-input">1. Choose a Product Type</h3>                                                 
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        @foreach ($categories as $key => $category)
                                                        <li class="col-xs-3 tab-single @if ($categoryFilter == $category->id) active @endif" data-design="{{ $design->id }}" data-template="design-tab-content">
                                                            <a href="#" data-id="{{ $category->id }}" data-url="{{ route('view.category.tab.content', ['id' => $category->id]) }}">{{ $category->title }}</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    
                                                    <form class="ajax-add-to-cart-form" method="POST" action="{{ route('store.basket.item') }}" autocomplete="off">
                                                        {{ csrf_field() }}
                                                        <div class="tab-content"></div>
                                                        <input type="hidden" name="design_saved" value="1" />
                                                        <input type="hidden" name="design_id" value="{{ $design->id }}" />
                                                        <input type="hidden" name="colour_atlas" value="0" />
                                                        <input type="hidden" name="sample_book" value="0" />
                                                        <input type="hidden" name="plain_fabric" value="0" />
                                                        <input id="design_type_id" type="hidden" name="design_type_id" />
                                                        <input type="hidden" name="design_request_public" value="0" />
                                                    </form>

                                                </div>
                                                <div class="social-container">
                                                    <a href="{{ getShareURL(Request::url(), 'facebook') }}" target="_blank" class="btn-social fb"></a>
                                                    <a href="{{ getShareURL(Request::url(), 'twitter') }}" target="_blank" class="btn-social tw"></a>
                                                    <a href="{{ getShareURL(Request::url(), 'pinterest') }}" target="_blank" class="btn-social pn"></a>
                                                    <a href="{{ getShareURL(Request::url(), 'googlePlus') }}" target="_blank" class="btn-social gp"></a>
                                                    <a href="" class="btn-social like"></a>
                                                </div>

                                                <div class="labels">
                                                    <div class="label-single">
                                                        <p class="label-single__hdr hdr-section">Labels - </p>
                                                        {{ $design->getLabelsString() }}
                                                    </div>
                                                    <div class="label-single">
                                                        <p class="label-single__hdr hdr-section">Collection - </p>
                                                        {{ $design->getCollectionLabelsString() }}
                                                    </div>
                                                    <div class="label-single">
                                                        <p class="label-single__hdr hdr-section">Design # </p>
                                                        {{ $design->friendly_id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>                            
                            <div class="col-lg-3 col-sm-12 hidden">
                                <aside class="aside-thumbs">
                                    <h3 class="aside-thumbs__hdr">Products in this collection</h3>
                                    <a class="aside-thumbs__link" href="{{ route('view.shop.all', ['category' => $categoryFilter]) }}">{{ getCategory($categoryFilter)->title }}</a>
                                    @foreach ($latestDesigns as $latestDesign)
                                    <div class="col-lg-12 col-sm-4 no-pad clearfix">
                                        <div class="aside-thumbs-single">
                                            <div class="products-grid-tile">
                                                @if ($latestDesign->isShoppable())
                                                <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $latestDesign->identifier]) }}"></a>
                                                @endif
                                                <div class="product-thumbnail" style="background-image: url('{{ asset($latestDesign->getThumbnailImagePath()) }}');"></div>
                                                <div class="hover short">
                                                    <div class="vertical-outer">
                                                        <div class="vertical-inner">

                                                            <div class="hover__left">
                                                                @if ($latestDesign->isFavouriteable())
                                                                <a class="btn-favourite-design @if ($latestDesign->hasfavourited()) active @endif" href="{{ route('favourite.design', ['id' => $latestDesign->id]) }}">
                                                                    @if ($latestDesign->hasfavourited())
                                                                    <img src="{{ asset('images/svgs/heart-red.svg') }}" alt="Favourite Design" />
                                                                    @else
                                                                    <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />
                                                                    @endif
                                                                    <span>{{ $latestDesign->getFavouritesCount() }}</span>
                                                                </a>
                                                                @else
                                                                <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $latestDesign->getFavouritesCount() }}
                                                                @endif
                                                            </div>
                                                            <div class="js-container-magnific hover__right">
                                                                <a href="{{ asset($latestDesign->getWatermarkImagePath()) }}" title="{{ $latestDesign->getDesignerCopyrightText() }}">
                                                                    <img src="{{ asset('images/svgs/magnify.svg') }}" alt="Magnify" />Quick Look
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="aside-thumbs-single__label">{{ $latestDesign->title }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </aside>
                            </div>                            
                        </div>
                    </div>

                    <div class="inner-section-bottom clearfix" data-match="container">
                        <div class="row">
                            <div class="col-sm-8 boot-style-1">
                                <section class="comments" data-match="height">

                                    <h2 class="comments__hdr hdr-section--minor">Comments</h2>
                                    
                                    @if (!isCustomerUser() || !$design->isOwner(getAuthenticatedUser()->id))
                                    <div class="comments-form clearfix">
                                        <h3 class="comments-form__hdr hdr-section--minor">Add your comment</h3>
                                        <span data-id="share-image-popup" class="js-popup-btn comments-form__link">Share your image</span>
                                        <form method="POST" action="{{ route('store.design.comment', ['id' => $design->id]) }}" autocomplete="off">
                                            {{ csrf_field() }}
                                            <textarea name="content" class="comments-form__textarea" cols="30" rows="7"@if (!isCustomerUser()) disabled @endif>@if (isCustomerUser()) {{ old('content') }} @else {{ '(Login to post a comment)' }} @endif</textarea>
                                            <button class="comments-form__btn btn-primary btn-primary--minor" type="submit"@if (!isCustomerUser()) disabled @endif>
                                                <span>Post Comment</span>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                    
                                    @foreach ($design->comments as $comment)
                                    <div class="comments-single clearfix">
                                        <h3 class="comments-single__name hdr-section--minor">{{ $comment->user->username }}</h3>
                                        <time class="comments-single__time">{{ formatDate($comment->created_at, 'd/m/Y') }}</time>
                                        <p class="comments-single__para">{{ $comment->content }}</p>
                                        @if (isCustomerUser() && !$comment->isOwner() && !$comment->isReported())
                                        <a href="{{ route('report.comment', ['id' => $comment->id]) }}" class="js-popup-btn comments-single__link" data-id="report-comment-popup">Report Comment</a>
                                        @endif
                                    </div>
                                    @endforeach

                                </section>
                            </div>

                            <div class="col-sm-4 boot-style-2">

                                <section class="double-thumbs" data-match="height">

                                    <h2 class="double-thumbs__hdr hdr-section--minor">Other Related Products by this designer</h2>

                                    <div class="double-thumbs-inner-container">
                                        <div class="row">
                                            <div class="single-thumbs-row clearfix">
                                                @foreach ($design->getRelatedDesignsByDesigner() as $relatedDesign)
                                                <div class="col-lg-6 col-md-12 boot-style">
                                                    <div class="single-thumbs products-grid-tile">
                                                        @if ($relatedDesign->isShoppable())
                                                        <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $relatedDesign->identifier]) }}"></a>
                                                        @endif
                                                        <div class="product-thumbnail" style="background-image: url('{{ asset($relatedDesign->getThumbnailImagePath()) }}');"></div>
                                                        <div class="hover short">
                                                            <div class="vertical-outer">
                                                                <div class="vertical-inner">
                                                                    <div class="hover__left">
                                                                        @if ($relatedDesign->isFavouriteable())
                                                                        <a class="btn-favourite-design @if ($relatedDesign->hasfavourited()) active @endif" href="{{ route('favourite.design', ['id' => $relatedDesign->id]) }}">
                                                                            @if ($relatedDesign->hasfavourited())
                                                                            <img src="{{ asset('images/svgs/heart-red.svg') }}" alt="Favourite Design" />
                                                                            @else
                                                                            <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />
                                                                            @endif
                                                                            <span>{{ $relatedDesign->getFavouritesCount() }}</span>
                                                                        </a>
                                                                        @else
                                                                        <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $relatedDesign->getFavouritesCount() }}
                                                                        @endif
                                                                    </div>
                                                                    <div class="js-container-magnific hover__right">
                                                                        <a href="{{ asset($relatedDesign->getWatermarkImagePath()) }}" title="{{ $relatedDesign->getDesignerCopyrightText() }}">
                                                                            <img src="{{ asset('images/svgs/magnify.svg') }}" alt="Magnify" />Quick Look
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="info short">
                                                            <div class="vertical-outer">
                                                                <div class="vertical-inner">    
                                                                    <div class="info-left">
                                                                        <p class="info-left__type">{{ $relatedDesign->title }}</p>
                                                                        <p class="info-left__author">by <a href="{{ route('view.designer.store', ['username' => $relatedDesign->user->studio->username]) }}">{{ $relatedDesign->user->username }}</a></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="info-right">

                                                                <!-- Mobile & Tablet Only -->
                                                                <div class="hidden">
                                                                    <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/heart.svg') }}" />
                                                                    <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/magnify.svg') }}" />
                                                                </div>
                                                                <!---->

                                                                @if ($relatedDesign->isShoppable())
                                                                <a href="{{ route('view.shop.design', ['designIdentifier' => $relatedDesign->identifier]) }}">
                                                                    <img class="info-right__img" src="{{ asset('images/svgs/cart.svg') }}" />
                                                                    <img class="info-right__img--bg" src="{{ asset('images/svgs/cart-highlight.svg') }}" />
                                                                </a>
                                                                @else
                                                                <a href="#" class="js-popup-btn" data-id="design-not-for-sale-popup">
                                                                    <img class="info-right__img" src="{{ asset('images/svgs/eye-icon.svg') }}" />
                                                                </a>
                                                                @endif


                                                            </div>
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                @endforeach
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
    </div>

</main>

<div class="js-popup popup share-image-popup">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-10">
                <h2 class="upload-popup__hdr hdr-section--minor">Share your image</h2>
            </div>
            <div class="col-xs-2">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row upload-popup-ctas">
            <div class="col-sm-4 col-xs-12">
                <div class="upload">
                    <input class="upload__btn" type="file" name="fileToUpload" id="fileToUpload">
                    <div class="upload__overlay btn-tertiary--gray"><span>Choose File</span></div>
                </div>                                                    
            </div>

            <div class="col-sm-4 col-xs-12">
                <a href="" class="upload-popup-ctas__btn btn-primary btn-primary--minor"><span>Upload file</span></a>
            </div>
        </div>
        <div class="row">
            <div class="upload-popup-fields clearfix">
                <div class="col-xs-12">
                    <input type="text" class="field-primary" placeholder="Your name">
                </div>

                <div class="col-xs-12">
                    <input type="text" class="upload-popup-fields__last field-primary" placeholder="Your email address">
                </div>  
            </div>

            <div class="col-xs-12">
                <a href="#" class="upload-popup__send btn-primary btn-primary--minor"><span>Send image</span></a>
            </div>      
        </div>
    </div>
</div>

<div class="js-popup popup report-comment-popup">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-10">
                <h2 class="upload-popup__hdr hdr-section--minor">Report comment</h2>
            </div>
            <div class="col-xs-2">
                <span class="js-popup-cancel upload-popup__cancel">&#10060;</span>
            </div>
        </div>
        <div class="row">
            <form id="report-comment-form" method="POST" action="" autocomplete="off">
                {{ csrf_field() }}
                <input type="hidden" name="type_id" value="{{ getClassConstantValue('App\Models\ReportedComment::TYPE_DESIGN') }}" />
                <div class="upload-popup-fields clearfix">
                    <div class="col-xs-12">
                        <textarea name="reason" class="comments-form__textarea report-textarea" cols="30" rows="7" placeholder="Provide your reason"></textarea>
                    </div>  
                </div>
                <div class="col-xs-12">
                    <button type="submit" class="upload-popup__send btn-primary btn-primary--minor"><span>Submit</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('includes.footer')
@stop

@section('end_body')
@include('design.manipulate-js')
@stop