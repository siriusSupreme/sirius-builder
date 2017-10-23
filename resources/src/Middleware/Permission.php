<?php

namespace Sirius\Builder\Middleware;

use Sirius\Builder\Facades\Admin;
use Sirius\Http\Request;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param \Sirius\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (!Admin::user()) {
            return $next($request);
        }

        if (!Admin::user()->allPermissions()->first(function ($permission) use ($request) {
            return $permission->shouldPassThrough($request);
        })) {
            \Sirius\Builder\Auth\Permission::error();
        }

        return $next($request);
    }
}
