<li class="item">
    @if (isCustomerUser() && $item->design->isOwner(getAuthenticatedUser()->id))
    <a href="{{ route('view.basket.design', ['id' => $item->design_id, 'basketId' => $item->id]) }}">
    @else
    <a href="{{ route('view.shop.design', ['designIdentifier' => $item->design->identifier]) }}">
    @endif
        <div class="item__img" style="background-image: url('{{ asset($item->design->getThumbnailImagePath()) }}');"></div>
        <div class="item-textarea">
            <p class="item-textarea__name">{{ $item->design->title }}</p>
            <p class="item-textarea__by">{{ $item->category->title . ' - ' . $item->product->title }}</p>
            <p class="item-textarea__by">by {{ $item->design->user->username }}</p>
            <p class="item-textarea__price">{{ $item->formatted_gross_total }}</p>
        </div>
    </a>
</li>