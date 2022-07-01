<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Design;
use App\Models\Enquiry;
use App\Models\Studio;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

/**
 * Class DefaultController
 * @package Modules\Admin\Http\Controllers
 */
class DefaultController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin::default.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEnquiries(Request $request)
    {
        $this->setModel(new Enquiry);
        $offset        = ($request->has('offset')) ? $request->input('offset') : 0;
        $searchKeyword = ($request->has('search_keyword')) ? $request->get('search_keyword') : null;
        $fromDate      = ($request->has('from_date')) ? $request->get('from_date') : null;
        $toDate        = ($request->has('to_date')) ? $request->get('to_date') : null;
        $sort_by       = ($request->has('sort_by')) ? $request->input('sort_by') : 'new';

        if ($sort_by == 'name') {
            $orderBy = ['column' => 'name', 'type' => 'ASC'];
        } elseif ($sort_by == 'new') {
            $orderBy = ['column' => 'created_at', 'type' => 'ASC'];
        } else {
            $orderBy = ['column' => 'created_at', 'type' => 'DESC'];
        }

        if ($fromDate !== null && $toDate !== null) {
            $query = array(array('created_at' => '>=', 'value' => $fromDate));
        } else {
            $query = array();
        }

        $enquiries = $searchKeyword ? $this->searchEnquiries($searchKeyword, $offset) : parent::getEntities($offset, $query, $orderBy);

        if ($request->ajax()) {
            return view('admin::default.enquiry-row', ['enquiries' => $enquiries]);
        }
        return view('admin::default.enquiries', [
            'searchKeyword' => $searchKeyword,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'enquiries' => $enquiries,
            'sort_by' => $sort_by,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEnquiryMessage($id)
    {
        $this->setModel(new Enquiry);
        return view('admin::default.enquiry-message', ['enquiry' => parent::getEntity($id)]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteEnquiry(Request $request, $id)
    {
        $this->setModel(new Enquiry);
        parent::deleteEntity($id);
        return redirect()->route('admin::view.enquiries')
            ->with('status', 'Enquiry deleted!');
    }

    /**
     * @param $keyword
     * @param $offset
     * @return mixed
     */
    private function searchEnquiries($keyword, $offset)
    {
        $model = parent::getModel();
        return $model::select('enquiries.*')
            ->where(function ($query) use ($keyword) {
                $query->where('enquiries.name', 'like', '%' . $keyword . '%')
                    ->orWhere('enquiries.email', 'like', '%' . $keyword . '%');
            })
            ->orderBy('enquiries.created_at', 'DESC')
            ->take($this->getLimit())
            ->skip($offset)
            ->get();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function searchUser(Request $request)
    {
        $users = Studio::getUsersFromName('%' . $request->search . '%');

        return response()->json([
            'html' => view('admin::row.user-search-result', compact('users'))->render()
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function searchDesign(Request $request)
    {
        $designs = Design::getDesignsBySearch('%' . $request->search . '%');

        return response()->json([
            'html' => view('admin::row.design-search-result', compact('designs'))->render()
        ]);
    }
}
