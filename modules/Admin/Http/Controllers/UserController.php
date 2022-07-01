<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use App;
use Route;

class UserController extends Controller {
    
    private $userRole;
    
    public function setUserRole($userRole) {
        $this->userRole = $userRole;
    }
    
    public function getUserRole() {
        return $this->userRole;
    }
    
    public function __construct() {
        parent::__construct();
        $this->setModel(new User);
    }

    public function showUsers(Request $request) {
        $routeName = Route::currentRouteName();
        $offset = ($request->has('offset')) ? $request->input('offset') : 0;
        $searchKeyword = ($request->has('search_keyword')) ? $request->get('search_keyword') : null;
        $viewPath = 'admin::user.' . $this->getViewName($routeName);
        $ajaxViewPath = 'admin::user.' . $this->getViewName($routeName) . '-row';
        $users = $searchKeyword ? $this->searchUsers($searchKeyword, $offset) : parent::getEntities($offset, [['column' => 'role_id', 'condition' => '=', 'value' => $this->getUserRole()]], ['column' => 'created_at', 'type' => 'DESC']);
        if ($request->ajax()) {
            return view($ajaxViewPath, ['users' => $users]);
        }
        return view($viewPath, [
            'ajaxViewPath' => $ajaxViewPath,
            'searchKeyword' => $searchKeyword,
            'users' => $users,
            'limit' => $this->getLimit(),
            'offset' => $offset,
            'count' => parent::getEntitiesCount([['column' => 'role_id', 'condition' => '=', 'value' => $this->getUserRole()]])
        ]);
    }
    
    public function newUser(Request $request) {
        return view('admin::user.new-user', ['roles' => UserRole::getAdminRoles()]);
    }
    
    public function storeUser(Request $request) {
        $entity = App::make('Modules\Admin\Http\Controllers\Auth\AuthController')->postRegister($request);
        return redirect()->route('admin::view.admins', ['id' => $entity->id])
                ->with('status', $entity->role->title . ' user added!');
    }
    
    public function showUser(Request $request, $id) {
        $user = parent::getEntity($id);
        return view('admin::user.view', ['user' => $user, 'orders' => $user->getAllOrders()]);
    }
    
    public function downloadUsers(Request $request) {
        $routeName = Route::currentRouteName();
        $redirect = redirect()->route('admin::view.' . $this->getViewName($routeName));
        return parent::downloadCSV($request->all(), $redirect, [
            ['column' => 'role_id', 'condition' => '=', 'value' => $this->getUserRole()]
        ]);
    }
    
    protected function getViewName($routeName) {
        return str_replace('admin::download.', '', str_replace('admin::view.', '', $routeName));
    }
    
    protected function searchUsers($keyword, $offset) {
        $model = parent::getModel();
        return $model::where(function ($query) use ($keyword) {
                    $query->where('friendly_id', $keyword)
                            ->orWhere('email', $keyword)
                            ->orWhere('first_name', 'like', '%' . $keyword . '%')
                            ->orWhere('last_name', 'like', '%' . $keyword . '%')
                            ->orWhere('username', 'like', '%' . $keyword . '%');
                })
                ->where('role_id', $this->getUserRole())
                ->orderBy('created_at', 'DESC')
                ->take($this->getLimit())
                ->skip($offset)
                ->get();
    }

}
