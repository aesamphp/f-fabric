<div id="{{ $category->identifier }}" role="tabpanel" class="tab-pane active">
  <div class="design-options-type hidden">
    <h2 class="design-options-type__hdr hdr-section--minor">Repeat your design</h2>

    <div id="design-repeat-types" class="type-image clearfix">
      @foreach ($category->designTypes as $key => $designType)
        <div class="type-image-single col-xs-5th">
          <a class="{{ str_slug($designType->designType->title) }} @if ($design->type_id == $designType->designType->id) active @endif"
            href="#" data-id="{{ $designType->designType->id }}" data-code="{{ $designType->designType->code }}"></a>
          <p class="type-image-single__para">{{ $designType->designType->title }}</p>
        </div>
      @endforeach
    </div>
  </div>

  <div class="design-options-input">

    @include('design.dpi-block')

    <div class="input-qty clearfix">
      <h3 class="input-qty__hdr hdr-input">2. Choose a Product &amp; Quantity</h3>
      <div class="col-xs-10 no-pad-left">
        <select id="product_id" name="product_id" class="js-delay-show input-product__dropdown"
          data-id="{{ $category->identifier }}-select-fabric" data-shop-price="true">
          @foreach ($category->getActiveProducts() as $key => $product)
            <option value="{{ $product->id }}" @if ($key === 0) selected @endif>{{ $product->title }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-xs-2 no-pad">
        <input type="tel" class="js-delay-show input-qty__dropdown number" name="quantity" value="1"/>
      </div>
    </div>

    <div class="input-fabric">
      <h3 class="input-fabric__hdr hdr-input">
        3. Choose a {{ str_singular($category->title) }}
        <a class="pull-right" href="{{ route('view.products') }}" target="_blank">Help?</a>
      </h3>
      <select id="{{ $category->identifier }}-select-fabric"
        class="js-delay-show input-fabric__dropdown hidden"></select>
    </div>

    <div class="input-total clearfix">
      <div id="quantity-discounts" class="col-xs-12 col-sm-6 block-discount text-center"></div>
      <div class="col-xs-12 col-sm-6 block-total">
        <div class="boot-style-1 col-xs-12">
          <h4 class="input-price__hdr full-width hdr-section--minor">Unit Price: {{ getCurrentCurrencySymbol() }}<span>0.00</span>
          </h4>
          <h3 class="input-total__hdr full-width hdr-section--minor">TOTAL: {{ getCurrentCurrencySymbol() }}
            <span>0.00</span></h3>
        </div>
        <div class="boot-style-3 col-xs-6 col-sm-12 pull-right">
          <button class="input-total__btn btn-primary btn-primary--minor btn-add-to-cart" type="submit" disabled>
            <span>Add to cart</span>
          </button>
        </div>
      </div>
    </div>
    <h3 class="input-text__minor-hdr hdr-input">Product Description</h3>
    <p class="input-text__info @if ($design->additional_details === null) no-padding-bottom @endif">{{ $design->description }}</p>

    @if ($design->additional_details)
      <p class="input-text__info padding-top border-top">{{ $design->additional_details }}</p>
    @endif

  </div>
</div>
<input type="hidden" name="category_id" value="{{ $category->id }}"/>