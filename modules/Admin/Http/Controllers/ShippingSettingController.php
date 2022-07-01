<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingPackageBranding;
use App\Models\ShippingPackageType;
use App\Models\ShippingWeightBranding;
use App\Models\ShippingZone;
use App\Models\ShippingZoneBranding;
use Illuminate\Http\Request;

/**
 * Class ShippingSettingController
 * @package Modules\Admin\Http\Controllers
 */
class ShippingSettingController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showShippingZones(Request $request)
    {
        $this->setModel(new ShippingZone);
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $zones  = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::setting.shipping.shipping-zone-row', ['zones' => $zones]);
        }
        return view('admin::setting.shipping.shipping-zones', [
            'zones' => $zones,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showShippingZone(Request $request, $id)
    {
        $this->setModel(new ShippingZone);
        return view('admin::setting.shipping.shipping-zone', ['zone' => parent::getEntity($id)]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateShippingZone(Request $request, $id)
    {
        $this->setModel(new ShippingZone);
        $redirect = redirect()->route('admin::view.shipping.zone', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Shipping zone updated!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newShippingZone(Request $request)
    {
        $this->setModel(new ShippingZone);
        return view('admin::setting.shipping.new-shipping-zone');
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function storeShippingZone(Request $request)
    {
        $this->setModel(new ShippingZone);
        $redirect = redirect()->route('admin::new.shipping.zone');
        $entity   = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.shipping.zone', ['id' => $entity->id])
            ->with('status', 'Shipping zone created!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteShippingZone(Request $request, $id)
    {
        $this->setModel(new ShippingZone);
        parent::deleteEntity($id);
        return redirect()->route('admin::view.shipping.zones')
            ->with('status', 'Shipping zone deleted!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newShippingZoneCountry(Request $request, $id)
    {
        $this->setModel(new ShippingZone);
        return view('admin::setting.shipping.shipping-zone-country', [
            'zone' => parent::getEntity($id),
            'countries' => Country::where('zone_id', null)->get()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateShippingZoneCountry(Request $request, $id)
    {
        $this->setModel(new ShippingZone);
        $entity = parent::getEntity($id);
        $this->setModel(new Country);
        $redirect = redirect()->route('admin::view.shipping.zone', ['id' => $id]);
        parent::updateEntity(['zone_id' => $entity->id], $request->country_id, $redirect);
        return $redirect->with('status', 'Shipping zone country added!');
    }

    /**
     * @param Request $request
     * @param $id
     * @param $countryId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteShippingZoneCountry(Request $request, $id, $countryId)
    {
        $this->setModel(new Country);
        $redirect = redirect()->route('admin::view.shipping.zone', ['id' => $id]);
        parent::updateEntity(['zone_id' => null], $countryId, $redirect);
        return $redirect->with('status', 'Shipping zone country deleted!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newShippingZoneWeightBranding(Request $request, $id)
    {
        $this->setModel(new ShippingZone);
        $zone              = parent::getEntity($id);
        $weightBrandingIds = [];
        foreach ($zone->brandings as $branding) {
            $weightBrandingIds[] = $branding->weight_branding_id;
        }
        return view('admin::setting.shipping.new-shipping-zone-weight-branding', [
            'zone' => $zone,
            'brandings' => ShippingWeightBranding::whereNotIn('id', $weightBrandingIds)->get()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function storeShippingZoneWeightBranding(Request $request, $id)
    {
        $this->setModel(new ShippingZone);
        $zone = parent::getEntity($id);
        $this->setModel(new ShippingZoneBranding);
        $redirect = redirect()->route('admin::new.shipping.zone.weight.branding', ['id' => $id]);
        $request->merge(['zone_id' => $zone->id]);
        $entity = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.shipping.zone', ['id' => $id])
            ->with('status', 'Shipping zone weight branding added!');
    }

    /**
     * @param Request $request
     * @param $id
     * @param $weightBrandingId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showShippingZoneWeightBranding(Request $request, $id, $weightBrandingId)
    {
        $this->setModel(new ShippingZoneBranding);
        return view('admin::setting.shipping.shipping-zone-weight-branding', [
            'branding' => parent::getEntityByFields([
                ['column' => 'zone_id', 'condition' => '=', 'value' => $id],
                ['column' => 'weight_branding_id', 'condition' => '=', 'value' => $weightBrandingId]
            ])
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $weightBrandingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateShippingZoneWeightBranding(Request $request, $id, $weightBrandingId)
    {
        $this->setModel(new ShippingZoneBranding);
        $entity   = parent::getEntityByFields([
            ['column' => 'zone_id', 'condition' => '=', 'value' => $id],
            ['column' => 'weight_branding_id', 'condition' => '=', 'value' => $weightBrandingId]
        ]);
        $redirect = redirect()->route('admin::view.shipping.zone.weight.branding', ['id' => $entity->zone_id, 'weightBrandingId' => $entity->weight_branding_id]);
        parent::updateEntity($request->all(), $entity->id, $redirect);
        return $redirect->with('status', 'Shipping zone weight branding updated!');
    }

    /**
     * @param Request $request
     * @param $id
     * @param $weightBrandingId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteShippingZoneWeightBranding(Request $request, $id, $weightBrandingId)
    {
        $this->setModel(new ShippingZoneBranding);
        parent::deleteEntityByFields([
            ['column' => 'zone_id', 'condition' => '=', 'value' => $id],
            ['column' => 'weight_branding_id', 'condition' => '=', 'value' => $weightBrandingId]
        ]);
        return redirect()->route('admin::view.shipping.zone', ['id' => $id])
            ->with('status', 'Shipping zone weight branding deleted!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showShippingPackageTypes(Request $request)
    {
        $this->setModel(new ShippingPackageType);
        $offset       = ($request->has('offset')) ? $request->input('offset') : 0;
        $packageTypes = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::setting.shipping.package-type-row', ['packageTypes' => $packageTypes]);
        }
        return view('admin::setting.shipping.package-types', [
            'packageTypes' => $packageTypes,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showShippingPackageType(Request $request, $id)
    {
        $this->setModel(new ShippingPackageType);
        return view('admin::setting.shipping.package-type', ['packageType' => parent::getEntity($id)]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateShippingPackageType(Request $request, $id)
    {
        $this->setModel(new ShippingPackageType);
        $redirect = redirect()->route('admin::view.shipping.package.type', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Shipping package type updated!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newShippingPackageType(Request $request)
    {
        $this->setModel(new ShippingPackageType);
        return view('admin::setting.shipping.new-package-type');
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function storeShippingPackageType(Request $request)
    {
        $this->setModel(new ShippingPackageType);
        $redirect = redirect()->route('admin::new.shipping.package.type');
        $entity   = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.shipping.package.type', ['id' => $entity->id])
            ->with('status', 'Shipping package type created!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteShippingPackageType(Request $request, $id)
    {
        $this->setModel(new ShippingPackageType);
        parent::deleteEntity($id);
        return redirect()->route('admin::view.shipping.package.types')
            ->with('status', 'Shipping package type deleted!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showShippingWeightBrandings(Request $request)
    {
        $this->setModel(new ShippingWeightBranding);
        $offset          = ($request->has('offset')) ? $request->input('offset') : 0;
        $weightBrandings = parent::getEntities($offset, [
            ['column' => 'disabled', 'condition' => '=', 'value' => 0]
        ]);
        if ($request->ajax()) {
            return view('admin::setting.shipping.weight-brandings-row', ['weightBrandings' => $weightBrandings]);
        }
        return view('admin::setting.shipping.weight-brandings', [
            'weightBrandings' => $weightBrandings,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showShippingWeightBranding(Request $request, $id)
    {
        $this->setModel(new ShippingWeightBranding);
        return view('admin::setting.shipping.weight-branding', [
            'weightBranding' => parent::getEntity($id),
            'types' => ShippingWeightBranding::getTypeOptions()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateShippingWeightBranding(Request $request, $id)
    {
        $this->setModel(new ShippingWeightBranding);
        $redirect = redirect()->route('admin::view.shipping.weight.branding', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Shipping weight branding updated!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newShippingWeightBranding(Request $request)
    {
        $this->setModel(new ShippingWeightBranding);
        return view('admin::setting.shipping.new-weight-branding', [
            'types' => ShippingWeightBranding::getTypeOptions()
        ]);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function storeShippingWeightBranding(Request $request)
    {
        $this->setModel(new ShippingWeightBranding);
        $redirect = redirect()->route('admin::new.shipping.weight.branding');
        $entity   = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.shipping.weight.branding', ['id' => $entity->id])
            ->with('status', 'Shipping weight branding created!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteShippingWeightBranding(Request $request, $id)
    {
        $this->setModel(new ShippingWeightBranding);
        parent::deleteEntity($id);
        return redirect()->route('admin::view.shipping.weight.brandings')
            ->with('status', 'Shipping weight branding deleted!');
    }

    /**
     * @param Request $request
     * @param $id
     * @param $packageId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showShippingBrandingPackage(Request $request, $id, $packageId)
    {
        $this->setModel(new ShippingPackageBranding);
        return view('admin::setting.shipping.branding-package', [
            'brandingPackage' => parent::getEntityByFields([
                ['column' => 'weight_branding_id', 'condition' => '=', 'value' => $id],
                ['column' => 'package_type_id', 'condition' => '=', 'value' => $packageId]
            ])
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param $packageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateShippingBrandingPackage(Request $request, $id, $packageId)
    {
        $this->setModel(new ShippingPackageBranding);
        $entity   = parent::getEntityByFields([
            ['column' => 'weight_branding_id', 'condition' => '=', 'value' => $id],
            ['column' => 'package_type_id', 'condition' => '=', 'value' => $packageId]
        ]);
        $redirect = redirect()->route('admin::view.shipping.weight.branding', ['id' => $id]);
        parent::updateEntity($request->all(), $entity->id, $redirect);
        return $redirect->with('status', 'Shipping branding package updated!');
    }

    /**
     * @param Request $request
     * @param $id
     * @param $packageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteShippingBrandingPackage(Request $request, $id, $packageId)
    {
        $this->setModel(new ShippingPackageBranding);

        $entity = ShippingPackageBranding::whereWeightBrandingId($id)
            ->wherePackageTypeId($packageId)
            ->first();

        parent::deleteEntity($entity->id);

        return redirect()->route('admin::view.shipping.weight.branding', ['id' => $id])
            ->with('status', 'Weight branding package type has been deleted');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newWeightBrandingPackageTypeRelation($id)
    {
        $this->setModel(new ShippingPackageBranding);

        $weightBranding     = ShippingWeightBranding::whereId($id)->first();
        $packageTypes       = ShippingPackageType::whereDeletedAt(null)->get();
        $packageTypeOptions = [];

        foreach ($packageTypes as $packageType) {
            if (!ShippingPackageBranding::whereWeightBrandingId($id)->wherePackageTypeId($packageType->id)->first()) {
                $packageTypeOptions[] = ['id' => $packageType->id, 'title' => $packageType->title];
            }
        }

        return view('admin::setting.shipping.new-weight-branding-package-type-relation',
            [
                'weightBranding' => $weightBranding,
                'packageTypeOptions' => $packageTypeOptions
            ]
        );
    }

    /**
     * @param $id
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function storeWeightBrandingPackageTypeRelation($id, Request $request)
    {
        $this->setModel(new ShippingPackageBranding);

        $request->merge(['weight_branding_id' => $id]);
        $redirect = redirect()->route('admin::new.shipping.zone');
        $entity   = parent::storeEntity($request->all(), $redirect);

        if (!isset($entity->id)) {
            return $entity;
        }

        return redirect()->route('admin::view.shipping.branding.package', ['id' => $id, 'packageId' => $request->input('package_type_id')])
            ->with('status', 'Package type has been added to weight branding');
    }
}
