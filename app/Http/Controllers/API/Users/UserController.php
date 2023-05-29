<?php

namespace App\Http\Controllers\API\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Services\UsersService;
use App\Interfaces\UsersServiceInterface;

class UserController extends Controller
{
    protected $usersService;

    public function __construct(UsersServiceInterface $usersService)
    {
        $this->usersService = $usersService;
    }

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
        $serviceResponse = $this->usersService->getUsersList();

        return $serviceResponse;
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
        $serviceResponse = $this->usersService->updateUserByIdOrEmail($request, $user);

        return $serviceResponse;
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
        $serviceResponse = $this->usersService->getUserByIdOrEmail($idOrEmail);

        return $serviceResponse;
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
    public function deleteUserByIdOrEmail(UsersService $usersService, $idOrEmail)
    {
        $serviceResponse = $usersService->deleteUserByIdOrEmail($idOrEmail);

        return $serviceResponse;
    }
}
