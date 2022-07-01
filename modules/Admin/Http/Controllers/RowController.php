<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DesignLabel;
use App\Models\Row;
use Illuminate\Http\Request;

class RowController extends Controller
{
    /**
     * RowController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Row);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRows(Request $request)
    {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $rows   = parent::getEntities($offset, [], ['column' => 'created_at', 'type' => 'DESC']);

        if ($request->ajax()) {
            return view('admin::row.row-row', ['rows' => $rows]);
        }

        return view('admin::row.rows', [
            'rows' => $rows,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newRow()
    {
        return view('admin::row.new-row', [
            'statusTypes' => Row::getStatusOptions(),
            'rowTypes' => Row::getRowTypeOptions(),
            'defaultRowOptions' => Row::getDefaultRowOptions(),
            'labels' => DesignLabel::orderBy('title', 'ASC')->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRow($id)
    {
        parent::deleteEntity($id);

        return redirect()->route('admin::view.rows')->withStatus('Row deleted!');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeRow(Request $request)
    {
        if (parent::isValid($request->all())) {

            $row = parent::save($request->all());

            if ($request->input('type') == Row::ROW_TYPE_DESIGN) {
                $row->designs()->sync(explode(' ', trim($request->input('design-data'))));
            }

            return response()->json([
                'success' => true,
                'redirect' => route('admin::view.row', ['id' => $row->id])
            ]);
        }

        return response()->json([
            'success' => false,
            'html' => view('admin::row.form-errors', ['errors' => parent::getErrors($request->all())])->render()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRow($id)
    {
        return view('admin::row.row', [
            'row' => Row::whereId($id)->first(),
            'statusTypes' => Row::getStatusOptions(),
            'rowTypes' => Row::getRowTypeOptions(),
            'defaultRowOptions' => Row::getDefaultRowOptions(),
            'labels' => DesignLabel::orderBy('title', 'ASC')->get(),
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRow(Request $request, $id)
    {
        if (parent::isValid($request->all())) {
            $row = parent::update($request->all(), $id);

            if ($request->input('type') == Row::ROW_TYPE_DESIGN) {
                $row->designs()->sync(explode(' ', trim($request->input('design-data'))));
            }

            return response()->json([
                'success' => true,
                'redirect' => route('admin::view.row', ['id' => $row->id])
            ]);
        }

        return response()->json([
            'success' => false,
            'html' => view('admin::row.form-errors', ['errors' => parent::getErrors($request->all())])->render()
        ]);
    }
}
