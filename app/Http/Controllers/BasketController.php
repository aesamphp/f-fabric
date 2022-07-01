<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Basket;
use Illuminate\Http\Request;
use App\Models\DiscountCode;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class BasketController extends Controller
{
    /**
     * BasketController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Basket);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewData = $this->getViewData();
        return ($viewData['basket'] === null) ? view('basket.empty') : view('basket.index', $viewData);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function storeBasketItem(Request $request)
    {
        $isAjax    = $request->ajax();
        $validator = $this->validateBasketItem($request);
        if ($validator->fails()) {
            if ($isAjax) {
                return response()->view('includes.flash', ['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            }
            return back()->withErrors($validator)
                ->withInput();
        }

        $basketModel = $this->getModel();
        $basketModel->create($request->all());
        $basketModel->updateDiscount();

        return ($isAjax) ? view('includes.basket.index') : redirect()->route('view.basket');
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|Response|\Illuminate\View\View
     */
    public function updateBasketItem(Request $request, $id)
    {
        $isAjax    = $request->ajax();
        $redirect  = redirect()->route('view.basket');
        $validator = Validator::make($request->all(), parent::getModel()->updateRules(), parent::getModel()->messages());
        if ($validator->fails()) {
            if ($isAjax) {
                return response()->view('includes.flash', ['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            }
            return $redirect->withErrors($validator)
                ->withInput();
        }
        $basketModel = $this->getModel();
        $basketModel->update($id, $request->all());
        $basketModel->updateDiscount();

        return ($isAjax) ? view('includes.basket.index') : $redirect->with('status', 'Item updated.');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteBasketItem(Request $request, $id)
    {
        $basketModel = $this->getModel();
        $basketModel->delete($id);
        return redirect()->route('view.basket')
            ->with('status', 'Item removed.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function applyBasketDiscount(Request $request)
    {
        $redirect     = redirect()->back();
        $discountCode = DiscountCode::findByCode($request->input('promo_code'));
        if ($discountCode === null || !$discountCode->hasPassedApplyRules()) {
            return $redirect->with('error', 'Promo code not found!');
        }
        session()->put('discountCodeId', $discountCode->id);
        return $redirect->with('status', 'Promo code applied.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteBasketDiscount(Request $request)
    {
        session()->forget('discountCodeId');
        return redirect()->back()
            ->with('status', 'Promo code removed.');
    }

    /**
     * @param $request
     * @return mixed
     */
    private function validateBasketItem($request)
    {
        return Validator::make($request->all(), parent::getModel()->rules(), parent::getModel()->messages());
    }

    /**
     * @param array $data
     * @return array
     */
    private function getViewData(Array $data = [])
    {
        $basketModel = $this->getModel();
        return array_merge([
            'basket' => $basketModel->getBasketItems(),
            'subTotal' => $basketModel->getBasketSubtotal(true),
            'vat' => $basketModel->getBasketVat(true),
            'total' => $basketModel->getBasketGrandTotal(true)
        ], $data);
    }

}
