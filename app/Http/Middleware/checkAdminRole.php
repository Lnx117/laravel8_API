<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class CheckAdminRole
{
    public function handle($request, Closure $next)
    {
        $statuses = config('ApiStatus');

        $user = $request->user();
        if ($user->user_role != 'admin') {
            $response = new Response();
            $response->setContent('You are not admin!!!');
            $response->setStatusCode(403);

            return $response;
        }

        return $next($request);
    }
}