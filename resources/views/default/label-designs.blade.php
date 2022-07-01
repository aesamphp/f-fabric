<div class="row no-mar">
    <div class="products-grid-title clearfix">
        <div class="col-sm-6">
            <h2 class="products-grid-title__hdr">{{ ($labelKeyword) ? "'{$labelKeyword}'" : 'Popular' }} products</h2>
            <a href="{{ ($labelKeyword) ? route('view.shop.all', ['labels[]' => $labelKeyword]) : route('view.shop.all', ['filter' => 'most-popular']) }}" class="products-grid-title__label">See more</a>
        </div>
    </div>
</div>
<div class="row no-mar add-pad">

    @if (count($labelDesigns) > 0)
        @foreach ($labelDesigns as $design)
        <div class="col-lg-3 col-xs-6 boot-style">
            <div class="products-grid-tile">

                @if ($design->isShoppable())
                    <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $design->identifier]) }}"></a>
                @endif

                <div class="product-thumbnail height-xs-full" style="background-image: url('{{ asset($design->getThumbnailImagePath()) }}');"></div>

                <div class="hover">
                    <div class="vertical-outer">
                        <div class="vertical-inner">

                            <div class="hover__left">
                                @if ($design->isFavouriteable())
                                    <a class="btn-favourite-design @if ($design->hasfavourited()) active @endif" href="{{ route('favourite.design', ['id' => $design->id]) }}">
                                        @if ($design->hasfavourited())
                                            <img src="{{ asset('images/svgs/heart-red.svg') }}" alt="Favourite Design" />
                                        @else
                                            <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />
                                        @endif
                                        <span>{{ $design->getFavouritesCount() }}</span>
                                    </a>
                                    @else
                                    <a href="#" class="js-popup-btn" data-id="authentication-required-popup">
                                        <img src="{{ asset('images/svgs/heart.svg') }}" alt="Favourite Design" />{{ $design->getFavouritesCount() }}
                                    </a>
                                @endif
                            </div>
                            <div class="js-container-magnific hover__right">
                                <a href="{{ asset($design->getWatermarkImagePath()) }}" title="{{ $design->getDesignerCopyrightText() }}">
                                    <img src="{{ asset('images/svgs/magnify.svg') }}" alt="Magnify" />Quick Look
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="info">
                    <div class="vertical-outer">
                        <div class="vertical-inner">
                            <div class="info-left">
                                <p class="info-left__type">{{ $design->title }}</p>
                                <p class="info-left__author">by <a href="{{ route('view.designer.store', ['username' => $design->user->studio->username]) }}">{{ $design->user->username }}</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="info-right">
                        <!-- Mobile & Tablet Only -->
                            <div class="hidden">
                                <img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/heart.svg') }}" />
                            </div>
                            <a class="tablet-magnify hidden" href="{{ asset('images/pattern1.png') }}"><img class="info-right__img info-right__img--minor hidden-md hidden-lg" src="{{ asset('images/svgs/magnify.svg') }}"></a>
                        <!---->

                        @if ($design->isShoppable())
                            <a href="{{ route('view.shop.design', ['designIdentifier' => $design->identifier]) }}">
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
    @else
        <p>No designs found.</p>
    @endif
</div>