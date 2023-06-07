<?php 
namespace App\Http\Controllers\Pages\Auth;

use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewLoginController extends \Illuminate\Routing\Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        if ($user instanceof User) {
            $user->markFirstLogin();
        }
    }
}