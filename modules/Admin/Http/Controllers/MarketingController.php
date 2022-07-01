<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\UserRole;

class MarketingController extends UserController
{

	/**
	 * MarketingController constructor.
	 */
	public function __construct()
	{
		$this->allowUser([UserRole::TYPE_ADMIN]);

		parent::__construct();
		$this->setUserRole(UserRole::TYPE_MARKETING);
	}

}
