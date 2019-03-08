<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2/28/2019
 * Time: 10:55 PM
 */

namespace App\Http\Middleware;
use Closure;

class CheckRole
{
    public function handle($request, Closure $next)
    {

        if ($request->user() === null) {
            return response("Un Authorization User", 401);
        }

        $actions = $request->route()->getAction();
        $roles = isset($actions['roles']) ? $actions['roles'] : null;

        if ($request->user()->hasRole($request->user()->email,$roles)) {
            return $next($request);
        }
        return response("Insufficient permissions", 401);

    }
}