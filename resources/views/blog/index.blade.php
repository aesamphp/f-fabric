@section('page_title', 'New Designers and fabric print tips | Blog')
@section('page_class', 'page-blog')
@section('meta_description', 'To stay up-to-date with the latest goings on and take part in our competitions, sit down, relax and have a read over our blog. Click here to enter our world.')
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
                            <section class="featured-banner featured-banner--article no-title">
                                <h1 class="featured-banner__hdr">Fashion Formula Blog</h1>
                            </section>
                        </div>
                    </div>

                    <!-- BLOG LISTING -->
                    <div class="blog">
                        <div class="row">
                            <div class="col-md-8 col-xs-12 boot-style-1">
                                <div class="blog-listing ajax-in-results">
                                    <!-- SINGLE BLOG -->
                                    @foreach ($blogs as $article)
                                    <div class="single">
                                        <time class="blog-listing__time">{{ formatDate($article->created_at, 'F jS Y') }}</time>
                                        <h2 class="blog-listing__hdr hdr-section--minor">{{ $article->title }}</h2>
                                        <p class="blog-listing__para ellipses">{{ $article->excerpt }}</p>
                                        <div class="blog-listing__img" style="background-image: url('{{ asset($article->image_path) }}');">
                                            <a href="{{ route('view.blog.article', ['identifier' => $article->identifier]) }}" class="vertical-outer"></a>
                                        </div>
                                        <div class="blog-listing-social">
                                            <div class="row">
                                                <div class="col-xs-4 boot-style-3">
                                                    <a href="{{ route('view.blog.article', ['identifier' => $article->identifier]) }}" class="blog-listing-social__link">Continue reading ></a>
                                                </div>
                                                <div class="col-xs-8 boot-style-4">
                                                    <div class="share">
                                                        <span class="share__para">Share it</span>
                                                        <div class="social-container">
                                                            <a href="{{ getShareURL(route('view.blog.article', ['identifier' => $article->identifier]), 'facebook') }}" target="_blank" class="btn-social minor fb"></a>
                                                            <a href="{{ getShareURL(route('view.blog.article', ['identifier' => $article->identifier]), 'twitter') }}" target="_blank" class="btn-social minor tw"></a>
                                                            <a href="{{ getShareURL(route('view.blog.article', ['identifier' => $article->identifier]), 'pinterest') }}" target="_blank" class="btn-social minor pn"></a>
                                                            <a href="{{ getShareURL(route('view.blog.article', ['identifier' => $article->identifier]), 'googlePlus') }}" target="_blank" class="btn-social minor gp"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-listing-details">
                                            <div class="row">
                                                <div class="col-lg-6 col-xs-12">
                                                    <time class="blog-listing-details__time">Posted on {{ formatDate($article->created_at, 'F jS, Y') }} at {{ formatDate($article->created_at, 'h:iA') }}</time>
                                                </div>
                                                <div class="col-lg-6 col-xs-12">
                                                    <ul class="list">
                                                        <li class="item"><a href="#">Comments ({{ $article->getCommentsCount() }})</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-xs-4 boot-style-2">
                                <!-- BLOG ASIDE -->
                                <aside class="blog-aside">
                                    <div class="aside-connect-intro">
                                        <h3 class="aside-connect-intro__hdr hdr-section">Connect with us</h3>
                                        <p class="aside-connect-intro__para">Follow us and join our social media community for the latest news and design tips.</p>
                                        <div class="social-container">
                                            <a href="{{ getSettingValue('social_media/facebook_link') }}" class="btn-social fb"></a>
                                            <a href="{{ getSettingValue('social_media/twitter_link') }}" class="btn-social tw"></a>
                                            <a href="{{ getSettingValue('social_media/instagram_link') }}" class="btn-social ig"></a>
                                            <a href="{{ getSettingValue('social_media/pinterest_link') }}" class="btn-social pn"></a>
                                            <a href="{{ getSettingValue('social_media/linkedin_link') }}" class="btn-social in"></a>
                                        </div>
                                    </div>

                                    <div class="blog-aside-articles">
                                        <h3 class="blog-aside-articles__hdr hdr-section">View Articles</h3>

                                        <div class="panel-group" id="accordion">
                                            <?php $count = 0; ?>
                                            @foreach($sidebarArticles as $month => $articles)
                                                <div class="panel panel-default" id="panel-{{ camel_case($month) }}">
                                                    <div class="panel-heading">
                                                        <h4 class="blog-aside-articles__month-hdr panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion" data-target="#{{ camel_case($month) }}">{{ $month }}</a>
                                                        </h4>
                                                    </div>
                                                    <div id="{{ camel_case($month) }}" class="panel-collapse collapse {{ $count == 0 ? 'in' : '' }}">
                                                        <div class="panel-body">
                                                            <ul class="blog-aside-articles__articles">
                                                                @foreach($articles as $article)
                                                                    <li class="blog-aside-articles__article-item">
                                                                        <a href="{{ route('view.blog.article', ['identifier' => $article->identifier]) }}">{{ $article->title }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <?php $count++; ?>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="bg-bullets">
                                        <h3 class="bg-bullets__hdr hdr-section">Design Tips</h3>
                                        <div class="bg-bullets-image" style="background-image:url({{ asset('images/cooking-with-tablet.png') }});">
                                            <h3 class="bg-bullets-image__hdr">Make the most of your Fashion Formula experience</h3>
                                            <ul class="list">
                                                <li class="item">Create your own fabrics</li>
                                                <li class="item">Design your own wallpaper</li>
                                                <li class="item">Print-on-demand</li>
                                                <li class="item">Join our design community</li>
                                                <li class="item">Sell your designs</li>
                                                <li class="item">Earn commission</li>
                                                <li class="item">Learn new sewing techniques</li>
                                            </ul>
                                            <a href="{{ route('view.design.tips') }}" class="bg-bullets-image__btn btn-primary btn-primary--minor"><span>See More</span></a>
                                        </div>
                                    </div>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('includes.footer')
    @section('end_body')
        <script>
            App.functions.ajaxInResults("{{ $blogs->total() }}", "{{ route('view.blog.pagination') }}", 2000, 2);
        </script>
    @endsection
@stop