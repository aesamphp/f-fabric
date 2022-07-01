<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Role {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles) {
        foreach ($roles as $role) {
            if ($request->user()->hasRole((int) $role)) {
                return $next($request);
            }
        }
        if ($request->ajax()) {
            return response('Forbidden action.', Response::HTTP_FORBIDDEN);
        }
        throw new AccessDeniedHttpException('Forbidden action.');
    }

}
