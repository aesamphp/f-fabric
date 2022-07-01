<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use App\Models\DiscountCodeGroups;
use Illuminate\Http\Request;
use League\Csv\Writer;
use SplTempFileObject;

class DiscountCodeController extends Controller
{

    /**
     * DiscountCodeController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new DiscountCode);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBulkDiscountCodes(Request $request)
    {
        $this->setModel(new DiscountCodeGroups());

        $offset             = ($request->has('offset')) ? $request->input('offset') : 0;
        $discountCodeGroups = parent::getEntities($offset);

        if ($request->ajax()) {
            return view('admin::discount-code.bulk-discount-code-row', ['discountCodeGroups' => $discountCodeGroups]);
        }

        return view('admin::discount-code.bulk-discount-codes', [
            'discountCodeGroups' => $discountCodeGroups,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDiscountCodes(Request $request)
    {
        $offset        = ($request->has('offset')) ? $request->input('offset') : 0;
        $discountCodes = parent::getEntities($offset, [], ['column' => 'created_at', 'type' => 'DESC']);
        if ($request->ajax()) {
            return view('admin::discount-code.discount-code-row', ['discountCodes' => $discountCodes]);
        }
        return view('admin::discount-code.discount-codes', [
            'discountCodes' => $discountCodes,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @param Request $request
     * @param null $groupId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showGroupDiscountCodes(Request $request, $groupId = null)
    {
        $offset        = ($request->has('offset')) ? $request->input('offset') : 0;
        $discountCodes = parent::getEntities($offset, [['column' => 'group_id', 'condition' => '=', 'value' => (int)$groupId]]);

        if ($request->ajax()) {
            return view('admin::discount-code.discount-code-row', ['discountCodes' => $discountCodes]);
        }

        return view('admin::discount-code.discount-codes', [
            'discountCodes' => $discountCodes,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newDiscountCode(Request $request)
    {
        return view('admin::discount-code.new-discount-code');
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function storeDiscountCode(Request $request)
    {
        $redirect = redirect()->route('admin::new.discount.code');
        $entity   = parent::storeEntity($request->all(), $redirect);
        if (!isset($entity->id)) {
            return $entity;
        }
        return redirect()->route('admin::view.discount.codes')
            ->with('status', 'Discount code created!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDiscountCode(Request $request, $id)
    {
        return view('admin::discount-code.discount-code', ['discountCode' => parent::getEntity($id)]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDiscountCode(Request $request, $id)
    {
        $redirect = redirect()->route('admin::view.discount.code', ['id' => $id]);
        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Discount code updated!');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDiscountCode(Request $request, $id)
    {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.discount.codes')
            ->with('status', 'Discount code deleted!');
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function generateBulkDiscountCode(Request $request)
    {
        return view('admin::discount-code.new-discount-code-bulk');
    }

    /**
     * @param Request $request
     * @return int
     */
    public function storeBulkDiscountCode(Request $request)
    {
        $quantity = $request->get('quantity');
        $prefix   = $request->get('prefix');
        $redirect = redirect()->route('admin::view.discount.code.bulk');

        if (DiscountCode::where('code', $prefix . '-000')->first()) {
            return $redirect->with('error', 'Discount codes for this prefix have already been created');
        }

        if ($quantity > 500) {
            return $redirect->with('error', 'No more than 500 discount codes can be created');
        }

        $request->merge(['prefix' => $prefix, 'quantity' => $quantity]);
        $discountCodeGroup = DiscountCodeGroups::create($request->all());

        $csvData = [['Code']];

        for ($i = 0; $i <= $quantity; $i++) {
            $request->merge(['code' => $prefix . '-' . substr(md5(uniqid(rand(), true)), 0, 6), 'group_id' => $discountCodeGroup->id]);
            DiscountCode::create($request->all());

            $csvData[] = [
                'code' => $request->get('code'),
            ];
        }

        $fileName = DiscountCode::getCSVFilePath();
        $csv      = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertAll($csvData);

        return $csv->output($fileName);
    }

    /**
     * @param $id
     * @return int
     */
    public function downloadDiscountCodesCSV($id)
    {
        $csvData = [['Code']];

        foreach (DiscountCode::where("group_id", $id)->get() as $code) {
            $csvData[] = [
                "code" => $code['code']
            ];
        }

        $fileName = DiscountCode::getCSVFilePath();
        $csv      = Writer::createFromFileObject(new SplTempFileObject());
        $csv->insertAll($csvData);

        return $csv->output($fileName);
    }

}
