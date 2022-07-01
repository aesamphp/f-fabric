@section('page_title', 'Custom print Fabric, Wallpaper &amp; Gift Wrap')
@section('page_class', 'home')
@section('meta_description', 'Print your own fabric, wallpaper and wrapping paper from just £1 or Buy from 1000s of Indie designs; designers can upload their own designs to earn commission ')
@section('meta_keywords', '')

@extends('layouts.master')

@section('content')
    @include('includes.mobile-nav')
    @include('includes.header')

    <main>
        <div class="product">
            @if ($carouselSlides)
                <section class="sly-carousel sly-carousel-single js-full-mobile-only js-full-height" data-auto="true">
                    <div class="sly-content featured-carousel">
                        @foreach ($carouselSlides as $slide)
                            <div class="sly-item featured-carousel-single"
                                    style="background-image:url('{{ asset($slide->image_path) }}');">
                                <div class="vertical-outer background-text-overlay">
                                    <div class="vertical-inner">
                                        @if ($slide->content)
                                            <h1 class="featured-carousel-single__hdr hdr-main">{{ $slide->content }}</h1>
                                        @endif
                                        @if ($slide->hasLink())
                                            {!! generateCTALinkHtml($slide->cta_href, $slide->cta_title, $slide->hasInternalLink(), ['class' => 'featured-carousel-single__btn btn-primary']) !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="sly-prev" type="button"></button>
                    <button class="sly-next" type="button"></button>
                    <div class='sly-bullets'></div>
                </section>
            @endif
            <div class="container container-global container-padding">
                <div class="row">
                    <div class="col-xs-12 no-pad container-dotted-pattern">
                        <section class="section-fill section-fill--main">
                            <div class="container-tileimg-textarea">
                                <div class="row no-mar-sm">
                                    <div class="col-xs-4 boot-style">
                                        <div class="tileimg-textarea">
                                            <div class="tileimg-textarea-image">
                                                <img src="{{ asset('images/shoe-img.png') }}"
                                                     class="tileimg-textarea-image__img">
                                                <img src="{{ asset('images/shoe-img-highlight.png') }}"
                                                     class="tileimg-textarea-image__img--highlight">
                                            </div>
                                            <h2 class="tileimg-textarea__hdr">International Delivery</h2>
                                            <p class="tileimg-textarea__para">No Minimum Order</p>
                                        </div>
                                    </div>

                                    <div class="col-xs-4 boot-style">
                                        <div class="tileimg-textarea">
                                            <div class="tileimg-textarea-image">
                                                <img src="{{ asset('images/patch-img.png') }}"
                                                     class="tileimg-textarea-image__img">
                                                <img src="{{ asset('images/patch-img-highlight.png') }}"
                                                     class="tileimg-textarea-image__img--highlight">
                                            </div>
                                            <h2 class="tileimg-textarea__hdr">Over 70 Fabrics &amp; Papers</h2>
                                            <p class="tileimg-textarea__para">Eco&dash;friendly inks</p>
                                        </div>
                                    </div>

                                    <div class="col-xs-4 boot-style">
                                        <div class="tileimg-textarea">
                                            <div class="tileimg-textarea-image">
                                                <img src="{{ asset('images/rocket-img.png') }}"
                                                     class="tileimg-textarea-image__img">
                                                <img src="{{ asset('images/rocket-img-highlight.png') }}"
                                                     class="tileimg-textarea-image__img--highlight">
                                            </div>
                                            <h2 class="tileimg-textarea__hdr">Free UK shipping over &pound;60</h2>
                                            <p class="tileimg-textarea__para">Made in London</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (count($threeBlockSegment) > 0)
                                <div class="container-featured-thumb">
                                    <div class="row no-mar">
                                        @foreach ($threeBlockSegment as $block)
                                            <div class="col-sm-4 boot-style">
                                                <div class="featured-thumb featured-thumb--img1"
                                                     style="background-image:url('{{ asset($block->image_path) }}');">
                                                    <div class="vertical-outer background-text-overlay">
                                                        <div class="vertical-inner">
                                                            @if ($block->title)
                                                                <h2 class="featured-thumb__hdr sub-main">{{ $block->title }}</h2>
                                                            @endif
                                                            @if ($block->hasLink())
                                                                {!! generateCTALinkHtml($block->cta_href, $block->cta_title, $block->hasInternalLink(), ['class' => 'featured-thumb__btn btn-secondary']) !!}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (count($fiveBlockSegment) > 0)
                                <div class="container-featured-thumb">
                                    <div class="row no-mar">
                                        @foreach ($fiveBlockSegment as $block)
                                            <div class="col-sm-2 col-20-percent boot-style">
                                                <a @if ($block->hasLink()) href="{{  $block->cta_href }}" @endif>
                                                    <div class="featured-thumb featured-thumb--img1"
                                                         style="background-image:url('{{ asset($block->image_path) }}');">
                                                        <div class="vertical-outer background-text-overlay">
                                                            <div class="vertical-inner">
                                                                @if ($block->title)
                                                                    <h2 class="featured-thumb__hdr sub-main">{{ $block->title }}</h2>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (count($userProfileCarousel) > 0)
                                <section class="sly-carousel sly-carousel-single js-full-mobile-only js-full-height"
                                         data-auto="true">
                                    <div class="sly-content featured-carousel">
                                        @foreach ($userProfileCarousel as $block)
                                            <a href="{{ $block->cta_href }}"
                                               @if (!$block->hasInternalLink()) target="_blank"
                                               @endif class="sly-item featured-carousel-single"
                                               style="background-position: center !important; background-image:url('{{ asset($block->image_path) }}');"></a>
                                        @endforeach
                                    </div>
                                    <button class="sly-prev" type="button"></button>
                                    <button class="sly-next" type="button"></button>
                                    <div class='sly-bullets'></div>
                                </section>
                            @endif

                        </section>

                        <div class="col-md-3 col-sm-12 aside-boot">
                            <div class="mobile-container-aside-labels">
                                <aside class="aside-labels section-fill section-fill--aside">

                                    <!-- MOBILE & TABLET ONLY -->
                                    <div class="aside-labels-mobile visible-sm visible-xs">
                                        <h2 class="aside-labels-mobile__hdr">Shop Great Designs by Indie Artists</h2>
                                    </div>
                                    <!---->

                                    <div class="aside-labels-input">
                                        <div class="input-grouped">
                                            <input id="search-tags" type="text" placeholder="Search Tags"
                                                   class="aside-labels-input__search"
                                                   data-url="{{ route('search.tags') }}" data-list-type="link"/>
                                            <button type="button">&nbsp;</button>
                                        </div>
                                    </div>
                                    <div class="aside-labels-alphabet">
                                        <h3 class="js-toggle-slide aside-labels-alphabet__hdr">Popular Labels</h3>
                                        <div class="js-open-content aside-labels-alphabet-list tags-list">
                                            @include('includes.tags-list', ['filterLabels' => [], 'listType' => 'link'])
                                        </div>
                                    </div>
                                </aside>
                            </div>

                            <div class="mobile-container-aside-advert">
                                <aside class="aside-advert section-fill">
                                    <img src="{{ asset('images/paper-airplane.png') }}" class="aside-advert__img"/>
                                    <h3 class="aside-advert__hdr">Upload Now!</h3>
                                    <p class="aside-advert__subhdr">Can't wait?</p>
                                    <p class="aside-advert__para">Start designing beautiful fabric right now &amp;
                                        create your account later.</p>
                                    <a class="aside-advert__btn btn-primary"
                                       href="{{ route('view.design.upload') }}"><span>Upload</span></a>
                                </aside>
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-12 no-pad hidden-sm hidden-xs">
                            <section class="featured-section-title featured-section-title--front minus-mar">
                                <h2 class="featured-section-title__hdr">Shop Great Designs by Indie Artists</h2>
                            </section>
                        </div>

                        <div class="col-md-9 col-sm-12 no-pad">
                            <div class="section-fill minus-mar">
                                <section class="products-grid label-designs-section"></section>

                                @foreach($rows as $row)
                                    @include('default.row')
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('includes.footer')
@stop

@section('end_body')
    <script type="text/javascript">
        $(function () {
            $('.tags-list').on('click', 'a.tag-filter', function (event) {
                event.preventDefault();
                var $this = $(this);
                $.get($this.data('url'), function (response) {
                    $('.label-designs-section').html(response);
                    $(document).trigger('initMagnificPopup');
                }).fail(function (error) {
                    alert(error.responseText);
                });
            });
        });
    </script>
@stop