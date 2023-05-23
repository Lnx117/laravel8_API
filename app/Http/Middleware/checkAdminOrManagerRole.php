<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class checkAdminOrManagerRole
{
    public function handle($request, Closure $next)
    {
        $statuses = config('ApiStatus');

        $user = $request->user();
        if ($user->user_role != 'admin' && $user->user_role != 'manager') {
            $response = new Response();
            $response->setContent('You are not admin or manager!!!');
            $response->setStatusCode(403);

            return $response;
        }

        return $next($request);
    }
}