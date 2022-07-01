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