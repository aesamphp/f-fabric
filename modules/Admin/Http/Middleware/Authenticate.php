<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use App\Models\UserGroup;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
                return redirect()->route('admin::view.login');
            }
        }
        
        if (!$request->user()->hasGroup(UserGroup::GROUP_ADMIN)) {
            if ($request->ajax()) {
                return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
            } else {
	            throw new UnauthorizedHttpException('Unauthorized.');
            }
        }

        return $next($request);
    }
}
