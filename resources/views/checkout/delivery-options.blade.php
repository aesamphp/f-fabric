<div class="row">
    <div class="col-xs-12">
        <p class="delivery-options-inner__para">@if (count($country->getDeliveryOptions()) > 0) Choose Your Delivery Option @else No Delivery Options Available @endif</p>
    </div>
</div>

@foreach ($country->getDeliveryOptions() as $key => $branding)
<div class="row">
    <div class="col-xs-10 col-md-8">
        <div class="price">
            <div class="checkbox-container">
                <input name="weight_branding_id" type="radio" id="branding-{{ $key }}" value="{{ $branding->weight_branding_id }}" />
                <span class="checkbox-overlay"></span>
                <label for="branding-{{ $key }}" class="checkbox-text">{{ $branding->branding->title }}</label>
            </div>
        </div>
    </div>
    <div class="col-xs-2 col-md-4">
        <p class="delivery-options-inner__amount">{{ getPriceText($branding->getShippingPrice($country->code, true), getCurrentCurrencySymbol()) }}</p>
    </div>
</div>
@endforeach