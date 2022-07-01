<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\UserRole;

class ManagerController extends UserController {

    public function __construct() {
        parent::__construct();
        $this->setUserRole(UserRole::TYPE_MANAGER);
    }

}
