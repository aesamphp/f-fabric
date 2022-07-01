<?php

namespace App\Models;

use Illuminate\Http\Response;

class Basket
{
    public $id;
    public $design_saved;
    public $design_request_public;
    public $design_id;
    public $design_type_id;
    public $category_id;
    public $product_id;
    public $material_id;
    public $dpi;
    public $quantity;
    public $colour_atlas;
    public $sample_book;
    public $plain_fabric;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'design_saved',
        'design_request_public',
        'design_id',
        'design_type_id',
        'category_id',
        'product_id',
        'material_id',
        'dpi',
        'quantity',
        'colour_atlas',
        'sample_book',
        'plain_fabric',
    ];

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'design_saved' => 'required|boolean',
            'design_request_public' => 'required_if:design_saved,1|boolean',
            'design_id' => 'required_if:design_saved,1|integer',
            'design_type_id' => 'required|integer',
            'category_id' => 'required|integer',
            'product_id' => 'required|integer',
            'material_id' => 'required_unless:sample_book,1|integer',
            'dpi' => 'required|numeric|min:150',
            'quantity' => 'required|integer|min:1|max:500',
            'colour_atlas' => 'required|boolean',
            'sample_book' => 'required|boolean',
            'plain_fabric' => 'required|boolean',
        ];
    }

    /**
     * Set model validation rules.
     *
     * @return array
     */
    public function updateRules()
    {
        return [
            'quantity' => 'required|integer|min:1|max:500',
        ];
    }

    /**
     * Set model validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required_unless' => 'The :attribute is required.',
            'quantity.max' => 'For :attribute over :max please <a href="' . route('view.contact') . '" target="_blank">contact us</a>.',
        ];
    }

    /**
     * Create's a new basket item.
     *
     * @param array $data
     */
    public function create(Array $data = [])
    {
        $this->fill($data);
        $this->save();
    }

    /**
     *
     * @param int $id
     * @param array $data
     */
    public function update($id, $data)
    {
        $basket = $this->getBasketItems();
        if ($basket) {
            foreach ($basket as $key => $item) {
                if ($item->id == $id) {
                    $basket[$key] = $this->updateItem($item, $data);
                }
            }
            session()->put('basket', $basket);
        }
    }

    /**
     * @return bool
     */
    public static function updateDiscount()
    {
        $basket = session()->get('basket');

        if (!$basket) {
            return false;
        }

        $quantities = [];

        foreach ($basket as $key => $item) {
            if (array_key_exists($item->material_id, $quantities)) {
                $quantities[$item->material_id] = $quantities[$item->material_id] + $item->quantity;
                continue;
            }

            $quantities[$item->material_id] = $item->quantity;
        }

        foreach ($basket as $key => $item) {
            $productMaterial = ProductMaterial::whereProductId($item->product_id)
                ->whereMaterialId($item->material_id)
                ->firstOrFail();

            $price = $productMaterial->price;

            if ($productMaterial->hasQuantityRules()) {
                foreach ($productMaterial->quantities as $quantityRule) {
                    $price = $quantityRule->applyQuantityRulePrice($price, $quantities[$item->material_id]);
                }
            }

            $item->actual_gross_price = applyShopPrice($price, isset($item->actual_gross_price) ? true : false);
            $item->actual_vat = calculateVAT($item->actual_gross_price);
            $item->actual_net_price = $item->actual_gross_price - $item->actual_vat;
            $item->actual_gross_total = $item->quantity * $item->actual_gross_price;
            $item->actual_net_total = $item->quantity * $item->actual_net_price;
            $item->gross_price = convertPriceToCurrentCurrency($item->actual_gross_price);
            $item->vat = calculateVAT($item->gross_price);
            $item->net_price = $item->gross_price - $item->vat;
            $item->gross_total = $item->quantity * $item->gross_price;
            $item->net_total = $item->quantity * $item->net_price;
            $item->formatted_gross_total = getCurrentCurrencySymbol() . formatPrice($item->gross_total);

            $basket[$key] = $item;
        }

        session()->put('basket', $basket);
    }

    /**
     * Deletes the basket item.
     *
     * @param int $id
     */
    public function delete($id)
    {
        $newBasket = [];
        $basket = $this->getBasketItems();
        if ($basket) {
            $i = 1;
            foreach ($basket as $item) {
                if ($item->id != $id) {
                    $item->id = $i;
                    $newBasket[] = $item;
                    $i++;
                }
            }
            if (empty($newBasket)) {
                session()->forget('basket');
                session()->forget('discountCodeId');
            } else {
                session()->put('basket', $newBasket);
            }
        }
    }

    /**
     * Returns the basket item.
     *
     * @param int $id
     *
     * @return array
     */
    public static function find($id)
    {
        $basketItem = null;
        $basket = static::getBasketItems();
        if ($basket) {
            foreach ($basket as $item) {
                if ($item->id == $id) {
                    $basketItem = $item;
                }
            }
        }

        return $basketItem;
    }

    /**
     * Returns the basket item or throws not found exception.
     *
     * @param int $id
     *
     * @return array
     * @throws NotFoundHttpException
     */
    public static function findOrFail($id)
    {
        $basketItem = static::find($id);
        if ($basketItem === null) {
            abort(Response::HTTP_NOT_FOUND, 'No query results for model [' . get_class(new static) . '] ' . $id);
        }

        return $basketItem;
    }

    /**
     * Returns the basket items.
     *
     * @return array
     */
    public static function getBasketItems()
    {
        $basket = session()->get('basket');
        if ($basket) {
            foreach ($basket as $key => $item) {
                $basket[$key] = static::buildItem($item);
            }
        }

        return $basket;
    }

    /**
     * Returns the basket items count.
     *
     * @return int
     */
    public static function getBasketItemsCount()
    {
        $basket = static::getBasketItems();

        return ($basket === null) ? 0 : count($basket);
    }

    /**
     * Returns the basket actual sub total.
     *
     * @return float
     */
    public static function getBasketActualSubtotal($formatPrice = false)
    {
        $price = 0;
        $basket = static::getBasketItems();
        if (is_null($basket)) {
            return $price;
        }
        foreach ($basket as $item) {
            $price += $item->actual_net_total;
        }

        return $formatPrice === true ? formatPrice($price) : $price;
    }

    /**
     * Returns the basket sub total.
     *
     * @return float
     */
    public static function getBasketSubtotal($formatPrice = false)
    {
        $price = 0;
        $basket = static::getBasketItems();
        if (is_null($basket)) {
            return $price;
        }
        foreach ($basket as $item) {
            $price += $item->net_total;
        }

        return $formatPrice === true ? formatPrice($price) : $price;
    }

    /**
     * Returns the basket sub total.
     *
     * @return float
     */
    public static function getBasketGrandTotalForDeliveryOptions()
    {
        return formatPrice(collect(static::getBasketItems())->sum('actual_gross_total'));
    }

    /**
     * Returns the actual calculated vat of basket.
     *
     * @param boolean $formatPrice
     *
     * @return float
     */
    public static function getBasketActualVat($formatPrice = false)
    {
        $price = 0;
        $billingAddress = session()->get('checkoutBillingAddress');
        if (is_null($billingAddress) || isEUCountry($billingAddress->country)) {
            $price = getShippingActualVAT();
            $basket = static::getBasketItems();
            if (is_null($basket)) {
                return $price;
            }
            foreach ($basket as $item) {
                $price += $item->quantity * $item->actual_vat;
            }
        }

        return $formatPrice === true ? formatPrice($price) : $price;
    }

    /**
     * Returns the calculated vat of basket.
     *
     * @param boolean $formatPrice
     *
     * @return float
     */
    public static function getBasketVat($formatPrice = false)
    {
        $price = 0;
        if (shouldPayVAT()) {
            $price = getShippingVAT();
            $basket = static::getBasketItems();
            if (is_null($basket)) {
                return $price;
            }
            foreach ($basket as $item) {
                $price += $item->quantity * $item->vat;
            }
        }

        return $formatPrice === true ? formatPrice($price) : $price;
    }

    /**
     * Return's basket total.
     *
     * @param boolean $formatPrice
     *
     * @return float
     */
    public static function getBasketTotal($formatPrice = false)
    {
        $price = setNumberDecimals(static::getBasketSubtotal() + static::getBasketVat() + getShippingNetPrice());

        return $formatPrice === true ? formatPrice($price) : $price;
    }

    /**
     * Return's basket grand total.
     *
     * @param boolean $formatPrice
     *
     * @return float
     */
    public static function getBasketGrandTotal($formatPrice = false)
    {
        $price = static::getBasketTotal() - getDiscountAmount();

        return $formatPrice === true ? formatPrice($price) : $price;
    }

    /**
     * Returns the basket item weight.
     *
     * @param int $id
     *
     * @return float
     */
    public static function getBasketItemWeight($id)
    {
        $item = static::findOrFail($id);

        return $item->weight;
    }

    /**
     * Returns the basket weight.
     *
     * @return float
     */
    public static function getBasketWeight()
    {
        $weight = 0;
        $basket = static::getBasketItems();
        foreach ($basket as $item) {
            $weight += $item->weight;
        }

        return $weight;
    }

    /**
     * Returns the basket items quantity.
     *
     * @return int
     */
    public static function getBasketItemsQuantity()
    {
        $quantity = 0;
        $basket = static::getBasketItems();
        foreach ($basket as $item) {
            $quantity += $item->quantity;
        }

        return $quantity;
    }

    /**
     * Returns if the basket item is a saved design or not.
     *
     * @param array $item
     *
     * @return boolean
     */
    public static function isSavedDesign($item)
    {
        return $item->design_saved == 1;
    }

    /**
     * Returns if the basket design item has requested public or not.
     *
     * @param array $item
     *
     * @return boolean
     */
    public static function hasRequestedPublic($item)
    {
        return $item->design_request_public == 1;
    }

    /**
     * Returns if the basket item is a colour atlas or not.
     *
     * @param array $item
     *
     * @return boolean
     */
    public static function isColourAtlas($item)
    {
        return $item->colour_atlas == 1;
    }

    /**
     * Returns if the basket item is a sample book or not.
     *
     * @param array $item
     *
     * @return boolean
     */
    public static function isSampleBook($item)
    {
        return $item->sample_book == 1;
    }

    /**
     * Returns if the basket item is a plain fabric or not.
     *
     * @param array $item
     *
     * @return boolean
     */
    public static function isPlainFabric($item)
    {
        return $item->plain_fabric == 1;
    }

    /**
     * Returns if the basket item is a design or not.
     *
     * @param array $item
     *
     * @return boolean
     */
    public static function isDesign($item)
    {
        return !static::isColourAtlas($item) && !static::isSampleBook($item) && !static::isPlainFabric($item);
    }

    /**
     * Fills the model attributes value.
     *
     * @param array $data
     */
    private function fill(Array $data = [])
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->$key = $value;
            }
        }
        $this->id = $this->getBasketItemsCount() + 1;
        if ($this->design_saved == 0) {
            $this->design_id = 'tmp-' . date('d-m-Y-H-i-s');
        }
    }

    /**
     * Saves the basket items.
     */
    private function save()
    {
        $newBasket = [];
        $basket = $this->getBasketItems();
        if ($basket === null) {
            $newBasket[] = (object)$this->toArray();
        } else {
            $newBasket = array_merge($basket, [(object)$this->toArray()]);
        }
        session()->put('basket', $newBasket);
    }

    /**
     * Returns the model attributes as an array.
     *
     * @return array
     */
    private function toArray()
    {
        $array = [];
        foreach ($this->fillable as $attribute) {
            $array[$attribute] = $this->$attribute;
        }
        $array['design_images'] = $this->isSavedDesign($this) ? Design::findOrFail($this->design_id)->getDesignImages() : session()->get('designImages');
        $array['weight'] = Product::findOrFail($this->product_id)->getWeight($this->material_id) * $this->quantity;

        return $array;
    }

    /**
     * Update's a basket item.
     *
     * @param array $item
     * @param array $data
     *
     * @return array
     */
    private function updateItem($item, $data)
    {
        foreach ($data as $key => $value) {
            if (isset($item->$key)) {
                $item->$key = $value;
            }
        }
        $item->weight = Product::findOrFail($item->product_id)->getWeight($item->material_id) * $item->quantity;

        return $item;
    }

    /**
     * Build's a basket item.
     *
     * @param array $item
     *
     * @return array
     */
    private static function buildItem($item)
    {
        $item->design = null;
        $item->designType = DesignType::findOrFail($item->design_type_id);
        $item->design = static::isSavedDesign($item) ? Design::findOrFail($item->design_id) : null;
        $item->category = Category::findOrFail($item->category_id);
        $item->product = Product::findOrFail($item->product_id);
        $item->material = static::isSampleBook($item) ? null : Material::findOrFail($item->material_id);
        $item->actual_gross_price = static::getBasketItemUnitPrice($item);
        $item->actual_vat = calculateVAT($item->actual_gross_price);
        $item->actual_net_price = $item->actual_gross_price - $item->actual_vat;
        $item->actual_gross_total = $item->quantity * $item->actual_gross_price;
        $item->actual_net_total = $item->quantity * $item->actual_net_price;
        $item->gross_price = convertPriceToCurrentCurrency($item->actual_gross_price);
        $item->vat = calculateVAT($item->gross_price);
        $item->net_price = $item->gross_price - $item->vat;
        $item->gross_total = $item->quantity * $item->gross_price;
        $item->net_total = $item->quantity * $item->net_price;
        $item->formatted_gross_total = getCurrentCurrencySymbol() . formatPrice($item->gross_total);

        return $item;
    }

    /**
     * Returns basket item unit price.
     *
     * @param array $item
     *
     * @return float
     */
    public static function getBasketItemUnitPrice($item)
    {
        $apply = false;
        $productMaterial = ProductMaterial::where('product_id', $item->product_id)
            ->where('material_id', $item->material_id)
            ->firstOrFail();

        if (static::isDesign($item) && static::isSavedDesign($item)) {
            $apply = (isCustomerUser() && getDesign($item->design_id)->isOwner(getAuthenticatedUser()->id)) ? false : true;
        }

        return $productMaterial->getPriceWithQuantityRules($apply, null, false);
    }

    public function getDeliveryOptions()
    {
        $basket = $this->getBasketItems();
        $deliveryOptions = [];

        foreach ($basket as $item) {
            $productPackageType = ProductPackageType::whereProductId($item->product_id)->first();
            $shippingPackageType = ShippingPackageType::whereId($productPackageType->package_type_id)->first();
            $weightBrandings = ShippingPackageBranding::wherePackageTypeId($productPackageType->package_type_id)->get();

            foreach ($weightBrandings as $weightBranding) {
                $shippingWeightBrandings = ShippingWeightBranding::whereId($weightBranding->weight_branding_id)->get();
                $shippingZoneBranding = ShippingZoneBranding::whereWeightBrandingId($weightBranding->weight_branding_id)->first();
                $county = Country::whereId($shippingZoneBranding->zone_id)->first();

                foreach ($shippingWeightBrandings as $shippingWeightBranding) {

                    if ((self::getBasketWeight() <= $shippingWeightBranding->max_weight) && (!array_key_exists($shippingWeightBranding->id, $deliveryOptions))) {
                        $deliveryOptions[$shippingWeightBranding->id] = [
                            'item_title' => Product::whereId($item->product_id)->first()->title,
                            'shipping_package_type_title' => $shippingPackageType->title,
                            'shipping_weight_branding_title' => $shippingWeightBranding->title,
                            'shipping_weight_branding_id' => $shippingWeightBranding->id,
                            'price' => $shippingZoneBranding->getShippingPrice($county->code, true),
                        ];
                    }
                }
            }
        }

        return $deliveryOptions;
    }

}
