<aside class="aside-list" data-match="height">
    <h2 class="aside-list__hdr hdr-section--minor">Design Tips</h2>
    <p class="aside-list__para para-side">Make the most of your Fashion Formula experience</p>
    <ul class="aside-list-list">
        @foreach ($categories as $category)
        <li class="item"><a href="{{ route('view.design.tips.category', ['category' => $category->identifier]) }}">{{ $category->title }}</a></li>
        @endforeach
    </ul>
</aside>