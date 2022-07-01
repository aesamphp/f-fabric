<select id="{{ $product->category->identifier }}-select-fabric" name="material_id" class="input-fabric__dropdown" @if (request()->has('shop_price')) data-shop-price="true" @endif
    data-dropdown-url="{{ route('view.product.material.dropdown', ['id' => $product->id]) }}">
    @foreach ($productMaterials as $category  => $materialProducts)
        <optgroup label="{{ $category }}">
            @foreach($materialProducts as $materialProduct)
                <option value="{{ $materialProduct->material->id }}"
                        data-product_material="{{ $materialProduct->id }}"
                        data-product-title="{{ $materialProduct->material->title }}"
                        data-currency-symbol="{{ getCurrentCurrencySymbol() }}"
                        data-price="{{ convertPriceToCurrentCurrency($materialProduct->getPriceWithQuantityRules(request()->has('shop_price') )) }}"
                        @if(($basket && ($basket->material_id == $materialProduct->material->id)) || ($currentMaterialId === $materialProduct->material->id))
                            selected
                        @endif>

                    {{ $materialProduct->material->title .' - '. getCurrentCurrencySymbol() . convertPriceToCurrentCurrency($materialProduct->getPriceWithQuantityRules(request()->has('shop_price'), $quantity), true) }}
                </option>
            @endforeach
        </optgroup>
    @endforeach
</select>

<div class="loader hide"></div>