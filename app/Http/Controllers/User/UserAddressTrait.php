<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Country;
use App\Models\USState;

trait UserAddressTrait {

    public function storeAddress(Request $request) {
        $this->setModel(new UserAddress);
        $redirect = redirect()->route('view.user.account.tab', ['tab' => 'address']);
        parent::storeEntity($request->all(), $redirect);
        return $redirect->with('status', 'Address added successfully!');
    }

    public function deleteAddress(Request $request, $id) {
        $this->setModel(new UserAddress);
        $redirect = redirect()->route('view.user.account.tab', ['tab' => 'address']);
        parent::deleteEntity($id);
        return $redirect->with('status', 'Address deleted successfully!');
    }

    public function updateAddress(Request $request, $id) {
        $this->setModel(new UserAddress);
        $redirect = redirect()->route('view.user.account.tab', ['tab' => 'address']);
        if ($request->ajax()) {
            return parent::validateEntityAjax($request->all(), $id, $redirect);
        }
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Address updated successfully!');
    }

    public function getAddress(Request $request, $id) {
        $this->setModel(new UserAddress);
        return view('user.account.edit-address-form', [
            'countries' => Country::getCountriesListRearranged(),
            'states' => USState::all(),
            'address' => parent::getEntityByFields([
                ['column' => 'id', 'condition' => '=', 'value' => $id],
                ['column' => 'user_id', 'condition' => '=', 'value' => getAuthenticatedUser()->id],
            ])
        ]);
    }

}
