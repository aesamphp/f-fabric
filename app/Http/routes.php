<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

use App\Models\UserRole;

// Home route...
Route::get('/', 'DefaultController@index')->name('home');

// How it works route...
Route::get('how-it-works', 'DefaultController@showHowItWorks')->name('view.how.it.works');

// Contribute route...
Route::get('sell', 'DefaultController@showContribute')->name('view.contribute');

// Community routes...
Route::get('community', 'DefaultController@showCommunity')->name('view.community');
Route::post('community/join', 'DefaultController@joinCommunity')->name('join.community');
Route::get('weekly-contest', 'DefaultController@showWeeklyContest')->name('view.weekly.contest');

// Contact routes...
Route::get('contact', 'DefaultController@showContact')->name('view.contact');
Route::post('contact', 'DefaultController@submitContact')->name('submit.contact');

// About route...
Route::get('about', 'DefaultController@showAbout')->name('view.about');

// Refer route...
Route::get('refer', 'DefaultController@showRefer')->name('view.refer');

// Blog routes...
Route::get('blog', 'BlogController@index')->name('view.blog');
Route::get('blog/pagination', 'BlogController@blogPagination')->name('view.blog.pagination');
Route::get('blog/{identifier}', 'BlogController@showBlogArticle')->name('view.blog.article');

// FAQ route...
Route::get('faqs', 'DefaultController@showFaqs')->name('view.faqs');
Route::post('faqs', 'DefaultController@searchFaqs')->name('search.faqs');
Route::get('faqs/{identifier}', 'DefaultController@showFaqs')->name('view.faqs.category');

// Delivery and Returns route...
Route::get('delivery-and-returns', 'DefaultController@showDeliveryReturns')->name('view.delivery.and.returns');

// Terms and Conditions route...
Route::get('terms-and-conditions', 'DefaultController@showTermsConditions')->name('view.terms.and.conditions');

// Privacy route...
Route::get('privacy', 'DefaultController@showPrivacy')->name('view.privacy');

// Design tips route...
Route::get('design-tips', 'DesignTipController@index')->name('view.design.tips');
Route::get('design-tips/search', 'DesignTipController@search')->name('search.design.tips');
Route::get('design-tips/{category}', 'DesignTipController@index')->name('view.design.tips.category');
Route::get('design-tips/{category}/{identifier}', 'DesignTipController@showDesignTip')->name('view.design.tip');

// Custom Printing route...
Route::get('custom-printing', 'DefaultController@showCustomPrinting')->name('view.custom.printing');

// Products route...
Route::get('products', 'DefaultController@showProducts')->name('view.products');

// Design routes...
Route::get('design/create', 'DesignController@showCreateDesign')->name('view.design.create');
Route::get('design/upload', 'DesignController@showUploadDesign')->name('view.design.upload');
Route::post('design/upload', 'DesignController@uploadDesign')->name('view.upload.design');
Route::get('category/{id}/tab-content', 'DesignController@showCategoryTabContent')->name('view.category.tab.content');
Route::get('product/{id}/material/dropdown', 'DesignController@showProductMaterialDropdown')->name('view.product.material.dropdown');
Route::get('product-material/price', 'DesignController@showProductMaterialPrice')->name('view.product.material.price');
Route::get('product-material/quantity-discounts', 'DesignController@showProductMaterialQuantityDiscounts')->name('view.product.material.quantity.discounts');

// Design manipulate routes...
Route::get('design/manipulate', 'DesignManipulateController@create')->name('view.design.manipulate');
Route::get('design/manipulate/{id}', 'DesignManipulateController@edit')->name('view.basket.manipulate');

//Design review routes...
Route::get('design/preview/create', 'DesignPreviewController@show')->name('create.design.preview');
Route::get('design/preview/edit/{basketId}', 'DesignPreviewController@edit')->name('edit.design.preview');

// Basket routes...
Route::post('basket/apply-discount', 'BasketController@applyBasketDiscount')->name('apply.basket.discount');
Route::delete('basket/remove-discount', 'BasketController@deleteBasketDiscount')->name('delete.basket.discount');
Route::get('basket', 'BasketController@index')->name('view.basket');
Route::post('basket', 'BasketController@storeBasketItem')->name('store.basket.item');
Route::patch('basket/{id}', 'BasketController@updateBasketItem')->name('update.basket.item');
Route::delete('basket/{id}', 'BasketController@deleteBasketItem')->name('delete.basket.item');

// Shop routes...
Route::get('shop', 'ShopController@index')->name('view.shop');
Route::get('shop/colour-atlas', 'ShopController@showColourAtlas')->name('view.shop.colour.atlas');
Route::get('shop/sample-books', 'ShopController@showSampleBooks')->name('view.shop.sample.books');
Route::get('shop/plain-fabrics', 'ShopController@showPlainFabrics')->name('view.shop.plain.fabrics');
Route::get('shop/all', 'ShopController@showAll')->name('view.shop.all');
Route::get('shop/all/pagination', 'ShopController@shopPagination')->name('view.shop.pagination');
Route::get('shop/{designIdentifier}', 'ShopController@showDesign')->name('view.shop.design');

// Designer Store route...
Route::get('store/{username}', 'StoreController@showDesignerStore')->name('view.designer.store');
Route::get('store/{username}/pagination', 'StoreController@studioPagination')->name('view.designer.pagination');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin')->name('view.login');
Route::post('auth/login', 'Auth\AuthController@postLogin')->name('post.login');
Route::post('auth/facebook', 'Auth\AuthController@postFacebookLogin')->name('post.facebook.login');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister')->name('view.register');
Route::post('auth/register', 'Auth\AuthController@postRegister')->name('post.register');

// Password reset link routes...
Route::get('password/email', 'Auth\PasswordController@getEmail')->name('view.forgot.password');
Route::post('password/email', 'Auth\PasswordController@postEmail')->name('post.forgot.password');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset')->name('view.reset.password');
Route::post('password/reset', 'Auth\PasswordController@postReset')->name('post.reset.password');

// Change currency route...
Route::post('currency', 'DefaultController@changeCurrency')->name('change.currency');

// Search routes...
Route::get('search', 'DefaultController@search')->name('search');
Route::post('search/tags', 'DefaultController@searchTags')->name('search.tags');
Route::get('search/tag/{tag}/designs', 'DefaultController@searchDesignsByTag')->name('search.tag.designs');
Route::post('search/address', 'DefaultController@searchAddress')->name('search.address');

// Download file route...
Route::get('download/file', 'DefaultController@downloadFile')->name('download.file');

// Sitemap route...
Route::get('sitemap', 'DefaultController@showSitemap')->name('view.sitemap');

// Authenticated routes...
Route::group(['middleware' => ['auth', 'role:' . UserRole::TYPE_CONTRIBUTOR]], function() {
    
    // Logout route...
    Route::match(['get', 'post'], 'auth/logout', 'Auth\AuthController@getLogout')->name('logout');
    
    // Register confirmation route...
    Route::get('confirmation', 'DefaultController@showConfirmation')->name('view.confirm.register');
    
    // Home alias route...
    Route::get('home', 'DefaultController@home');
    
    // Blog routes...
    Route::post('blog/{id}/comment', 'BlogController@storeBlogArticleComment')->name('store.blog.article.comment');
    
    // Report comment route...
    Route::post('comment/{id}/report', 'DefaultController@reportComment')->name('report.comment');
    
    // Design routes...
    Route::get('design/{id}/edit', 'DesignController@showEditDesign')->name('view.edit.design');
    Route::patch('design/{id}/edit', 'DesignController@updateEditDesign')->name('update.edit.design');
    Route::delete('design/{id}/delete', 'DesignController@showDeleteDesign')->name('view.delete.design');
    Route::get('design/{id}/edit/{basketId}', 'DesignController@showEditDesign')->name('view.basket.design');
    Route::patch('design/{id}/upload-additional-image', 'DesignController@uploadAdditionalImage')->name('upload.additional.image');
    Route::put('design/{id}/favourite', 'DesignController@favouriteDesign')->name('favourite.design');
    Route::delete('design/{id}/favourite', 'DesignController@unfavouriteDesign')->name('unfavourite.design');
    Route::put('design/{id}/like', 'DesignController@likeDesign')->name('like.design');
    Route::delete('design/{id}/like', 'DesignController@unlikeDesign')->name('unlike.design');
    Route::post('design/{id}/comment', 'DesignController@storeDesignComment')->name('store.design.comment');

    // Order routes...
    Route::get('orders', 'OrdersController@index')->name('view.orders');    
    Route::get('orders/sales', 'OrdersController@showSales')->name('view.orders.sales');
    Route::get('order/{friendlyId}/print', 'OrdersController@printOrder')->name('print.order');
    Route::post('order/{id}/feedback', 'OrdersController@storeOrderFeedback')->name('feedback.order');
    
    // Routes accessible only if basket has items... 
    Route::group(['middleware' => 'basket'], function() {
        // Checkout routes...
        Route::get('checkout/billing-address', 'CheckoutController@showBillingAddress')->name('view.checkout.billing.address');
        Route::post('checkout/billing-address', 'CheckoutController@storeBillingAddress')->name('store.checkout.billing.address');
        Route::get('checkout/delivery-address', 'CheckoutController@showDeliveryAddress')->name('view.checkout.delivery.address');
        Route::post('checkout/delivery-options', 'CheckoutController@showDeliveryOptions')->name('view.checkout.delivery.options');
        Route::post('checkout/delivery-address', 'CheckoutController@storeDeliveryAddress')->name('store.checkout.delivery.address');
        Route::post('checkout/previous-address', 'CheckoutController@showPreviousAddress')->name('view.checkout.previous.address');
        Route::get('checkout/payment', 'CheckoutController@showPayment')->name('view.checkout.payment');
        Route::post('checkout/payment', 'CheckoutController@storePayment')->name('store.checkout.payment');
        Route::get('checkout/order-review', 'CheckoutController@showOrderReview')->name('view.checkout.order.review');
        Route::post('checkout/order-review', 'CheckoutController@processPayment')->name('process.checkout.payment');
        Route::get('checkout/paypal', 'CheckoutController@showPaypal')->name('view.checkout.paypal');
        Route::post('checkout/paypal-result', 'CheckoutController@showPaypalResult')->name('view.checkout.paypal.result');
        Route::get('checkout/secure3d', 'CheckoutController@showSecure3D')->name('view.checkout.secure3d');
        Route::post('checkout/secure3d-result', 'CheckoutController@showSecure3DResult')->name('view.checkout.secure3d.result');
        
    });
    
    // Checkout routes...
    Route::get('checkout/confirmation', 'CheckoutController@showConfirmation')->name('view.checkout.confirmation');

    // User Account Settings routes...
    Route::get('user/account', 'UserController@showAccount')->name('view.user.account');
    Route::patch('user/account', 'UserController@updateAccount')->name('update.user.account');
    Route::delete('user/account', 'UserController@deleteAccount')->name('delete.user.account');
    Route::patch('user/account/password', 'UserController@updatePassword')->name('update.user.password');
    
    // User Address Settings routes...
    Route::get('user/account/address/{id}', 'UserController@getAddress')->name('get.user.address');
    Route::post('user/account/address', 'UserController@storeAddress')->name('store.user.address');
    Route::patch('user/account/address/{id}', 'UserController@updateAddress')->name('update.user.address');
    Route::delete('user/account/address/{id}', 'UserController@deleteAddress')->name('delete.user.address');
    
    // User Payment Settings routes...
    Route::post('user/account/payment', 'UserController@storePayment')->name('store.user.payment');
    Route::patch('user/account/payment', 'UserController@updatePayment')->name('update.user.payment');
    Route::get('user/account/payment/bucksnet', 'UserController@showBucksnetPayment')->name('view.user.bucksnet.payment');
    
    // User Email Settings route...
    Route::patch('user/account/email', 'UserController@updateEmailSettings')->name('update.user.email');
    
    // User Account Tab route...
    Route::get('user/account/{tab}', 'UserController@showAccount')->name('view.user.account.tab');
    
    // User routes...
    Route::get('user/favorites', 'UserController@showFavorites')->name('view.user.favorites');
    Route::delete('user/favorites', 'UserController@deleteFavorites')->name('delete.user.favorites');
    Route::get('user/designs', 'UserController@showDesigns')->name('view.user.designs');
    Route::get('user/designs/{categoryId}', 'UserController@showDesigns')->name('view.user.category.designs');
    Route::get('user/edit-shop', 'UserController@showEditShop')->name('edit.user.shop');
    Route::patch('user/edit-shop', 'UserController@updateShop')->name('update.user.shop');
    Route::get('user/edit-shop/delete-shop-image/{image}', 'UserController@deleteShopImage')->name('edit.user.delete.shop.image');
    Route::get('user/studio', 'UserController@showMyStudio')->name('view.user.studio');
    Route::get('user/studio/promotion', 'UserController@studioPromotion')->name('view.user.promotion');
    Route::get('user/studio/promotion/build-widget', 'UserController@buildWidget')->name('view.user.build.widget');
    Route::post('user/studio/promotion/build-widget-ajax', 'UserController@buildWidgetAjax')->name('user.build.widget.ajax');

    // Home route...
    Route::get('{index}', 'PageController@showPage')->name('index');
});
