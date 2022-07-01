<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Design;
use App\Models\DesignComment;

class DesignController extends Controller {
    
    public function __construct() {
        parent::__construct();
        $this->setModel(new Design);
    }
    
    public function showDesigns(Request $request) {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $searchKeyword = ($request->has('search_keyword')) ? $request->get('search_keyword') : null;
        $designs = $searchKeyword ? $this->searchDesigns($searchKeyword, $offset) : parent::getEntities($offset, [['column' => 'disabled', 'condition' => '=', 'value' => 0]], ['column' => 'created_at', 'type' => 'DESC']);
        if ($request->ajax()) {
            return view('admin::design.design-row', ['designs' => $designs]);
        }
        return view('admin::design.designs', [
            'searchKeyword' => $searchKeyword,
            'designs' => $designs,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function showDesign(Request $request, $id) {
        return view('admin::design.design', ['design' => parent::getEntity($id)]);
    }
    
    public function updateDesign(Request $request, $id) {
        $design = parent::getEntity($id);
        foreach ($request->all() as $key => $value) {
            if (isset($design->$key)) {
                $design->$key = $value;
            }
        }
        $design->update();
        if ($request->ajax()) {
            return response('Design saved successfully!');
        }
        return redirect()->route('admin::view.design', ['id' => $design->id])
                ->with('status', 'Design saved successfully!');
    }
    
    public function deleteDesign(Request $request, $id) {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.designs')
                ->with('status', 'Design deleted!');
    }
    
    public function downloadFile(Request $request, $id) {
        $design = parent::getEntity($id);
        $filePath = $design->getImagePath(getDesignImageType('TYPE_ORIGINAL'));
        return response()->download(public_path($filePath), $design->getDownloadFileName($filePath));
    }
    
    public function downloadDesigns(Request $request) {
        $redirect = redirect()->route('admin::view.designs');
        return parent::downloadCSV($request->all(), $redirect);
    }
    
    public function showDesignComments(Request $request, $id) {
        $this->setModel(new DesignComment);
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $comments = parent::getEntities($offset, [
            ['column' => 'design_id', 'condition' => '=', 'value' => $id]
        ]);
        if ($request->ajax()) {
            return view('admin::design.comment-row', ['comments' => $comments]);
        }
        return view('admin::design.comments', [
            'comments' => $comments,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }
    
    public function deleteDesignComment(Request $request, $id, $commentId) {
        $this->setModel(new DesignComment);
        parent::deleteEntityByFields([
            ['column' => 'design_id', 'condition' => '=', 'value' => $id],
            ['column' => 'id', 'condition' => '=', 'value' => $commentId]
        ]);
        return redirect()->route('admin::view.design.comments', ['id' => $id])
                ->with('status', 'Comment deleted!');
    }
    
    public function showDesignCommentContent(Request $request, $id, $commentId) {
        $this->setModel(new DesignComment);
        return view('admin::design.comment-content', ['comment' => parent::getEntityByFields([
            ['column' => 'design_id', 'condition' => '=', 'value' => $id],
            ['column' => 'id', 'condition' => '=', 'value' => $commentId]
        ])]);
    }
    
    private function searchDesigns($keyword, $offset) {
        $model = parent::getModel();
        return $model::select('designs.*')
                ->join('users', 'designs.user_id', '=', 'users.id')
                ->where(function ($query) use ($keyword) {
                    $query->where('designs.id', $keyword)
                            ->orWhere('designs.friendly_id', $keyword)
                            ->orWhere('designs.title', 'like', '%' . $keyword . '%')
                            ->orWhere('users.username', 'like', '%' . $keyword . '%');
                })
                ->where('designs.disabled', 0)
                ->orderBy('designs.created_at', 'DESC')
                ->take($this->getLimit())
                ->skip($offset)
                ->get();
    }

}
