<div id="{{ $category->identifier }}" role="tabpanel" class="tab-pane active">
  <div class="design-options-type">
    <h2 class="design-options-type__hdr hdr-section--minor">Repeat your design</h2>

    <div id="design-repeat-types" class="type-image clearfix">
      @foreach ($category->designTypes as $key => $designType)
        <div class="type-image-single col-xs-5th">
          <a
            class="{{ str_slug($designType->designType->title) }}@if ($basket) @if ($basket->design_type_id == $designType->designType->id) active @endif @elseif ($design->type_id == $designType->designType->id) active @endif"
            href="#" data-id="{{ $designType->designType->id }}" data-code="{{ $designType->designType->code }}"></a>
          <p class="type-image-single__para">{{ $designType->designType->title }}</p>
        </div>
      @endforeach
    </div>
  </div>

  <div class="design-options-input">

    @include('design.dpi-block')

    <div class="input-qty clearfix">
      <h3 class="input-qty__hdr hdr-input">2. Choose a Size &amp; Amount</h3>
      <div class="col-xs-10 no-pad-left">
        <select id="product_id" name="product_id" class="js-delay-show input-product__dropdown"
                data-id="{{ $category->identifier }}-select-fabric" @if ($basket) data-basket="{{ $basket->id }}"@endif>
          @foreach ($activeproducts as $key => $product)
            <option value="{{ $product->id }}" @if ($basket) @if ($basket->product_id == $product->id) selected
                    @endif @elseif ($key === 0) selected @endif>{{ $product->title }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-xs-2 no-pad">
        <input type="tel" class="js-delay-show input-qty__dropdown number" name="quantity"
               @if ($basket) value="{{ $basket->quantity }}" @else value="1"@endif />
      </div>
    </div>

    <div class="input-fabric">
      <h3 class="input-fabric__hdr hdr-input">3. Choose a {{ str_singular($category->title) }}</h3>
      <select id="{{ $category->identifier }}-select-fabric"
              class="js-delay-show input-fabric__dropdown hidden"></select>
    </div>

    <div class="input-total clearfix">
      <div class="boot-style-1 col-xs-12">
        <h4 class="input-price__hdr full-width hdr-section--minor">Unit Price: {{ getCurrentCurrencySymbol() }}
          <span>@if ($basket) {{ getBasketItemUnitPrice($basket->id) }} @else 0.00 @endif</span></h4>
        <h3 class="input-total__hdr full-width hdr-section--minor">TOTAL: {{ getCurrentCurrencySymbol() }}
          <span>@if ($basket) {{ getBasketItemPrice($basket->id) }} @else 0.00 @endif</span></h3>
      </div>
      <div class="boot-style-2 col-xs-6">
        <p
          class="input-total__status @if ($design->hasPurchasedSwatch()){{ 'purchased' }}@else{{ 'not-purchased' }}@endif">@if ($design->hasPurchasedSwatch()){{ 'Sample Purchased' }}@else{{ 'Not Purchased' }}@endif</p>
      </div>
      <div class="boot-style-3 col-xs-6">
        <button class="input-total__btn btn-primary btn-primary--minor btn-add-to-cart" type="submit" disabled><span>Add to cart</span>
        </button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="category_id" value="{{ $category->id }}"/>