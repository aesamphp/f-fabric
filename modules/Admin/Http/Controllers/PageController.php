<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Page);
    }

    public function showPages(Request $request)
    {
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $pages = parent::getEntities($offset);
        if ($request->ajax()) {
            return view('admin::page.page-row', ['pages' => $pages]);
        }
        return view('admin::page.pages', [
            'pages' => $pages,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount()
        ]);
    }

    public function showPage(Request $request, $id)
    {
        return view('admin::page.page', [
            'page' => parent::getEntity($id),
            'statusTypes' => Page::getStatusOptions()
        ]);
    }

    public function updatePage(Request $request, $id)
    {
        $redirect = redirect()->route('admin::show.page', ['id' => $id]);

        if ($request->hasFile('file')) {
            $validator = parent::validateImage($request->all());
            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                    ->withInput();
            }
            $filePath = parent::uploadFile($request->file('file'), Page::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }

        parent::updateEntity($request->all(), $id, $redirect);
        return $redirect->withStatus('Page updated');
    }

    public function newPage()
    {
        return view('admin::page.new-page', [
            'statusTypes' => Page::getStatusOptions()
        ]);
    }

    function storePage(Request $request)
    {
        $redirect = redirect()->route('admin::show.new.page');

        if ($request->hasFile('file')) {
            $validator = parent::validateImage($request->all());

            if ($validator->fails()) {
                return $redirect->withErrors($validator)
                    ->withInput();
            }

            $filePath = parent::uploadFile($request->file('file'), Page::IMAGE_DESTINATION_PATH);
            $request->merge(['image_path' => $filePath]);
        }

        $entity = parent::storeEntity($request->all(), $redirect);

        if (!isset($entity->id)) {
            return $entity;
        }

        return redirect()->route('admin::show.page', ['id' => $entity->id])->withStatus('Page has been created');
    }

    public function deletePage(Request $request, $id)
    {
        parent::deleteEntity($id);
        return redirect()->route('admin::show.pages')
            ->withStatus('Page deleted');
    }

}