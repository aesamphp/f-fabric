<?php

/**
 * Detect Active Route.
 *
 * @param string $route
 * @param string $output
 *
 * @return string
 */
function isActiveRoute($route, $output = "active") {
    if (Route::currentRouteName() === $route) {
        return $output;
    }
}

/**
 * Detect Active Routes.
 *
 * @param array $routes
 * @param string $output
 *
 * @return string
 */
function areActiveRoutes(Array $routes, $output = "active") {
    foreach ($routes as $route) {
        if (Route::currentRouteName() === $route) {
            return $output;
        }
    }
}

/**
 * Detect Active Paths.
 *
 * @param array $paths
 * @param string $output
 *
 * @return string
 */
function areActivePaths(Array $paths, $output = "active") {
    foreach ($paths as $path) {
        if (Request::is($path)) {
            return $output;
        }
    }
}

/**
 * Returns formatted date.
 *
 * @param string $date
 * @param string $format
 *
 * @return string
 */
function formatDate($date, $format = "d-m-Y") {
    return date($format, strtotime($date));
}

/**
 * Detects user role.
 *
 * @param int $role
 *
 * @return boolean
 */
function isAllowed($role) {
    return (getAuthenticatedUser()->hasRole($role)) ? true : false;
}

/**
 * Detects user roles.
 *
 * @param array $roles
 *
 * @return boolean
 */
function areAllowed(Array $roles) {
    $user = getAuthenticatedUser();
    foreach ($roles as $role) {
        if ($user->hasRole($role)) {
            return true;
        }
    }
    return false;
}

/**
 * Returns the user role type value.
 *
 * @param string $type
 *
 * @return int
 */
function getUserRoleType($type) {
    return getClassConstantValue('App\Models\UserRole::' . $type);
}

/**
 * Returns setting field type value.
 *
 * @param string $type
 *
 * @return int
 */
function getSettingFieldType($type) {
    return getClassConstantValue('App\Models\SettingField::' . $type);
}

/**
 * Returns the class constant value.
 *
 * @param Class::Constant $constant
 *
 * @return int/string
 */
function getClassConstantValue($constant) {
    return constant($constant);
}

/**
 * Generates the dropdown options.
 *
 * @param array $options
 * @param string $value
 * @param string $title
 *
 * @return string
 */
function generateDropdownOptions(Array $options, $value, $title) {
    $dropdownOptions = "";
    foreach ($options as $option) {
        $dropdownOptions .= '<option value="' . $option[$value] . '">' . $option[$title] . '</option>';
    }
    return $dropdownOptions;
}

/**
 * Generates the dropdown options.
 *
 * @param array $options
 *
 * @return string
 */
function generateDropdownFromArray(Array $options) {
    $dropdownOptions = "";
    foreach ($options as $key => $value) {
        $dropdownOptions .= '<option value="' . $key . '">' . $value . '</option>';
    }
    return $dropdownOptions;
}

/**
 * Generates link html.
 *
 * @param string $link
 * @param string $title
 * @param boolean $internal
 * @param array $options
 *
 * @return string
 */
function generateCTALinkHtml($link, $title, $internal = true, Array $options = []) {
    if ($internal == 0 || $internal == false) {
        $options['target'] = '_blank';
    } else {
        $link = is_null($link) ? $link : url($link);
    }
    $attributes = [];
    foreach ($options as $key => $value) {
        $attributes[] = $key . '="' . $value . '"';
    }
    return '<a href="' . $link . '" ' . arrayToString($attributes, " ") . '><span>' . $title . '</span></a>';
}

/**
 * Generates link.
 *
 * @param string $link
 * @param string $title
 * @param boolean $internal
 * @param array $options
 *
 * @return string
 */
function generateCTALink($link, $title, $internal = true, Array $options = [])
{
    if ($internal == 0 || $internal == false) {
        $options['target'] = '_blank';
    } else {
        $link = is_null($link) ? $link : url($link);
    }
    return $link;
}

/**
 * Returns formatted name.
 *
 * @param array $fields
 *
 * @return string
 */
function formatName(Array $fields) {
    foreach ($fields as $key => $value) {
        $fields[$key] = ucfirst($value);
    }
    return arrayToString($fields, ' ');
}

/**
 * Returns the authenticated user.
 *
 * @return array
 */
function getAuthenticatedUser() {
        return Auth::user();
}

/**
 * Returns true or false if user is authenticated or not.
 *
 * @return boolean
 */
function isAuthenticUser() {
    return Auth::check();
}

/**
 * Checks if authenticated user is an admin user.
 *
 * @return boolean
 */
function isAdminUser() {
    if (isAuthenticUser()) {
        if (getAuthenticatedUser()->hasGroup(App\Models\UserGroup::GROUP_ADMIN)) {
            return true;
        }
    }
    return false;
}

/**
 * Checks if authenticated user is a customer user.
 *
 * @return boolean
 */
function isCustomerUser() {
    if (isAuthenticUser()) {
        if (getAuthenticatedUser()->hasGroup(App\Models\UserGroup::GROUP_CUSTOMER)) {
            return true;
        }
    }
    return false;
}

/**
 * Returns image width.
 *
 * @param string $imagePath
 *
 * @return int
 */
function getImageWidth($imagePath) {
    $imageService = new App\Services\ImageService($imagePath);
    return $imageService->getImageWidth();
}

/**
 * Returns image height.
 *
 * @param string $imagePath
 *
 * @return int
 */
function getImageHeight($imagePath) {
    $imageService = new App\Services\ImageService($imagePath);
    return $imageService->getImageHeight();
}

/**
 * Returns the category.
 *
 * @param int $id
 *
 * @return array
 */
function getCategory($id) {
    return App\Models\Category::findOrFail($id);
}

/**
 * Returns the design type.
 *
 * @param int $id
 *
 * @return array
 */
function getDesignType($id) {
    return App\Models\DesignType::findOrFail($id);
}

/**
 * Returns the material.
 *
 * @param int $id
 *
 * @return array
 */
function getMaterial($id) {
    return App\Models\Material::findOrFail($id);
}

/**
 * Returns the product.
 *
 * @param int $id
 *
 * @return array
 */
function getProduct($id) {
    return App\Models\Product::findOrFail($id);
}

/**
 * Returns the design.
 *
 * @param int $id
 *
 * @return array
 */
function getDesign($id) {
    return App\Models\Design::findOrFail($id);
}

/**
 * Returns the shipping weight brand.
 *
 * @param int $id
 *
 * @return array
 */
function getShippingWeightBranding($id) {
    return App\Models\ShippingWeightBranding::findOrFail($id);
}

/**
 * Returns the basket items count.
 *
 * @return int
 */
function getBasketItemsCount() {
    return App\Models\Basket::getBasketItemsCount();
}

/**
 * Returns the basket items.
 *
 * @return array
 */
function getBasketItems() {
    return App\Models\Basket::getBasketItems();
}

/**
 * Returns the basket item unit price.
 *
 * @param int $id
 * @param boolean $formatPrice
 *
 * @return float
 */
function getBasketItemUnitPrice($id, $formatPrice = false) {
    $price = App\Models\Basket::getBasketItemUnitPrice($id);
    return ($formatPrice === true) ? formatPrice($price) : $price;
}

/**
 * Returns the basket item price.
 *
 * @param int $id
 * @param boolean $formatPrice
 *
 * @return float
 */
function getBasketItemPrice($id, $formatPrice = false) {
    $price = App\Models\Basket::getBasketItemPrice($id);
    return ($formatPrice === true) ? formatPrice($price) : $price;
}

/**
 * Returns the basket sub total.
 *
 * @param boolean $formatPrice
 *
 * @return float
 */
function getBasketSubtotal($formatPrice = false) {
    $price = App\Models\Basket::getBasketSubtotal();
    return ($formatPrice === true) ? formatPrice($price) : $price;
}

/**
 * Returns the basket vat.
 *
 * @param boolean $formatPrice
 *
 * @return float
 */
function getBasketVat($formatPrice = false) {
    $price = App\Models\Basket::getBasketVat();
    return ($formatPrice === true) ? formatPrice($price) : $price;
}

/**
 * Returns the basket weight.
 *
 * @return int
 */
function getBasketWeight() {
    return App\Models\Basket::getBasketWeight();
}

/**
 * Returns the basket items quantity.
 *
 * @return int
 */
function getBasketItemsQuantity() {
    return App\Models\Basket::getBasketItemsQuantity();
}

/**
 * Returns if shipping price is applied to basket or not.
 *
 * @return boolean
 */
function hasShippingPrice() {
    return (session()->get('checkoutDeliveryAddress') === null) ? false : true;
}

/**
 * Returns the actual shipping price.
 *
 * @param boolean $netPrice
 * @param boolean $formatPrice
 *
 * @return float
 */
function getShippingActualPrice($netPrice = false, $formatPrice = false) {
    $amount = 0;
    if (hasShippingPrice()) {
        $deliveryAddress = session()->get('checkoutDeliveryAddress');
        $country = App\Models\Country::where('code', $deliveryAddress->country)->firstOrFail();
        $zoneBranding = App\Models\ShippingZoneBranding::where('zone_id', $country->zone_id)
                    ->where('weight_branding_id', $deliveryAddress->weight_branding_id)
                    ->firstOrFail();
        $amount = $zoneBranding->getShippingPrice($deliveryAddress->country, $netPrice, true);
    }
    return ($formatPrice === true) ? formatPrice($amount) : $amount;
}
/**
 * Returns the actual shipping vat.
 *
 * @param boolean $formatPrice
 *
 * @return float
 */
function getShippingActualVAT($formatPrice = false) {
    $amount = getShippingActualPrice() - getShippingActualPrice(true);
    return $formatPrice === true ? formatPrice($amount) : $amount;
}

/**
 * Returns the shipping gross price.
 *
 * @param boolean $formatPrice
 *
 * @return float
 */
function getShippingGrossPrice($formatPrice = false) {
    $amount = convertPriceToCurrentCurrency(getShippingActualPrice());
    return ($formatPrice === true) ? formatPrice($amount) : $amount;
}

/**
 * Returns the shipping net price.
 *
 * @param boolean $formatPrice
 *
 * @return float
 */
function getShippingNetPrice($formatPrice = false) {
    $amount = getShippingGrossPrice() - getShippingVAT();
    return ($formatPrice === true) ? formatPrice($amount) : $amount;
}

/**
 * Returns the shipping vat.
 *
 * @param boolean $formatPrice
 *
 * @return float
 */
function getShippingVAT($formatPrice = false) {
    $amount = (hasShippingPrice()) ? calculateVAT(getShippingGrossPrice()) : 0;
    return $formatPrice === true ? formatPrice($amount) : $amount;
}

/**
 * Returns if discount is applied to basket or not.
 *
 * @return boolean
 */
function isDiscountApplied() {
    return (session()->get('discountCodeId')) ? true : false;
}

/**
 * Returns the applied discount code.
 *
 * @return array
 */
function getAppliedDiscountCode() {
    return App\Models\DiscountCode::findOrFail(session()->get('discountCodeId'));
}

/**
 * Returns the discount amount applied to basket.
 *
 * @param boolean $actual
 * @param boolean $formatPrice
 *
 * @return float
 */
function getDiscountAmount($actual = false, $formatPrice = false) {
    $amount = isDiscountApplied() ? getAppliedDiscountCode()->getAmount($actual) : 0;
    return ($formatPrice === true) ? formatPrice($amount) : $amount;
}

/**
 * Returns the basket grand total.
 *
 * @param boolean $formatPrice
 *
 * @return float
 */
function getBasketGrandTotal($formatPrice = false) {
    $price = App\Models\Basket::getBasketGrandTotal();
    return ($formatPrice === true) ? formatPrice($price) : $price;
}

/**
 * Returns the basket grand total.
 *
 * @param boolean $formatPrice
 *
 * @return float
 */
function getBasketGrandTotalForDeliveryOptions($formatPrice = false) {
    $price = App\Models\Basket::getBasketGrandTotalForDeliveryOptions();
    return ($formatPrice === true) ? formatPrice($price) : $price;
}

/**
 * Returns formatted price.
 *
 * @param float $price
 * @param int $decimals
 *
 * @return string
 */
function formatPrice($price, $decimals = 2) {
    return number_format((float)$price, $decimals);
}

/**
 * Returns number with decimal places.
 *
 * @param float $number
 * @param int $decimals
 *
 * @return float
 */
function setNumberDecimals($number, $decimals = 2) {
    return (float)number_format($number, $decimals, ".", "");
}

/**
 * Returns the encrypted card number.
 *
 * @param string $cardNumber
 *
 * @return string
 */
function encryptCardNumber($cardNumber) {
    return 'xxxx-xxxx-xxxx-' . substr($cardNumber, 12);
}

/**
 * Returns the formatted card expiry date.
 *
 * @param string $date
 *
 * @return string
 */
function formatCardExpiryDate($date) {
    return substr($date, 0, 2) . '/' . substr($date, 2);
}

/**
 * Returns card type title.
 *
 * @param string $id
 *
 * @return string
 */
function getCardType($id) {
    return App\Services\SagepayService::getCardType($id);
}

/**
 * Returns the form field value.
 *
 * @param object $object
 * @param string $key
 *
 * @return string
 */
function getFormFieldValue($object, $key) {
    $value = null;
    if (old($key)) {
        $value = old($key);
    } elseif (is_object($object) && isset($object->$key)) {
        $value = $object->$key;
    }
    return $value;
}

/**
 * Returns the setting value.
 *
 * @param string $path
 *
 * @return string
 */
function getSettingValue($path) {
    return App\Models\Setting::getSettingValue($path);
}

/**
 * Returns the share URL.
 *
 * @param string $url
 * @param string $type
 *
 * @return string
 */
function getShareURL($url = null, $type = null) {
    $shareURL = null;
    $facebookShareURL = "https://www.facebook.com/sharer/sharer.php?u=";
    $twitterShareURL = "https://twitter.com/home?status=";
    $pinterestShareURL = "https://pinterest.com/pin/create/button/?url=";
    $googlePlusShareURL = "https://plus.google.com/share?url=";
    if ($type === "facebook") {
        $shareURL = $facebookShareURL;
    } elseif ($type === "twitter") {
        $shareURL = $twitterShareURL;
    } elseif ($type === "pinterest") {
        $shareURL = $pinterestShareURL;
    } elseif ($type === "googlePlus") {
        $shareURL = $googlePlusShareURL;
    }
    return $shareURL . $url;
}

/**
 * Return blog articles.
 *
 * @param int $limit
 *
 * @return array
 */
function getBlogArticles($limit = 1) {
    return App\Models\BlogArticle::where('active', 1)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->skip(0)
            ->get();
}

/**
 * Return design tip categories.
 *
 * @param int $limit
 *
 * @return array
 */
function getDesignTipCategories($limit = 6) {
    return App\Models\DesignTipCategory::orderBy('created_at', 'desc')
            ->take($limit)
            ->skip(0)
            ->get();
}

/**
 * Returns the design image type value.
 *
 * @param string $type
 *
 * @return int
 */
function getDesignImageType($type) {
    return getClassConstantValue('App\Models\DesignImage::' . $type);
}

/**
 * Checks the application environment.
 *
 * @param string $environment
 *
 * @return boolean
 */
function isEnvironment($environment) {
    return app()->environment($environment);
}

/**
 * Returns the state details.
 *
 * @param string $code
 *
 * @return array
 */
function getState($code) {
    return App\Models\USState::where('code', $code)
            ->first();
}

/**
 * Returns the country details.
 *
 * @param string $code
 *
 * @return array
 */
function getCountry($code) {
    return App\Models\Country::where('code', $code)
            ->first();
}

/**
 * Returns if the country is in EU or not.
 *
 * @param string $code
 *
 * @return boolean
 */
function isEUCountry($code) {
    return App\Models\Country::isEUCountry($code);
}

/**
 * Returns the currency details.
 *
 * @param string $code
 *
 * @return array
 */
function getCurrency($code) {
    return App\Models\Currency::where('code', $code)
            ->first();
}

/**
 * Generates the currency dropdown options.
 *
 * @return string
 */
function generateCurrencyDropdownOptions() {
    return generateDropdownOptions(App\Models\Currency::all()->toArray(), 'id', 'code');
}

/**
 * Returns the current currency.
 *
 * @return array
 */
function getCurrentCurrency() {
    $currentCurrencyId = session()->get('currencyID');
    $currency = App\Models\Currency::getDefaultCurrency();
    if ($currentCurrencyId) {
        $currency = App\Models\Currency::findOrFail($currentCurrencyId);
    }
    return $currency;
}

/**
 * Returns the current currency symbol.
 *
 * @return string
 */
function getCurrentCurrencySymbol() {
    return getCurrentCurrency()->symbol;
}

/**
 * Converts the price to current currency exchange rate.
 *
 * @param float $price
 * @param boolean $formatPrice
 *
 * @return float
 */
function convertPriceToCurrentCurrency($price, $formatPrice = false) {
    $currency = getCurrentCurrency();
    $nearestRoundUpDecimal = 0.25;
    $exchangeRate = ($currency->exchange_rate > 0) ? $currency->exchange_rate : 0;
    if ($exchangeRate > 0) {
        $price = ceil(($price * $exchangeRate) / $nearestRoundUpDecimal) * $nearestRoundUpDecimal;
    }
    return ($formatPrice === true) ? formatPrice($price) : $price;
}

/**
 * Converts an array to string.
 *
 * @param array $array
 * @param string $glue
 *
 * @return string
 */
function arrayToString(Array $array = [], $glue = ", ") {
    return collect($array)->implode($glue);
}

/**
 * Returns if the basket item is a saved design or not.
 *
 * @param array $item
 *
 * @return boolean
 */
function isBasketItemASavedDesign($item) {
    return App\Models\Basket::isSavedDesign($item);
}

/**
 * Returns if the basket item is a colour atlas or not.
 *
 * @param array $item
 *
 * @return boolean
 */
function isBasketItemAColourAtlas($item) {
    return App\Models\Basket::isColourAtlas($item);
}

/**
 * Returns if the basket item is a sample book or not.
 *
 * @param array $item
 *
 * @return boolean
 */
function isBasketItemASampleBook($item) {
    return App\Models\Basket::isSampleBook($item);
}

/**
 * Returns if the basket item is a plain fabric or not.
 *
 * @param array $item
 *
 * @return boolean
 */
function isBasketItemAPlainFabric($item) {
    return App\Models\Basket::isPlainFabric($item);
}

/**
 * Extracts and returns the domain name from URL.
 *
 * @param string $url
 *
 * @return string
 */
function extractDomainFromURL($url) {
    return implode('/', array_slice(explode('/', preg_replace('/https?:\/\/|/', '', $url)), 0, 1));
}

/**
 * Returns formatted address.
 *
 * @param array $address
 * @param array $attributes
 * @param boolean $html
 * @param string $glue
 *
 * @return string
 */
function formatAddress($address, Array $attributes = [], $html = true, $glue = ", ") {
    $array = [];
    $formattedAddress = "";
    foreach ($attributes as $attribute) {
        if (method_exists($address, $attribute)) {
            $array[] = $address->$attribute();
        } elseif (isset($address->$attribute) && !empty($address->$attribute)) {
            $array[] = $address->$attribute;
        }
    }
    if (!empty($array)) {
        if ($html === true) {
            $formattedAddress .= '<ul class="list address">';
            $formattedAddress .= '<li class="item">' . arrayToString($array, '</li><li class="item">') . '</li>';
            $formattedAddress .= '</ul>';
        } else {
            $formattedAddress = arrayToString($array, $glue);
        }
    }
    return $formattedAddress;
}

/**
 * Returns the colour atlas image.
 *
 * @return string
 */
function getColourAtlasImagePath() {
    return 'images/colour-chart.png';
}

/**
 * Returns the sample book image.
 *
 * @return string
 */
function getSampleBookImagePath() {
    return 'images/sample-book.jpg';
}

/**
 * Returns the plain fabric image.
 *
 * @return string
 */
function getPlainFabricImagePath() {
    return 'images/plain-fabric.jpg';
}

/**
 * Generates the limit dropdown.
 *
 * @return string
 */
function generateLimitDropdown($count = 100, $limit = 20) {
    $options = [];
    for ($i = $limit; $i <= $count; $i = $i + $limit) {
        $options[$i] = $i;
    }
    return generateDropdownFromArray($options);
}

/**
 * Generate the filter dropdown.
 *
 * @return string
 */
function generateFilterDropdown() {
    $options = [
        '' => 'Select Option',
        'new' => 'New',
        'most-popular' => 'Most Popular',
        'best-seller' => 'Best Seller'
    ];
    return generateDropdownFromArray($options);
}

/**
 * Shows the executed sql queries.
 */
function debugSQL() {
    Event::listen('illuminate.query', function($query) {
        var_dump($query);
    });
}

/**
 * Returns the calculated vat.
 *
 * @param float $amount
 * @param boolean $formatPrice
 *
 * @return float
 */
function calculateVAT($amount, $formatPrice = false) {
    $price = ($amount / 120) * env('APP_VAT_PERCENTAGE', 20);
    return ($formatPrice === true) ? formatPrice($price) : setNumberDecimals($price);
}

/**
 * Returns the price text.
 *
 * @param float $price
 * @param string $symbol
 *
 * @return string
 */
function getPriceText($price, $symbol) {
    return ($price > 0) ? $symbol . formatPrice($price) : 'Free';
}

/**
 * Applies shipping discount.
 *
 * @param int $amount
 * @param int $brandingType
 * @param string $country
 *
 * @return int
 */
function applyShippingDiscount($amount, $country) {
    $status = env('APP_FREE_SHIPPING', false);
    return ($status === true && $country === "GB" && getBasketGrandTotalForDeliveryOptions() > 60) ? 0 : $amount;
}
/**
 * Returns the email template.
 *
 * @param int $action_id
 *
 * @return array
 */
function getEmailTemplate($action_id) {
    return App\Models\EmailTemplate::where('action_id', $action_id)
            ->first();
}

/**
 * Returns the readable text time.
 *
 * @param string $time
 *
 * @return string
 */
function timeToAgo($time) {
    return \Carbon\Carbon::createFromTimeStamp(strtotime($time))->diffForHumans();
}

/**
 * Returns the calulated sale commission amount.
 *
 * @param float $amount
 * @param boolean $formatPrice
 *
 * @return float
 */
function calculateSaleCommission($amount, $formatPrice = false) {
    $percentage = getSettingValue('general/sales_commission');
    if ($percentage === null || !is_numeric($percentage)) {
        $percentage = 0;
    }
    $price = ($amount / 100) * $percentage;
    return ($formatPrice === true) ? formatPrice($price) : $price;
}

/**
 * Returns the blacklist of terms.
 *
 * @return array
 */
function termsToBlock() {
    $array = [];
    $file = fopen(public_path('terms-to-block.csv'), 'r');
    while (($data = fgetcsv($file)) !== false) {
        $array[] = $data[0];
    }
    return $array;
}

/**
 * Returns the price with shop price rules.
 *
 * @param float $price
 * @param boolean $apply
 * @param boolean $formatPrice
 *
 * @return float
 */
function applyShopPrice($price, $apply, $formatPrice = false) {
    if ($apply === true) {
        $price = $price * env('APP_SHOP_PERCENTAGE', 1.1111);
    }
    return ($formatPrice === true) ? formatPrice($price) : $price;
}

/**
 * Returns the tweets.
 *
 * @param int $limit
 *
 * @return array
 */
function getTweets($limit = 4) {
    $tweets = [];
    $rawTweets = Twitter::getUserTimeline(['screen_name' => config('ttwitter.SCREEN_NAME'), 'count' => $limit]);
    foreach ($rawTweets as $tweet) {
        $tweet->text = Twitter::linkify($tweet);
        $tweets[] = $tweet;
    }
    return $tweets;
}

/**
 * Checks if there is a live contest or not.
 *
 * @return boolean
 */
function isLiveContest() {
    return (getLiveContest()) ? true : false;
}

/**
 * Returns the live contest.
 *
 * @return array
 */
function getLiveContest() {
    $today = date('Y-m-d');
    return App\Models\WeeklyContest::where('from_date', '<=', $today)
            ->where('to_date', '>=', $today)
            ->where('disabled', 0)
            ->first();
}

/**
 * Returns the upcoming contests.
 *
 * @param int $limit
 *
 * @return array
 */
function getUpcomingContests($limit = 5) {
    $today = date('Y-m-d');
    return App\Models\WeeklyContest::where('from_date', '>', $today)
            ->where('disabled', 0)
            ->orderBy('from_date', 'ASC')
            ->take($limit)
            ->skip(0)
            ->get();
}

/**
 * Returns live and upcoming contests.
 *
 * @return array
 */
function getLiveAndUpcomingContests() {
    $today = date('Y-m-d');
    return App\Models\WeeklyContest::where(function ($query) use ($today) {
                $query->where('from_date', '<=', $today)
                        ->where('to_date', '>=', $today)
                        ->orWhere(function ($query) use ($today) {
                            $query->where('from_date', '>', $today);
                        });
            })
            ->where('disabled', 0)
            ->orderBy('from_date', 'ASC')
            ->get();
}

/**
 * Check's if user has to pay VAT or not.
 *
 * @return boolean
 */
function shouldPayVAT() {
    $status = false;
    $billingAddress = session()->get('checkoutBillingAddress');
    $deliveryAddress = session()->get('checkoutDeliveryAddress');
    if (is_null($billingAddress) || isEUCountry($billingAddress->country) || is_null($deliveryAddress) || isEUCountry($deliveryAddress->country)) {
        $status = true;
        if (isCustomerUser() && getAuthenticatedUser()->isVATRegistered() && $deliveryAddress && $deliveryAddress->country !== "GB") {
            $status = false;
        }
    }
    return $status;
}
