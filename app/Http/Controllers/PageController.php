<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{

    /**
     * PageController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setModel(new Page);
    }

    /**
     * @param $index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showPage($index)
    {
        $page = Page::whereUrl($index)
            ->whereStatus(Page::ENABLED)
            ->firstOrFail();

        return view('page.index', compact('page'));
    }

}