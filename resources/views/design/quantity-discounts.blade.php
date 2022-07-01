<h4 class="hdr-input">Quantity Discounts</h4>
@if (count($productMaterial->quantities) > 0)
    @foreach ($productMaterial->quantities as $quantity)
        <p class="input-text__info">{{ $quantity->quantity->getTitle() }} <b>{{ getCurrentCurrencySymbol() . convertPriceToCurrentCurrency(applyShopPrice($quantity->price, $apply), true) }}</b></p>
    @endforeach
@else
    <p class="input-text__info">There are no discounts available.</p>
@endif