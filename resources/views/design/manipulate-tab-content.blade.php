<div id="{{ $category->identifier }}" role="tabpanel" class="tab-pane active">
  <div class="design-options-type">
    <h2 class="design-options-type__hdr hdr-section--minor">Repeat your design</h2>

    <div id="design-repeat-types" class="type-image clearfix">
      @foreach ($category->designTypes as $key => $designType)
        <div class="type-image-single col-xs-5th">
          <a
            class="{{ str_slug($designType->designType->title) }}@if ($basket) @if ($basket->design_type_id == $designType->designType->id) active @endif @elseif ($key === 0) active @endif"
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
        <select id="product_id" name="product_id" class="input-product__dropdown"
          data-id="{{ $category->identifier }}-select-fabric" data-shop-price="false"
          @if ($basket) data-basket="{{ $basket->id }}" @endif>
          @foreach ($category->getActiveProducts() as $key => $product)
            <option value="{{ $product->id }}"
              @if ($basket)
                @if ($basket->product_id == $product->id)
                  selected
                @endif
              @elseif ($key === 0)
                selected
              @endif
            >
              {{ $product->title }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-xs-2 no-pad">
        <input type="tel" class="input-qty__dropdown number" name="quantity"
          value="{{ $basket ? $basket->quantity : '1' }}"/>
      </div>
    </div>

    <div class="input-fabric">
      <h3 class="input-fabric__hdr hdr-input">
        3. Choose a {{ str_singular($category->title) }}
        <a class="pull-right" href="{{ route('view.products') }}" target="_blank">Help?</a>
      </h3>
      <select id="{{ $category->identifier }}-select-fabric" class="input-fabric__dropdown hidden"></select>
    </div>

    <div class="input-total clearfix">
      <div id="quantity-discounts" class="col-xs-12 col-sm-6 block-discount text-center"></div>
      <div class="col-xs-12 col-sm-6 block-total">
        <div class="col-xs-12 no-pad-left-sm no-pad">
          <h4 class="input-price__hdr full-width hdr-section--minor">Unit Price: {{ getCurrentCurrencySymbol() }}
            <span>0.00</span></h4>
          <h3 class="input-total__hdr full-width hdr-section--minor">TOTAL: {{ getCurrentCurrencySymbol() }}
            <span>{{ $basket ? getBasketGrandTotal() : '0.00' }}</span></h3>
        </div>
        <div class="col-xs-6 col-sm-12 no-pad-right-sm no-pad pull-right">
          <button class="input-total__btn btn-primary btn-add-to-cart" type="submit" disabled><span>Add to cart</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="category_id" value="{{ $category->id }}"/>