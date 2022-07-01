<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AboutController
 * @package Modules\Admin\Http\Controllers
 */
class AboutController extends Controller
{

	/**
	 * AboutController constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setModel(new About);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function about(Request $request)
	{
        return view('admin::about.about', ['aboutUs' => parent::getEntity(1)]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function storeAbout(Request $request)
	{
		$redirect = redirect()->route('admin::view.about');

		foreach (["section_2_button_display", "section_3_button_display"] as $checkbox) {
			$request->merge([$checkbox => $request->has($checkbox) ? true : false]);
		}

		foreach (["header_image", "section_2_image", "section_3_image"] as $image) {
			if($request->has($image.'_tmp')){
				$imageFile = parent::uploadFile($request->file($image . '_tmp'), About::IMAGE_DESTINATION_PATH);
				$request->merge([$image => $imageFile]);
			}
		}

		parent::updateEntity($request->all(), 1, $redirect);
		return $redirect->with('status', 'About Us has been updated!');
	}

}
