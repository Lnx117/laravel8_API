<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\AuthServiceInterface;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    /**
     * @OA\Post(
     *     path="/api/sanctum/register",
     *     summary="Регистрация нового пользователя",
     *     description="Регистрация нового пользователя с использованием имени, адреса электронной почты и пароля",
     *     tags={"Регистрация и авторизация"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", description="JWT токен")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object", description="Сообщения об ошибках валидации")
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    { 
        $serviceResponse = $this->authService->register($request);

        return $serviceResponse;
    }

    /**
     * @OA\Post(
     *     path="/api/sanctum/registerManager",
     *     summary="Регистрация менеджера",
     *     description="Регистрация нового менеджера с использованием имени, адреса электронной почты и пароля",
     *     tags={"Регистрация и авторизация"},
     *     security={{"apiAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", description="JWT токен")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object", description="Сообщения об ошибках валидации")
     *         )
     *     )
     * )
     */
    public function registerManager(Request $request)
    { 
        $serviceResponse = $this->authService->registerManager($request);

        return $serviceResponse;
    }
    
    /**
     * @OA\Post(
     *     path="/api/sanctum/token",
     *     summary="Авторизация и получение токена",
     *     description="Авторизует пользователя по email и паролю и возвращает токен доступа.",
     *     tags={"Регистрация и авторизация"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Данные для авторизации",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="ivan@yandex.ru"),
     *             @OA\Property(property="password", type="string", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Успешная авторизация. Возвращает токен доступа",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|hashvalue")
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Ошибка авторизации. Возвращает ошибку валидации или сообщение об ошибке в случае неверных учетных данных.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="object", example={"email": {"The email field is required."}})
     *         )
     *     )
     * )
     */
    public function token(Request $request)
    {
        $serviceResponse = $this->authService->token($request);

        return $serviceResponse;
    }
}
