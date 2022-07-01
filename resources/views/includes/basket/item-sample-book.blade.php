<li class="item">
    <a href="{{ route('view.shop.sample.books') }}">
        <div class="item__img" style="background-image: url('{{ asset(getSampleBookImagePath()) }}');"></div>
        <div class="item-textarea">
            <p class="item-textarea__name">{{ $item->product->title }}</p>
            <p class="item-textarea__price">{{ $item->formatted_gross_total }}</p>
        </div>
    </a>
</li>