<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetUserToken
{
    public function handle($request, Closure $next)
    {

        //  Если у пользователя уже есть токен, используем его
        //  Если нет - пишем в сессию
        if (!session('user_token')) {
            $user = Auth::user();
            $token = $user->currentAccessToken();
            $token = $user->createToken('token-name');
            session(['user_token' => $token->plainTextToken]);
        }

        return $next($request);
    }
}
