<?php

namespace Modules\Admin\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserGroup;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */
    
    use AuthenticatesAndRegistersUsers,
            ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->loginPath = route('admin::view.login');
        $this->redirectPath = route('admin::dashboard');
        $this->redirectAfterLogout = $this->loginPath;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Array $data) {
        $user = new User;
        $user->setScenario('insert-admin');
        return Validator::make($this->getUserData($data), $user->rules(), $user->messages());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(Array $data) {
        return User::create($this->getUserData($data));
    }

    /**
     * Show login form.
     *
     * @return view
     */
    public function getLogin() {
        return view('admin::auth.login');
    }
    
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request) {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        return $this->create($request->all());
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return array
     */
    protected function getCredentials(Request $request) {
        $request->merge(['group_id' => UserGroup::GROUP_ADMIN]);
        return $request->only($this->loginUsername(), 'password', 'group_id');
    }

    /**
     * Returns the user request data with additional data added to it.
     * 
     * @param array $data
     * @param boolean $passwordEncryption
     * 
     * @return array
     */
    private function getUserData(Array $data) {
        $data['group_id'] = UserGroup::GROUP_ADMIN;
        return $data;
    }

}
