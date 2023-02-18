<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/sanctum/getUsersList",
 *     summary="Получение списка пользователей",
 *     description="Возвращает список всех зарегистрированных пользователей.",
 *     tags={"Пользователи"},
 *     security={{"apiAuth":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Список пользователей",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/RegisterRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response="401",
 *         description="Не авторизован. Токен доступа отсутствует или недействителен.",
 *     ),
 * )
 */
    public function getUsersList()
    {
        return User::all();
    }
}
