<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\User\UserAddressTrait;
use App\Http\Controllers\User\UserPaymentTrait;
use App\Models\User;
use App\Models\Category;
use App\Models\Country;
use App\Models\USState;
use App\Models\Studio;
use App\Models\Design;
use Validator;
use Auth;

class UserController extends Controller {

    use UserAddressTrait,
        UserPaymentTrait;

    public function __construct() {
        parent::__construct();
        $this->setModel(new User);
    }

    public function showAccount(Request $request, $tab = null) {
        return view('user.account', [
            'tab' => $tab,
            'user' => getAuthenticatedUser(),
            'countries' => Country::getCountriesListRearranged(),
            'states' => USState::all()
        ]);
    }

    public function updateAccount(Request $request) {
        $redirect = redirect()->route('view.user.account');
        parent::updateEntity($request->all(), getAuthenticatedUser()->id, $redirect);
        return $redirect->with('status', 'Account settings updated!');
    }

    public function deleteAccount(Request $request) {
        parent::deleteEntity(getAuthenticatedUser()->id);
        Auth::logout();
        session()->flush();
        return redirect()->route('home');
    }

    public function updatePassword(Request $request) {
        $redirect = redirect()->route('view.user.account');
        $user = getAuthenticatedUser();
        $user->setScenario('update-password');
        $validator = Validator::make($request->all(), $user->rules(), $user->messages());
        if ($validator->fails()) {
            return $redirect->withErrors($validator)
                            ->withInput();
        }
        $user->fill(['password' => bcrypt($request->input('password'))]);
        $user->update();
        return $redirect->with('status', 'Account password updated!');
    }

    public function updateEmailSettings(Request $request) {
        $redirect = redirect()->route('view.user.account.tab', ['tab' => 'email']);
        parent::updateEntity($request->all(), getAuthenticatedUser()->id, $redirect);
        return $redirect->with('status', 'Email settings saved successfully!');
    }

    public function showFavorites(Request $request) {
        return view('user.favorites', [
            'favouriteDesigns' => getAuthenticatedUser()->favourites
        ]);
    }

    public function deleteFavorites(Request $request) {
        foreach (getAuthenticatedUser()->favourites as $favourite) {
            $favourite->delete();
        }
        return redirect()->route('view.user.favorites')
                        ->with('status', 'Favorites list cleared successfully!');
    }

    public function showDesigns(Request $request, $categoryId = null) {
        $this->setLimit(16);
        $user = getAuthenticatedUser();
        $keyword = null;
        if ($request->has('keyword')) {
            $keyword = $request->get('keyword');
            $designs = $user->getSearchDesigns($keyword, $this->getLimit());
        } elseif ($categoryId === null) {
            $designs = $user->getActiveDesigns($this->getLimit());
        } elseif ($categoryId === 'not-for-sale') {
            $designs = $user->getNotForSaleDesigns($this->getLimit());
        } else {
            $designs = $user->getCategoryDesigns($categoryId, $this->getLimit());
        }
        $appends = ['keyword' => $keyword];
        return view('user.designs', [
            'user' => $user,
            'categoryId' => $categoryId,
            'keyword' => $keyword,
            'appends' => $appends,
            'categories' => Category::getShoppableCategories(),
            'designs' => $designs,
            'shop' => $user->studio,
            'designsTotalCount' => $user->getAllDesignsCount(),
            'designsNotForSaleCount' => $user->getNotForSaleDesignsCount(),
        ]);
    }

    public function showEditShop(Request $request) {
        return view('user.edit-shop', [
            'countries' => Country::getCountriesListRearranged(),
            'shop' => getAuthenticatedUser()->studio
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteShopImage(Request $request, $image)
    {
        $this->setModel(new Studio);
        $redirect = redirect()->route('edit.user.shop');

        if (!$image == 'image_path' && !$image == 'header_image_file') {
            return $redirect->with('error', "Sorry something went wrong, your image hasn't been deleted.");
        }

        $request->merge([$image => null]);

        parent::updateEntity($request->all(), getAuthenticatedUser()->studio->id, $redirect);
        return $redirect->with('status', 'Your settings have been successfully saved.');
    }

    public function updateShop(Request $request) {
        $this->setModel(new Studio);
        $redirect = redirect()->route('edit.user.shop');
        $validator = $this->validateShopImages($request);
        if ($validator->fails()) {
            return $redirect->withErrors($validator)
                            ->withInput();
        }
        if ($request->hasFile('image_file')) {
            $request->merge(['image_path' => parent::uploadFile($request->file('image_file'), Studio::IMAGE_DESTINATION_PATH)]);
        }
        if ($request->hasFile('header_image_file')) {
            $request->merge(['header_image_path' => parent::uploadFile($request->file('header_image_file'), Studio::IMAGE_DESTINATION_PATH)]);
        }
        parent::updateEntity($request->all(), getAuthenticatedUser()->studio->id, $redirect);
        return $redirect->with('status', 'Your settings have been successfully saved.');
    }

    public function showMyStudio(Request $request) {
        $user = getAuthenticatedUser();
        return view('user.studio', [
            'user' => $user,
            'categories' => Category::getShoppableCategories(),
            'designsTotalCount' => $user->getAllDesignsCount(),
            'designsNotForSaleCount' => $user->getNotForSaleDesignsCount(),
            'shop' => $user->studio,
            'latestDesigns' => $user->getLatestDesigns(),
            'favouriteDesigns' => $user->getFavouriteDesigns(),
            'recommendedDesigns' => Design::getRecommendedDesigns(),
            'recentOrders' => $user->getRecentOrders()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function studioPromotion()
    {
        return view('user.promotion');
    }

    private function validateShopImages($request) {
        $rules = [];
        if (!$request->has('image_path') || $request->hasFile('image_file')) {
            $rules['image_file'] = 'max:1000|validateImage';
        }
        if (!$request->has('header_image_path') || $request->hasFile('header_image_file')) {
            $rules['header_image_file'] = 'max:1000|validateImage';
        }
        return Validator::make($request->only('image_file', 'header_image_file'), $rules, ['required' => 'The :attribute is required.', 'validate_image' => 'The :attribute must be an image.']);
    }

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function buildWidget()
	{
		return view('user.build-widget');
	}

	/**
	 * @param $request
	 * @return array
	 */
	public function buildWidgetAjax(Request $request)
	{
		$user          = getAuthenticatedUser();
		$designs       = $request->get('designs');
		$display       = $request->get('display');
		$order         = $request->get('order');
		$layoutColumns = $request->get('layout-columns');
		$layoutRows    = $request->get('layout-rows');
		$images        = $user->getImagesForWidgetBuilder($layoutColumns * $layoutRows, $designs, $order);

		return view('includes.widget-builder',
			[
				"images" => $images,
				"display" => $display,
				"design" => $designs,
				"user" => $user,
				"layoutColumns" => $layoutColumns,
				"layoutRows" => $layoutRows
			]
		);
	}
}
