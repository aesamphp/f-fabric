<?php $basketItemsCount = getBasketItemsCount(); ?>
<span class="notification">{{ $basketItemsCount }}</span>
<div class="hover-init">
    <img class="header-rightside-basket__img" src="{{ asset('images/svgs/cart.svg') }}" alt="Basket" />
    @if ($basketItemsCount > 0)
    <div class="menu menu-basket">
        <h3 class="menu-basket__hdr">Your basket</h3>
        <ul class="menu-basket-list">
            @foreach (getBasketItems() as $item)
                @if (isBasketItemAColourAtlas($item))
                    @include('includes.basket.item-colour-atlas')
                @elseif (isBasketItemASampleBook($item))
                    @include('includes.basket.item-sample-book')
                @elseif (isBasketItemAPlainFabric($item))
                    @include('includes.basket.item-plain-fabric')
                @else
                    @if (isBasketItemASavedDesign($item))
                        @include('includes.basket.item-row')
                    @else
                        @include('includes.basket.item-tmp-row')
                    @endif
                @endif
            @endforeach
        </ul>
        <div class="menu-basket-ctas">
            <a href="{{ route('view.basket') }}" class="menu-basket-ctas__link link-arrow">View full basket</a>
            <a href="{{ route('view.checkout.billing.address') }}" class="menu-basket-ctas__btn btn-primary btn-primary--no-border">
                <span>Checkout Securely</span>
            </a>
        </div>
    </div>
    @endif
</div>

<script type="text/javascript">
    var element = document.getElementById('mobile-basket-count');
    element.innerHTML = '{{ $basketItemsCount }}';
</script>