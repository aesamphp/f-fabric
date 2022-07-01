<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{

    /**
     * BlockController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Block);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showBlocks(Request $request)
    {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $blocks = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::block.block-row', ['blocks' => $blocks]);
        }
        return view('admin::block.blocks', [
            'blocks' => $blocks,
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
    public function showBlock(Request $request, $id)
    {
        return view('admin::block.block', [
            'ctaTypes' => Block::getCTATypeOptions(),
            'block' => parent::getEntity($id),
            'displayTypes' => Block::getDisplayTypeOptions()
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateBlock(Request $request, $id)
    {
        $redirect = redirect()->route('admin::view.block', ['id' => $id]);

        if ($request->hasFile('file')) {
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                    ->withInput();
            }
            $filePath = parent::uploadFile($request->file('file'), Block::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }

        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->with('status', 'Block updated!');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newBlock()
    {
        return view('admin::block.new-block', [
            'ctaTypes' => Block::getCTATypeOptions(),
            'displayTypes' => Block::getDisplayTypeOptions()
        ]);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function storeBlock(Request $request)
    {
        $redirect = redirect()->route('admin::view.blocks', [
            'blocks' =>  parent::getEntities(0),
            'limit' => $this->getLimit(),
            'offset' => 0,
            'count' => parent::getEntitiesCount()
        ]);

        if ($request->hasFile('file')) {
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                    ->withInput();
            }
            $filePath = parent::uploadFile($request->file('file'), Block::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }

        $entity = parent::storeEntity($request->all(), $redirect);

        if (!isset($entity->id)) {
            return $entity;
        }

        return redirect()->route('admin::view.block', ['id' => $entity->id]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteBlock(Request $request, $id)
    {
        parent::deleteEntity($id);
        return redirect()->route('admin::view.blocks')
            ->with('status', 'Block deleted!');
    }

}
