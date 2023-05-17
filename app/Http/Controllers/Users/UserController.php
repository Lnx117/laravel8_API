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

/**
 * @OA\Put(
 *      path="/api/sanctum/updateUserByIdOrEmail/{user}",
 *      description="Меняет данные пользователя по его Id или Email",
 *      tags={"Пользователи"},
 *      summary="Update user by ID or email",
 *      security={{"apiAuth":{}}},
 *      @OA\Parameter(
 *          name="user",
 *          description="User ID or email",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  type="object",
 *                  @OA\Property(
 *                      property="name",
 *                      type="string",
 *                      example="John Doe",
 *                      description="User name"
 *                  ),
 *                  @OA\Property(
 *                      property="email",
 *                      type="string",
 *                      example="john.doe@example.com",
 *                      description="User email"
 *                  ),
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="User updated successfully"
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="User not found"
 *      )
 * )
 */
    public function updateUserByIdOrEmail(Request $request, $user)
    {
        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($user)) {
            $user = User::find($user);
        } else {
            // в противном случае ищем пользователя по email
            $user = User::where('email', $user)->firstOrFail();
        }

        // заполняем модель только теми полями, которые пришли в запросе
        // пока обновляем либо имя, либо пароль
        $user->fill($request->only([
            'name',
            'email',
        ]));

        // сохраняем изменения в базу данных
        $user->save();

        $user = User::find($user);

        return response()->json(['message' => 'User updated successfully']);
    }

/**
 * @OA\get(
 *      path="/api/sanctum/getUserByIdOrEmail/{user}",
 *      description="Получает конкретного пользователя по ID или email",
 *      tags={"Пользователи"},
 *      summary="Get user by ID or email",
 *      security={{"apiAuth":{}}},
 *      @OA\Parameter(
 *          name="user",
 *          description="User ID or email",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="User founded successfully"
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="User not found"
 *      )
 * )
 */
    public function getUserByIdOrEmail(Request $request, $idOrEmail)
    {
        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($idOrEmail)) {
            $user = User::find($idOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = User::where('email', $idOrEmail)->firstOrFail();
        }

        if (empty($user)) return response()->json(['message' => 'User not found']);
        return response()->json($user);
    }

    /**
     * @OA\delete(
     *      path="/api/sanctum/deleteUserByIdOrEmail/{user}",
     *      description="Удаляет конкретного пользователя по ID или email",
     *      tags={"Пользователи"},
     *      summary="Delete user by ID or email",
     *      security={{"apiAuth":{}}},
     *      @OA\Parameter(
     *          name="user",
     *          description="User ID or email",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User deleted successfully"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      )
     * )
     */
    public function deleteUserByIdOrEmail(Request $request, $idOrEmail)
    {
        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($idOrEmail)) {
            $user = User::find($idOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = User::where('email', $idOrEmail)->firstOrFail();
        }
        if (empty($user)) return response()->json(['message' => 'User not found']);
        $user = $user->delete();
        if ($user != true) return response()->json(['message' => 'User not deleted']);
        return response()->json($user);
    }
}
