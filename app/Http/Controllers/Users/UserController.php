<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];
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
        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        //Получаем список рользователей
        $this->response['data'] = User::all();
        $this->response['message'] = 'All users list';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
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
        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($user)) {
            $user = User::find($user);
        } else {
            // в противном случае ищем пользователя по email
            $user = User::where('email', $user)->firstOrFail();
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
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
        $this->response['data'] = $user;
        $this->response['message'] = 'User updated successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
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
    public function getUserByIdOrEmail($idOrEmail)
    {

        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($idOrEmail)) {
            $user = User::find($idOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = User::where('email', $idOrEmail)->firstOrFail();
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $user;
        $this->response['message'] = 'User founded successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
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
    public function deleteUserByIdOrEmail($idOrEmail)
    {
        //Получаем статусы ответа
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($idOrEmail)) {
            $user = User::find($idOrEmail);
        } else {
            // в противном случае ищем пользователя по email
            $user = User::where('email', $idOrEmail)->firstOrFail();
        }

        if (!$user) {
            $this->response['message'] = 'User not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $user = $user->delete();

        if ($user != true) {
            $this->response['message'] = 'User not deleted';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $user;
        $this->response['message'] = 'User deleted successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }
}
