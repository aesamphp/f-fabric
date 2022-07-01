<?php

use App\Models\UserRole;

Route::group(['prefix' => 'adm1n', 'as' => 'admin::', 'namespace' => 'Modules\Admin\Http\Controllers'], function () {

    // Authentication routes...
    Route::get('auth/login', 'Auth\AuthController@getLogin')->name('view.login');
    Route::post('auth/login', 'Auth\AuthController@postLogin')->name('post.login');

    Route::get('auth/reset-password', 'Auth\ResetPasswordController@getEmail')->name('auth.reset-password.get-email');
    Route::post('auth/reset-password', 'Auth\ResetPasswordController@postEmail')->name('auth.reset-password.post-email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@index')->name('auth.reset-password.index');
    Route::post('password/reset', 'Auth\ResetPasswordController@store')->name('auth.reset-password.store');

    // Authenticated routes...
    Route::group(['middleware' => 'auth.admin'], function () {

        // Logout route...
        Route::match(['get', 'post'], 'auth/logout', 'Auth\AuthController@getLogout')->name('logout');

        // Only Admin Routes
        Route::group(['middleware' => 'role:' . implode(',', [UserRole::TYPE_ADMIN, UserRole::TYPE_MANAGER])], function () {
            Route::get('/', 'DefaultController@index')->name('dashboard');

            // Category routes...
            Route::get('categories', 'CategoryController@showCategories')->name('view.categories');
            Route::get('category', 'CategoryController@newCategory')->name('new.category');
            Route::post('category', 'CategoryController@storeCategory')->name('store.category');
            Route::get('category/{id}', 'CategoryController@showCategory')->name('view.category');
            Route::patch('category/{id}', 'CategoryController@updateCategory')->name('update.category');
            Route::delete('category/{id}', 'CategoryController@deleteCategory')->name('delete.category');

            // Product routes...
            Route::get('products', 'ProductController@showProducts')->name('view.products');
            Route::get('product', 'ProductController@newProduct')->name('new.product');
            Route::post('product', 'ProductController@storeProduct')->name('store.product');
            Route::get('product/{id}', 'ProductController@showProduct')->name('view.product');
            Route::patch('product/{id}', 'ProductController@updateProduct')->name('update.product');
            Route::delete('product/{id}', 'ProductController@deleteProduct')->name('delete.product');
            Route::get('product/{id}/material', 'ProductController@newProductMaterial')->name('new.product.material');
            Route::post('product/{id}/material', 'ProductController@storeProductMaterial')->name('store.product.material');
            Route::get('product/{id}/material/{materialId}', 'ProductController@showProductMaterial')->name('view.product.material');
            Route::patch('product/{id}/material/{materialId}', 'ProductController@updateProductMaterial')->name('update.product.material');
            Route::delete('product/{id}/material/{materialId}', 'ProductController@deleteProductMaterial')->name('delete.product.material');
            Route::get('product/{id}/package-type', 'ProductController@newProductPackageType')->name('new.product.package.type');
            Route::post('product/{id}/package-type', 'ProductController@storeProductPackageType')->name('store.product.package.type');
            Route::delete('product/{id}/package-type/{packageTypeId}', 'ProductController@deleteProductPackageType')->name('delete.product.package.type');
            Route::get('product/{id}/quantity', 'ProductController@newProductQuantity')->name('new.product.quantity');
            Route::post('product/{id}/quantity', 'ProductController@storeProductQuantity')->name('store.product.quantity');
            Route::get('product/{id}/quantity/{quantityId}', 'ProductController@showProductQuantity')->name('view.product.quantity');
            Route::patch('product/{id}/quantity/{quantityId}', 'ProductController@updateProductQuantity')->name('update.product.quantity');
            Route::delete('product/{id}/quantity/{quantityId}', 'ProductController@deleteProductQuantity')->name('delete.product.quantity');

            // Product material quantity routes...
            Route::get('product-material/{id}/quantity', 'ProductController@newProductMaterialQuantity')->name('new.product.material.quantity');
            Route::post('product-material/{id}/quantity', 'ProductController@storeProductMaterialQuantity')->name('store.product.material.quantity');
            Route::get('product-material/{id}/quantity/{quantityId}', 'ProductController@showProductMaterialQuantity')->name('view.product.material.quantity');
            Route::patch('product-material/{id}/quantity/{quantityId}', 'ProductController@updateProductMaterialQuantity')->name('update.product.material.quantity');
            Route::delete('product-material/{id}/quantity/{quantityId}', 'ProductController@deleteProductMaterialQuantity')->name('delete.product.material.quantity');

            // Order download routes...
            Route::get('order/{id}/download/xml', 'OrderController@downloadOrderXML')->name('download.order.xml');
            Route::get('order/{id}/item/{itemId}/download-file', 'OrderController@downloadDesignFile')->name('download.order.design.file');
            Route::post('orders/download', 'OrderController@downloadOrders')->name('download.orders');

            // Download NewsLetter Subscribers route...
            Route::get('reports/download-newsletter-subscribers', 'DownloadNewsletterSubscribersController@index')->name('download.newsletter.subscribers');

            // Manager routes...
            Route::get('managers', 'ManagerController@showUsers')->name('view.managers');
            Route::get('manager/{id}', 'ManagerController@showUser')->name('view.manager');
            Route::patch('manager/{id}', 'ManagerController@updateUser')->name('update.manager');
            Route::delete('manager/{id}', 'ManagerController@deleteUser')->name('delete.manager');

            // Factory user routes...
            Route::get('factory', 'FactoryController@showUsers')->name('view.factory');
            Route::get('factory/{id}', 'FactoryController@showUser')->name('view.factory.user');

            // Marketing user routes...
            Route::get('marketing', 'MarketingController@showUsers')->name('view.marketing');
            Route::get('marketing/{id}', 'MarketingController@showUser')->name('view.marketing.user');

            // Administrator routes...
            Route::get('administrators', 'AdminController@showUsers')->name('view.admins');
            Route::get('administrator', 'AdminController@newUser')->name('new.admin');
            Route::post('administrator', 'AdminController@storeUser')->name('store.admin');
            Route::get('administrator/{id}', 'AdminController@showUser')->name('view.admin');
            Route::patch('administrator/{id}', 'AdminController@updateUser')->name('update.admin');
            Route::delete('administrator/{id}', 'AdminController@deleteUser')->name('delete.admin');

            // Material routes...
            Route::get('materials', 'MaterialController@showMaterials')->name('view.materials');
            Route::get('material', 'MaterialController@newMaterial')->name('new.material');
            Route::post('material', 'MaterialController@storeMaterial')->name('store.material');
            Route::get('material/{id}', 'MaterialController@showMaterial')->name('view.material');
            Route::patch('material/{id}', 'MaterialController@updateMaterial')->name('update.material');
            Route::delete('material/{id}', 'MaterialController@deleteMaterial')->name('delete.material');

            Route::get('material-categories', 'MaterialCategoryController@show')->name('view.material-categories');
            Route::get('material-category/add', 'MaterialCategoryController@add')->name('add.material-category');
            Route::post('material-category/add', 'MaterialCategoryController@store')->name('add.material-category');
            Route::get('material-category/{id}/edit', 'MaterialCategoryController@edit')->name('edit.material-category');
            Route::patch('material-category/{id}/edit', 'MaterialCategoryController@storeEdit')->name('store.edit.material-category');
            Route::get('material-category/material/{material_id}/remove', 'MaterialCategoryController@removeMaterial')->name('delete.material-category.material');
            Route::get('material-category/{id}/delete', 'MaterialCategoryController@delete')->name('delete.material-category');
            Route::get('material-category/{id}/sort', 'MaterialCategoryController@sort')->name('sort.material-category');

            Route::post('contributors/download', 'ContributorController@downloadUsers')->name('download.contributors');

            // General Settings routes...
            Route::get('settings/general', 'SettingController@showGeneralSettings')->name('view.general.settings');
            Route::patch('settings/general', 'SettingController@updateGeneralSettings')->name('update.general.settings');

            // Contact Settings routes...
            Route::get('settings/contact', 'SettingController@showContactSettings')->name('view.contact.settings');
            Route::patch('settings/contact', 'SettingController@updateContactSettings')->name('update.contact.settings');

            // Notification Banner Settings routes...
            Route::get('settings/notification-banners', 'NotificationBannerController@index')->name('view.notification.banners');
            Route::get('settings/notification-banner', 'NotificationBannerController@create')->name('create.notification.banner');
            Route::post('settings/notification-banner', 'NotificationBannerController@store')->name('store.notification.banner');
            Route::get('settings/notification-banner/{notificationBanner}', 'NotificationBannerController@show')->name('view.notification.banner');
            Route::patch('settings/notification-banner/{notificationBanner}', 'NotificationBannerController@edit')->name('edit.notification.banner');
            Route::delete('settings/notification-banner/{notificationBanner}', 'NotificationBannerController@destroy')->name('destroy.notification.banner');

            // Payment Gateway routes...
            Route::get('settings/payment-gateway', 'SettingController@showPaymentGatewaySettings')->name('view.payment.gateway.settings');
            Route::patch('settings/payment-gateway', 'SettingController@updatePaymentGatewaySettings')->name('update.payment.gateway.settings');

            // Shipping Origin Address routes...
            Route::get('settings/shipping/origin-address', 'SettingController@showShippingOriginAddressSettings')->name('view.shipping.origin.address.settings');
            Route::patch('settings/shipping/origin-address', 'SettingController@updateShippingOriginAddressSettings')->name('update.shipping.origin.address.settings');

            // Shipping Zones routes...
            Route::get('settings/shipping/zones', 'ShippingSettingController@showShippingZones')->name('view.shipping.zones');
            Route::get('settings/shipping/zone', 'ShippingSettingController@newShippingZone')->name('new.shipping.zone');
            Route::post('settings/shipping/zone', 'ShippingSettingController@storeShippingZone')->name('store.shipping.zone');
            Route::get('settings/shipping/zone/{id}', 'ShippingSettingController@showShippingZone')->name('view.shipping.zone');
            Route::patch('settings/shipping/zone/{id}', 'ShippingSettingController@updateShippingZone')->name('update.shipping.zone');
            Route::delete('settings/shipping/zone/{id}', 'ShippingSettingController@deleteShippingZone')->name('delete.shipping.zone');
            Route::get('settings/shipping/zone/{id}/country', 'ShippingSettingController@newShippingZoneCountry')->name('new.shipping.zone.country');
            Route::patch('settings/shipping/zone/{id}/country', 'ShippingSettingController@updateShippingZoneCountry')->name('update.shipping.zone.country');
            Route::delete('settings/shipping/zone/{id}/country/{countryId}', 'ShippingSettingController@deleteShippingZoneCountry')->name('delete.shipping.zone.country');
            Route::get('settings/shipping/zone/{id}/weight-branding', 'ShippingSettingController@newShippingZoneWeightBranding')->name('new.shipping.zone.weight.branding');
            Route::post('settings/shipping/zone/{id}/weight-branding', 'ShippingSettingController@storeShippingZoneWeightBranding')->name('store.shipping.zone.weight.branding');
            Route::get('settings/shipping/zone/{id}/weight-branding/{weightBrandingId}', 'ShippingSettingController@showShippingZoneWeightBranding')->name('view.shipping.zone.weight.branding');
            Route::patch('settings/shipping/zone/{id}/weight-branding/{weightBrandingId}', 'ShippingSettingController@updateShippingZoneWeightBranding')->name('update.shipping.zone.weight.branding');
            Route::delete('settings/shipping/zone/{id}/weight-branding/{weightBrandingId}', 'ShippingSettingController@deleteShippingZoneWeightBranding')->name('delete.shipping.zone.weight.branding');

            // Shipping Package Type routes...
            Route::get('settings/shipping/package-types', 'ShippingSettingController@showShippingPackageTypes')->name('view.shipping.package.types');
            Route::get('settings/shipping/package-type', 'ShippingSettingController@newShippingPackageType')->name('new.shipping.package.type');
            Route::post('settings/shipping/package-type', 'ShippingSettingController@storeShippingPackageType')->name('store.shipping.package.type');
            Route::get('settings/shipping/package-type/{id}', 'ShippingSettingController@showShippingPackageType')->name('view.shipping.package.type');
            Route::patch('settings/shipping/package-type/{id}', 'ShippingSettingController@updateShippingPackageType')->name('update.shipping.package.type');
            Route::delete('settings/shipping/package-type/{id}', 'ShippingSettingController@deleteShippingPackageType')->name('delete.shipping.package.type');

            // Shipping Weight Branding routes..
            Route::get('settings/shipping/weight-brandings', 'ShippingSettingController@showShippingWeightBrandings')->name('view.shipping.weight.brandings');
            Route::get('settings/shipping/weight-branding', 'ShippingSettingController@newShippingWeightBranding')->name('new.shipping.weight.branding');
            Route::post('settings/shipping/weight-branding', 'ShippingSettingController@storeShippingWeightBranding')->name('store.shipping.weight.branding');
            Route::get('settings/shipping/weight-branding/{id}', 'ShippingSettingController@showShippingWeightBranding')->name('view.shipping.weight.branding');
            Route::patch('settings/shipping/weight-branding/{id}', 'ShippingSettingController@updateShippingWeightBranding')->name('update.shipping.weight.branding');
            Route::delete('settings/shipping/weight-branding/{id}', 'ShippingSettingController@deleteShippingWeightBranding')->name('delete.shipping.weight.branding');
            Route::get('settings/shipping/weight-branding/{id}/add/package/type', 'ShippingSettingController@newWeightBrandingPackageTypeRelation')->name('new.weight.branding.package.type.relation');
            Route::post('settings/shipping/weight-branding/{id}/add/package/type', 'ShippingSettingController@storeWeightBrandingPackageTypeRelation')->name('new.weight.branding.package.type.relation');
            Route::get('settings/shipping/weight-branding/{id}/package/{packageId}', 'ShippingSettingController@showShippingBrandingPackage')->name('view.shipping.branding.package');
            Route::patch('settings/shipping/weight-branding/{id}/package/{packageId}', 'ShippingSettingController@updateShippingBrandingPackage')->name('update.shipping.branding.package');
            Route::delete('settings/shipping/weight-branding/{id}/package/{packageId}', 'ShippingSettingController@deleteShippingBrandingPackage')->name('delete.shipping.branding.package.type');

            // Email Templates routes..
            Route::get('settings/email-templates', 'SettingController@showEmailTemplates')->name('view.email.templates');
            Route::get('settings/email-template', 'SettingController@newEmailTemplate')->name('new.email.template');
            Route::post('settings/email-template', 'SettingController@storeEmailTemplate')->name('store.email.template');
            Route::get('settings/email-template/{id}', 'SettingController@showEmailTemplate')->name('view.email.template');
            Route::patch('settings/email-template/{id}', 'SettingController@updateEmailTemplate')->name('update.email.template');
            Route::delete('settings/email-template/{id}', 'SettingController@deleteEmailTemplate')->name('delete.email.template');

            // Social Media Settings routes...
            Route::get('settings/social-media', 'SettingController@showSocialMediaSettings')->name('view.social.media.settings');
            Route::patch('settings/social-media', 'SettingController@updateSocialMediaSettings')->name('update.social.media.settings');

            // Carousel routes...
            Route::get('carousels', 'CarouselController@showCarousels')->name('view.carousels');
            Route::get('carousel/{id}', 'CarouselController@showCarousel')->name('view.carousel');
            Route::patch('carousel/{id}', 'CarouselController@updateCarousel')->name('update.carousel');
            Route::get('carousel/{id}/slide', 'CarouselController@newSlide')->name('new.carousel.slide');
            Route::post('carousel/{id}/slide', 'CarouselController@storeSlide')->name('store.carousel.slide');
            Route::get('carousel/{id}/slide/{slideId}', 'CarouselController@showSlide')->name('view.carousel.slide');
            Route::patch('carousel/{id}/slide/{slideId}', 'CarouselController@updateSlide')->name('update.carousel.slide');
            Route::delete('carousel/{id}/slide/{slideId}', 'CarouselController@deleteSlide')->name('delete.carousel.slide');
        });

        Route::group(['middleware' => 'role:' . implode(',', [UserRole::TYPE_ADMIN, UserRole::TYPE_MANAGER])], function () {
            // Commission routes...
            Route::get('commissions', 'SaleController@showCommissions')->name('view.commissions');
            Route::get('commission', 'SaleController@newCommission')->name('new.commission');
            Route::post('commission', 'SaleController@storeCommission')->name('store.commission');
            Route::patch('commission/{id}/pay', 'SaleController@payCommission')->name('pay.commission');
            Route::post('commissions/download', 'SaleController@downloadCommissions')->name('download.commissions');
            Route::patch('commissions/update/status', 'SaleController@updateCommissionsStatus')->name('update.commissions.status');

            // Discount codes routes...
            Route::get('discount-codes', 'DiscountCodeController@showDiscountCodes')->name('view.discount.codes');
            Route::get('discount-codes/{group_id}', 'DiscountCodeController@showGroupDiscountCodes')->name('view.group.discount.codes');
            Route::get('discount-codes-bulk', 'DiscountCodeController@showBulkDiscountCodes')->name('view.bulk.discount.codes');
            Route::get('discount-code', 'DiscountCodeController@newDiscountCode')->name('new.discount.code');
            Route::post('discount-code', 'DiscountCodeController@storeDiscountCode')->name('store.discount.code');
            Route::get('discount-code/{id}', 'DiscountCodeController@showDiscountCode')->name('view.discount.code');
            Route::patch('discount-code/{id}', 'DiscountCodeController@updateDiscountCode')->name('update.discount.code');
            Route::delete('discount-code/{id}', 'DiscountCodeController@deleteDiscountCode')->name('delete.discount.code');

            Route::get('discount-code-bulk', 'DiscountCodeController@generateBulkDiscountCode')->name('view.discount.code.bulk');
            Route::post('discount-code-bulk', 'DiscountCodeController@storeBulkDiscountCode')->name('view.discount.code.bulk');
            Route::get('discount-code-bulk/{id}', 'DiscountCodeController@downloadDiscountCodesCSV')->name('download.discount.codes.csv');

            // Weekly contests routes...
            Route::get('weekly-contests', 'WeeklyContestController@showWeeklyContests')->name('view.weekly.contests');
            Route::get('weekly-contest', 'WeeklyContestController@newWeeklyContest')->name('new.weekly.contest');
            Route::post('weekly-contest', 'WeeklyContestController@storeWeeklyContest')->name('store.weekly.contest');
            Route::get('weekly-contest/{id}', 'WeeklyContestController@showWeeklyContest')->name('view.weekly.contest');
            Route::patch('weekly-contest/{id}', 'WeeklyContestController@updateWeeklyContest')->name('update.weekly.contest');
            Route::delete('weekly-contest/{id}', 'WeeklyContestController@deleteWeeklyContest')->name('delete.weekly.contest');
            Route::get('weekly-contest/{id}/download', 'WeeklyContestController@downloadWeeklyContestReport')->name('download.weekly.contest.report');

            // Pages routes...
            Route::get('pages', 'PageController@showPages')->name('show.pages');
            Route::get('page/{id}', 'PageController@showPage')->name('show.page');
            Route::patch('page/{id}', 'PageController@updatePage')->name('update.page');
            Route::get('new-page', 'PageController@newPage')->name('show.new.page');
            Route::post('new-page', 'PageController@storePage')->name('store.new.page');
            Route::delete('page/delete/{id}', 'PageController@deletePage')->name('destroy.page');

            // FAQ categories routes...
            Route::get('faq/categories', 'FaqController@showFaqCategories')->name('view.faq.categories');
            Route::get('faq/category', 'FaqController@newFaqCategory')->name('new.faq.category');
            Route::post('faq/category', 'FaqController@storeFaqCategory')->name('store.faq.category');
            Route::get('faq/category/{id}', 'FaqController@showFaqCategory')->name('view.faq.category');
            Route::patch('faq/category/{id}', 'FaqController@updateFaqCategory')->name('update.faq.category');
            Route::delete('faq/category/{id}', 'FaqController@deleteFaqCategory')->name('delete.faq.category');

            // FAQ's routes...
            Route::get('faqs', 'FaqController@showFaqs')->name('view.faqs');
            Route::get('faq', 'FaqController@newFaq')->name('new.faq');
            Route::post('faq', 'FaqController@storeFaq')->name('store.faq');
            Route::get('faq/{id}', 'FaqController@showFaq')->name('view.faq');
            Route::patch('faq/{id}', 'FaqController@updateFaq')->name('update.faq');
            Route::delete('faq/{id}', 'FaqController@deleteFaq')->name('delete.faq');

            // Design Tip Category routes...
            Route::get('design-tip/categories', 'DesignTipController@showDesignTipCategories')->name('view.design.tip.categories');
            Route::get('design-tip/category', 'DesignTipController@newDesignTipCategory')->name('new.design.tip.category');
            Route::post('design-tip/category', 'DesignTipController@storeDesignTipCategory')->name('store.design.tip.category');
            Route::get('design-tip/category/{id}', 'DesignTipController@showDesignTipCategory')->name('view.design.tip.category');
            Route::patch('design-tip/category/{id}', 'DesignTipController@updateDesignTipCategory')->name('update.design.tip.category');
            Route::delete('design-tip/category/{id}', 'DesignTipController@deleteDesignTipCategory')->name('delete.design.tip.category');

            // Design Tips routes...
            Route::get('design-tips', 'DesignTipController@showDesignTips')->name('view.design.tips');
            Route::get('design-tip', 'DesignTipController@newDesignTip')->name('new.design.tip');
            Route::post('design-tip', 'DesignTipController@storeDesignTip')->name('store.design.tip');
            Route::get('design-tip/{id}', 'DesignTipController@showDesignTip')->name('view.design.tip');
            Route::patch('design-tip/{id}', 'DesignTipController@updateDesignTip')->name('update.design.tip');
            Route::delete('design-tip/{id}', 'DesignTipController@deleteDesignTip')->name('delete.design.tip');

            // About routes...
            Route::get('about-us', 'AboutController@about')->name('view.about');
            Route::patch('about-us', 'AboutController@storeAbout')->name('view.about');

            // Home Blocks routes...
            Route::get('blocks', 'BlockController@showBlocks')->name('view.blocks');
            Route::get('new-block', 'BlockController@newBlock')->name('view.new.block');
            Route::post('new-block', 'BlockController@storeBlock')->name('store.new.block');
            Route::get('block/{id}', 'BlockController@showBlock')->name('view.block');
            Route::patch('block/{id}', 'BlockController@updateBlock')->name('update.block');
            Route::delete('block/{id}', 'BlockController@deleteBlock')->name('delete.block');

            // Home Rows routes...
            Route::get('rows', 'RowController@showRows')->name('view.rows');
            Route::get('new-row', 'RowController@newRow')->name('view.new.row');
            Route::get('new-row-insert', 'RowController@storeRow')->name('store.new.row');
            Route::get('row/{id}', 'RowController@showRow')->name('view.row');
            Route::get('row/{id}/update', 'RowController@updateRow')->name('update.row');
            Route::delete('row/{id}', 'RowController@deleteRow')->name('delete.row');

            // Menus routes...
            Route::get('menus', 'MenuController@showMenus')->name('view.menus');
            Route::get('new-menu', 'MenuController@newMenu')->name('view.new.menu');
            Route::get('new-menu', 'MenuController@storeMenu')->name('store.new.menu');
            Route::get('menu/{id}', 'MenuController@showMenu')->name('view.menu');
            Route::get('menu/{id}/update', 'MenuController@updateMenu')->name('update.menu');
            Route::delete('menu/{id}', 'MenuController@deleteMenu')->name('delete.menu');

            Route::post('menu-item', 'MenuItemController@store')->name('store.menuitem');
            Route::get('menu-item/{id}', 'MenuItemController@show')->name('view.menuitem');
            Route::patch('menu-item/{id}', 'MenuItemController@edit')->name('update.menuitem');
            Route::delete('menu-item/{id}', 'MenuItemController@destroy')->name('delete.menuitem');

            // Enquiries routes...
            Route::get('enquiries', 'DefaultController@showEnquiries')->name('view.enquiries');
            Route::get('enquiry/{id}/message', 'DefaultController@showEnquiryMessage')->name('view.enquiry.message');
            Route::delete('enquiry/{id}', 'DefaultController@deleteEnquiry')->name('delete.enquiry');

            // Contributor routes...
            Route::get('contributors', 'ContributorController@showUsers')->name('view.contributors');
            Route::get('contributor/{id}', 'ContributorController@showUser')->name('view.contributor');
        });

        Route::group(['middleware' => 'role:' . implode(',', [UserRole::TYPE_ADMIN, UserRole::TYPE_MANAGER, UserRole::TYPE_FACTORY])], function () {
            // Design routes...
            Route::get('designs', 'DesignController@showDesigns')->name('view.designs');
            Route::get('design/{id}', 'DesignController@showDesign')->name('view.design');
            Route::patch('design/{id}', 'DesignController@updateDesign')->name('update.design');
            Route::delete('design/{id}', 'DesignController@deleteDesign')->name('delete.design');
            Route::get('design/{id}/download-file', 'DesignController@downloadFile')->name('download.design.file');
            Route::post('designs/download', 'DesignController@downloadDesigns')->name('download.designs');
            Route::get('design/{id}/comments', 'DesignController@showDesignComments')->name('view.design.comments');
            Route::delete('design/{id}/comment/{commentId}', 'DesignController@deleteDesignComment')->name('delete.design.comment');
            Route::get('design/{id}/comment/{commentId}/content', 'DesignController@showDesignCommentContent')->name('view.design.comment.content');

            // Order routes...
            Route::get('orders', 'OrderController@showOrders')->name('view.orders');
            Route::get('order/{id}', 'OrderController@showOrder')->name('view.order');
            Route::delete('order/{id}', 'OrderController@deleteOrder')->name('delete.order');
            Route::get('order/{id}/print', 'OrderController@printOrder')->name('print.order');
            Route::patch('order/{id}/dispatch', 'OrderController@dispatchOrder')->name('dispatch.order');
        });

        Route::group(['middleware' => 'role:' . implode(',', [UserRole::TYPE_ADMIN, UserRole::TYPE_MANAGER, UserRole::TYPE_MARKETING])], function () {

            // Blog routes...
            Route::get('blog/articles', 'BlogController@showArticles')->name('view.blog.articles');
            Route::get('blog/article', 'BlogController@newArticle')->name('new.blog.article');
            Route::post('blog/article', 'BlogController@storeArticle')->name('store.blog.article');
            Route::get('blog/article/{id}', 'BlogController@showArticle')->name('view.blog.article');
            Route::patch('blog/article/{id}', 'BlogController@updateArticle')->name('update.blog.article');
            Route::delete('blog/article/{id}', 'BlogController@deleteArticle')->name('delete.blog.article');
            Route::get('blog/article/{id}/comments', 'BlogController@showArticleComments')->name('view.blog.article.comments');
            Route::delete('blog/article/{id}/comment/{commentId}', 'BlogController@deleteArticleComment')->name('delete.blog.article.comment');
            Route::get('blog/article/{id}/comment/{commentId}/content', 'BlogController@showArticleCommentContent')->name('view.blog.article.comment.content');

            // CMS Product routes...
            Route::get('cms-products', 'CMSProductController@showProducts')->name('view.cms.products');
            Route::get('cms-product', 'CMSProductController@newProduct')->name('new.cms.product');
            Route::post('cms-product', 'CMSProductController@storeProduct')->name('store.cms.product');
            Route::get('cms-product/{id}', 'CMSProductController@showProduct')->name('view.cms.product');
            Route::patch('cms-product/{id}', 'CMSProductController@updateProduct')->name('update.cms.product');
            Route::delete('cms-product/{id}', 'CMSProductController@deleteProduct')->name('delete.cms.product');

        });

        // Currency routes...
        Route::get('currencies', 'SettingController@showCurrencies')->name('view.currencies');
        Route::get('currency/{id}', 'SettingController@showCurrency')->name('view.currency');
        Route::patch('currency/{id}', 'SettingController@updateCurrency')->name('update.currency');

        Route::get('search-user', 'DefaultController@searchUser')->name('search.user');
        Route::get('search-design', 'DefaultController@searchDesign')->name('search.design');
    });
});
