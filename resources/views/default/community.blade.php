@section('page_title', 'Digital Fabric Printing | Community')
@section('page_class', 'community-page')
@section('meta_description', 'The Fashion Formula community is a great place for designers to connect with one another and discuss the designs they love. Click here to join in with the fun.')
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
                            <section class="featured-banner featured-banner--details no-title">
                                <h1 class="featured-banner__hdr">Fashion Formula Community</h1>
                            </section>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">@include('includes.flash')</div>
                    </div>

                    <div class="row inner-section-whole">
                        <div class="col-md-8 col-sm-12">
                            
                            <!-- WEEKLY CONTEST -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <section class="double-rows double-rows-carousel">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h2 class="double-rows__hdr hdr-section">Weekly Contest</h2>
                                                @if (count($contestDesigns) > 0)
                                                <a href="{{ route('view.weekly.contest') }}" class="double-rows__link link-side">View all</a>
                                                @endif
                                                <section class="double-rows-carousel products-grid-likes">
                                                    @if ($contestDesigns)
                                                    <h4 class="hdr-aside no-pad-bottom">{{ $liveContest->title }}</h4>
                                                    <p class="para-main">{{ $liveContest->excerpt }}</p>
                                                    <p class="brief-descriptions-single__para">Ending {{ formatDate($liveContest->to_date, 'jS F Y') }}</p>
                                                        @if (count($contestDesigns) > 0)
                                                        <div class="products-grid">
                                                            <div class="sly-carousel" data-controls-outside="true" data-cycle-by="pages">
                                                                <div class="sly-content clearfix">
                                                                    @foreach ($contestDesigns as $design)
                                                                    <div class="sly-item">
                                                                        <div class="item-carousel__list-item">
                                                                            <div class="products-grid-tile">
                                                                                @if ($design->isShoppable())
                                                                                <a class="link-area" href="{{ route('view.shop.design', ['designIdentifier' => $design->identifier]) }}"></a>
                                                                                @endif
                                                                                <div class="product-thumbnail" style="background-image: url('{{ asset($design->getThumbnailImagePath()) }}');"></div>
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
                                                                                <div class="info info-likes">
                                                                                    <div class="vertical-outer">
                                                                                        <div class="vertical-inner">
                                                                                            <div class="info-left">
                                                                                                <p class="info-left__type">{{ $design->title }}</p>
                                                                                                <p class="info-left__author">by <a href="{{ route('view.designer.store', ['username' => $design->user->studio->username]) }}">{{ $design->user->username }}</a></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="info-right">
                                                                                        @if ($design->isLikeable())
                                                                                        <a class="btn-like-design @if ($design->hasLiked()) active @endif" href="{{ route('like.design', ['id' => $design->id]) }}">
                                                                                            @if ($design->hasLiked())
                                                                                            <img class="info-right__img" src="{{ asset('images/svgs/like-highlight.svg') }}" alt="Like Design" />
                                                                                            @else
                                                                                            <img class="info-right__img" src="{{ asset('images/svgs/like.svg') }}" alt="Like Design" />
                                                                                            @endif
                                                                                            <span class="info-right__number">{{ $design->getContestLikesCount() }}</span>
                                                                                        </a>
                                                                                        @else
                                                                                        <a href="#" class="js-popup-btn" data-id="authentication-required-popup">
                                                                                            <img class="info-right__img" src="{{ asset('images/svgs/like.svg') }}" alt="Like Design" />
                                                                                            <span class="info-right__number">{{ $design->getContestLikesCount() }}</span>
                                                                                        </a>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <button class="sly-prev sly-prev--pickout minor" type="button"></button>
                                                            <button class="sly-next sly-next--pickout minor" type="button"></button>
                                                        </div>
                                                        @else
                                                        <h4>Currently there is no designs participating in this contest</h4>
                                                        @endif
                                                    @else
                                                    <h4>Currently there is no live contest</h4>
                                                    @endif
                                                </section>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>

                            <!-- BLOG ARTICLES -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="blog-carousel">
                                        <h2 class="blog-carousel__hdr hdr-section">Blog Articles</h2>
                                        <a href="{{ route('view.blog') }}" class="link-side">View all</a>
                                        <div class="sly-carousel" data-controls-outside="true" data-cycle-by="pages">
                                            <div class="sly-content clearfix">
                                                @foreach (getBlogArticles(4) as $article)
                                                <div class="sly-item">
                                                    <div class="blog-carousel-list__item blog-item">
                                                        <div class="blog-item__img"  style="background-image: url('{{ asset($article->image_path) }}');"></div>
                                                        <div class="blog-item-textarea clearfix">
                                                            <h3 class="blog-item-textarea__hdr hdr-section">{{ $article->title }}</h3>
                                                            <time class="blog-item-textarea__time">Article posted on {{ formatDate($article->created_at, 'd/m/Y') }}</time>
                                                            <p class="blog-item-textarea__para">{{ $article->excerpt }}</p>
                                                            <a href="{{ route('view.blog.article', ['identifier' => $article->identifier]) }}" class="blog-item-textarea__link">Read more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button class="sly-prev sly-prev--pickout minor" type="button"></button>
                                        <button class="sly-next sly-next--pickout minor" type="button"></button>
                                    </div>
                                </div>
                            </div>

                            <!-- TWO SECTIONS -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="two-sections clearfix" data-match="container-widescreen-only">

                                        <!-- DESIGN TIPS -->
                                        <div class="col-lg-6 col-md-12 boot-style-1">
                                            <div class="bg-bullets" data-match="height">
                                                <h3 class="bg-bullets__hdr hdr-section">Design Tips</h3>
                                                <div class="bg-bullets-image" style="background-image: url('{{ asset('images/cooking-with-tablet.png') }}');">
                                                    <h3 class="bg-bullets-image__hdr">Make the most of your Fashion Formula experience</h3>
                                                    <ul class="list">
                                                        <li class="item">Create your own fabrics</li>
                                                        <li class="item">Design your own wallpaper</li>
                                                        <li class="item">Print-on-demand</li>
                                                        <li class="item">Join our design community</li>
                                                        <li class="item">Sell your designs</li>
                                                        <li class="item">Earn commision</li>
                                                        <li class="item">Learn new sewing techniques</li>
                                                    </ul>
                                                    <a href="{{ route('view.design.tips') }}" class="bg-bullets-image__btn btn-primary btn-primary--minor"><span>See More</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- UPCOMING CONTESTS -->
                                        <div class="col-lg-6 col-md-12 boot-style-2">
                                            <div class="brief-descriptions" data-match="height">
                                                <h3 class="brief-descriptions__hdr hdr-section">Upcoming Contests</h3>
                                                @foreach ($upcomingContests as $contest)
                                                <div class="brief-descriptions-single">
                                                    <h4 class="brief-descriptions-single__hdr">{{ $contest->title }}</h4>
                                                    <p class="para-main">{{ $contest->excerpt }}</p>
                                                    <p class="brief-descriptions-single__para">Starting {{ formatDate($contest->from_date, 'jS F Y') }}</p>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <aside class="aside-connect">
                                <div class="aside-connect-intro">
                                    <h2 class="aside-connect-intro__hdr hdr-section">Connect with us</h2>
                                    <p class="aside-connect-intro__featured-para">Follow us on social media to discover inspiring projects and how-tos, and to share your thoughts and ideas with us. Participate in our weekly Design Challenge by submitting an entry, or voting for your favorite prints. </p>
                                    <p class="aside-connect-intro__para">Browse the marketplace and connect with indie designers by favoriting or commenting on designs you love. Watch how the connections you make inspire, support and spark your creativity!</p>
                                    <div class="social-container">
                                        <a href="{{ getSettingValue('social_media/facebook_link') }}" class="btn-social fb" target="_blank"></a>
                                        <a href="{{ getSettingValue('social_media/twitter_link') }}" class="btn-social tw" target="_blank"></a>
                                        <a href="{{ getSettingValue('social_media/pinterest_link') }}" class="btn-social pn" target="_blank"></a>
                                        <a href="{{ getSettingValue('social_media/linkedin_link') }}" class="btn-social in" target="_blank"></a>
                                        <a href="{{ getSettingValue('social_media/instagram_link') }}" class="btn-social ig" target="_blank"></a>
                                    </div>
                                </div>

                                <div class="aside-connect-instagram">
                                    <h2 class="aside-connect-instagram__hdr hdr-section hdr-social">Instagram</h2>
                                    <p class="aside-connect-instagram__para">Follow us on Instagram for the latest design and project inspiration</p>
                                    <div class="instagram-picture">
                                        <div class="instagram-picture__img" style="background-image:url('{{ asset('images/woman-in-glasses.png') }}');"></div>
                                        <p class="instagram-picture__para hdr-section">Share your inspiration using <a href="{{ getSettingValue('social_media/instagram_link') }}" target="_blank">#fashionformulauk</a></p>
                                    </div>
                                </div>

                                <div class="aside-connect-twitter">
                                    <h2 class="aside-connect-twitter__hdr hdr-section hdr-social">Twitter</h2>
                                    <p class="aside-connect-twitter__para">Follow us on Twitter for real-time news and tutorials <a href="{{ getSettingValue('social_media/twitter_link') }}" target="_blank">@fashion_formula</a></p>
                                    @foreach ($tweets as $tweet)
                                    <div class="single-tweet">
                                        <span class="single-tweet__img"  style="background-image:url('{{ $tweet->user->profile_image_url }}');"></span>
                                        <p class="single-tweet__para">{!! $tweet->text !!}</p>
                                        <time class="single-tweet__time">Posted {{ timeToAgo($tweet->created_at) }}</time>
                                    </div>
                                    @endforeach
                                </div>
                            </aside>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</main>

@include('includes.footer')
@stop