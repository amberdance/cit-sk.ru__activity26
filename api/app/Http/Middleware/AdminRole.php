<?php

namespace App\Http\Middleware;

use App\Http\Response;
use Closure;
use Illuminate\Http\Request;

class AdminRole
{

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!auth()->user()->is_admin) {
            return Response::jsonForbidden();
        }

        return $next($request);
    }
}
