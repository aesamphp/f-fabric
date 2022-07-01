<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use App\Models\Basket as BasketModel;

class Basket {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $basket = BasketModel::getBasketItems();
        if ($basket === null) {
            if ($request->ajax()) {
                return response('Your shopping basket is empty.', Response::HTTP_BAD_REQUEST);
            }
            return redirect()->route('view.basket');
        }
        return $next($request);
    }

}
