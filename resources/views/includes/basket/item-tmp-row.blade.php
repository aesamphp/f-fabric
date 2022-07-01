<li class="item">
    <a href="{{ route('view.basket.manipulate', ['id' => $item->id]) }}">
        <div class="item__img" style="background-image: url('{{ asset($item->design_images->thumbnailImagePath) }}');"></div>
        <div class="item-textarea">
            <p class="item-textarea__name">{{ $item->design_images->fileOriginalName }} (Custom Design)</p>
            <p class="item-textarea__by">{{ $item->category->title . ' - ' . $item->product->title }}</p>
            <p class="item-textarea__price">{{ $item->formatted_gross_total }}</p>
        </div>
    </a>
</li>