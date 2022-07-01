<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserRole;
use App\Models\Studio;
use App\Models\Community;
use Auth;
use Validator;

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
    
    protected $redirectURL = null;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->redirectURL = session()->get('auth.redirect');
        $this->redirectPath = ($this->redirectURL === null) ? route('home') : $this->redirectURL;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Array $data) {
        $user = new User;
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
     * Shows the register page.
     * 
     * @return redirect
     */
    public function getRegister() {
        return redirect()->route('view.login');
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

        $user = $this->create($request->all());
        Auth::login($user);
        Community::where('email', $user->email)->delete();
        Studio::create($request->all());
        $this->sendRegisterEmail($user);
        
        $redirectURL = ($this->redirectURL === null) ? route('view.confirm.register') : $this->redirectURL;
        return redirect($redirectURL);
    }
    
    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return array
     */
    protected function getCredentials(Request $request) {
        $request->merge(['group_id' => UserGroup::GROUP_CUSTOMER, 'disabled' => 0]);
        return $request->only($this->loginUsername(), 'password', 'group_id', 'disabled');
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
        $data['group_id'] = UserGroup::GROUP_CUSTOMER;
        $data['role_id'] = UserRole::TYPE_CONTRIBUTOR;
        return $data;
    }
    
    /**
     * Handle a facebook authentication request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postFacebookLogin(Request $request) {
        if (!$request->has('facebook_id')) {
            return response('The facebook id field is required.', Response::HTTP_BAD_REQUEST);
        }
        $user = User::where('facebook_id', $request->input('facebook_id'))->first();
        if ($user === null) {
            $validator = $this->facebookLoginValidator($request);
            if ($validator->fails()) {
                return response($validator->errors()->getMessages(), Response::HTTP_BAD_REQUEST);
            }
            $request->merge(['username' => strtolower($request->input('first_name')) . $request->input('facebook_id'), 'password' => str_random(20)]);
            $user = $this->create($request->all());
            Auth::login($user);
            Community::where('email', $user->email)->delete();
            Studio::create();
            $this->sendRegisterEmail($user);
        } else {
            Auth::login($user);
        }
        return response()->json(['redirectURL' => $this->redirectPath]);
    }
    
    /**
     * Validate the facebook authentication.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Validator
     */
    private function facebookLoginValidator($request) {
        return Validator::make(
            $request->all(),
            [
                'facebook_id' => 'required|numeric',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users'
            ]
        );
    }
    
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles) {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }
        
        session()->forget('auth.redirect');

        return redirect()->intended($this->redirectPath());
    }
    
    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout() {
        Auth::logout();
        
        session()->flush();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
    
    /**
     * Sends user a welcome email on register.
     * 
     * @param array $user
     */
    private function sendRegisterEmail($user) {
        parent::sendEmail('emails.register', ['user' => $user], [
            'from_email' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
            'to_email' => $user->email,
            'to_name' => $user->getFullName(),
            'subject' => 'Welcome To Fashion Formula'
        ]);
    }

}
