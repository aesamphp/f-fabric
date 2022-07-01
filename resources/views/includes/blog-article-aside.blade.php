@foreach ($articles as $article)
<aside class="aside-featured-blog">
    <h2 class="aside-featured-blog__hdr hdr-section--minor">Blog Article</h2>
    <div class="blog-item blog-item--aside">
        <div class="blog-item__img" style="background-image:url('{{ asset($article->image_path) }}');"></div>
        <div class="blog-item-textarea clearfix">
            <h3 class="blog-item-textarea__hdr hdr-section">{{ $article->title }}</h3>
            <time class="blog-item-textarea__time">Article posted on {{ formatDate($article->created_at, 'd/m/Y') }}</time>
            <p class="blog-item-textarea__para">{{ $article->excerpt }}</p>
            <a href="{{ route('view.blog.article', ['identifier' => $article->identifier]) }}" class="blog-item-textarea__link">Read more</a>
        </div>
    </div>
</aside>
@endforeach