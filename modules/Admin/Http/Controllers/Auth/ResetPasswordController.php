<?php

namespace Modules\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminResetPasswordRequest;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    
    public function index(Request $request, $token)
    {
        return view('admin::auth.reset-password.index', [
            'token' => $token,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect()
                    ->route('admin::dashboard')
                    ->with('status', trans($response));

            default:
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmail()
    {
        return view('admin::auth.reset-password.email');
    }

    public function postEmail(AdminResetPasswordRequest $request)
    {
        view()->composer('emails.password', function ($view) {
            $view->with([
                'adminResetPassword' => true,
            ]);
        });

        $response = Password::sendResetLink(
            $request->only('email'),
            function (Message $message) {
                $message->subject($this->getEmailSubject());
            }
        );

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));
            case Password::INVALID_USER:
                return redirect()->back()->withErrors([
                    'email' => trans($response),
                ]);
        }
    }
}