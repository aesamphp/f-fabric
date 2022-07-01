<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use App\Models\UserGroup;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Request;

class Authenticate {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
            } else {
                session()->put('auth.redirect', Request::url());
                return redirect()->route('view.login');
            }
        }
        
        if (!$request->user()->hasGroup(UserGroup::GROUP_CUSTOMER)) {
            if ($request->ajax()) {
                return response('Forbidden.', Response::HTTP_FORBIDDEN);
            } else {
                throw new AccessDeniedHttpException('Forbidden.');
            }
        }

        return $next($request);
    }

}
