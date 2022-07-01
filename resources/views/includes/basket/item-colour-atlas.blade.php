<li class="item">
    <a href="{{ route('view.shop.colour.atlas') }}">
        <div class="item__img" style="background-image: url('{{ asset(getColourAtlasImagePath()) }}');"></div>
        <div class="item-textarea">
            <p class="item-textarea__name">{{ $item->product->title }}</p>
            <p class="item-textarea__by">{{ $item->material->title }}</p>
            <p class="item-textarea__price">{{ $item->formatted_gross_total }}</p>
        </div>
    </a>
</li>