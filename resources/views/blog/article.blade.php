@section('page_title', $article->title)
@section('page_class', 'page-blog-single')


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
                                
                                <a href="{{ route('view.blog') }}" class="blog__link link-back">Back to blog</a>

                                <div class="blog-listing blog-listing--border-top">
                                    @include('includes.flash')
                                    <!-- SINGLE BLOG -->
                                    <div class="single">
                                        <time class="blog-listing__time">{{ formatDate($article->created_at, 'F jS Y') }}</time>
                                        <h2 class="blog-listing__hdr hdr-section--minor">{{ $article->title }}</h2>
                                        <div class="article-content">{!! $article->content !!}</div>
                                        @if ($article->tags)
                                        <p>Tags: {{ $article->tags }}</p>
                                        @endif
                                    </div>

                                    <div class="comments">

                                        <h2 class="comments__hdr hdr-section--minor">Comments</h2>

                                        <div class="comments-form clearfix">
                                            <h3 class="comments-form__hdr hdr-section--minor">Add your comment</h3>
                                            <span class="js-popup-btn comments-form__link">Share your image</span>
                                            <form method="POST" action="{{ route('store.blog.article.comment', ['id' => $article->id]) }}" autocomplete="off">
                                                {{ csrf_field() }}
                                                <textarea name="content" class="comments-form__textarea" cols="30" rows="7"@if (!isCustomerUser()) disabled @endif>@if (isCustomerUser()) {{ old('content') }} @else {{ '(Login to post a comment)' }} @endif</textarea>
                                                <button class="comments-form__btn btn-primary btn-primary--minor" type="submit"@if (!isCustomerUser()) disabled @endif>
                                                    <span>Post Comment</span>
                                                </button>
                                            </form>
                                        </div>

                                        @foreach ($article->comments as $comment)
                                        <div class="comments-single clearfix">
                                            <h3 class="comments-single__name hdr-section--minor">{{ $comment->user->username }}</h3>
                                            <time class="comments-single__time">{{ formatDate($comment->created_at, 'd/m/Y') }}</time>
                                            <p class="comments-single__para">{{ $comment->content }}</p>
                                            @if (isCustomerUser() && !$comment->isOwner() && !$comment->isReported())
                                            <a href="{{ route('report.comment', ['id' => $comment->id]) }}" class="js-popup-btn comments-single__link" data-id="report-comment-popup">Report Comment</a>
                                            @endif
                                        </div>
                                        @endforeach
                                        
                                    </div>

                                    <div class="blog-listing-social">
                                        <div class="row">
                                            <div class="col-xs-8 col-xs-push-4 boot-style-4">
                                                <div class="share">
                                                    <span class="share__para">Share it</span>  
                                                    <div class="social-container">
                                                        <a href="{{ getShareURL(Request::url(), 'facebook') }}" target="_blank" class="btn-social minor fb"></a>
                                                        <a href="{{ getShareURL(Request::url(), 'twitter') }}" target="_blank" class="btn-social minor tw"></a>
                                                        <a href="{{ getShareURL(Request::url(), 'pinterest') }}" target="_blank" class="btn-social minor pn"></a>
                                                        <a href="{{ getShareURL(Request::url(), 'googlePlus') }}" target="_blank" class="btn-social minor gp"></a>
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
                                            <a href="{{ getSettingValue('social_media/youtube_link') }}" class="btn-social yt"></a>
                                            <a href="{{ getSettingValue('social_media/instagram_link') }}" class="btn-social ig"></a>
                                            <a href="{{ getSettingValue('social_media/linkedin_link') }}" class="btn-social in"></a>
                                        </div>
                                    </div> 

                                    <div class="blog-aside-articles">
                                        <h3 class="blog-aside-articles__hdr hdr-section">View Articles</h3>

                                        <div class="panel-group" id="accordion">
                                            @foreach($sidebarArticles as $month => $articles)
                                                <div class="panel panel-default" id="panel1">
                                                    <div class="panel-heading">
                                                        <h4 class="blog-aside-articles__month-hdr panel-title">
                                                            <a data-toggle="collapse" data-target="#collapseOne" href="#collapseOne">{{ $month }}</a>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <ul class="blog-aside-articles__articles">
                                                            @foreach($articles as $article)
                                                                <li class="blog-aside-articles__article-item">
                                                                    <a href="{{ $article->identifier }}">{{ $article->title }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
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
                                                <li class="item">Earn commision</li>
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

<div class="js-popup popup">
    <div class="darkenator js-popup-cancel"></div>
    <div class="upload-popup">
        <div class="row">
            <div class="col-xs-8 col-sm-6">
                <h2 class="upload-popup__hdr hdr-section--minor">Share your image</h2>
            </div>
            <div class="col-xs-4 col-sm-6">
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
                <input type="hidden" name="type_id" value="{{ getClassConstantValue('App\Models\ReportedComment::TYPE_BLOG_ARTICLE') }}" />
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