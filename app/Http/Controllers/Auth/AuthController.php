<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
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
        $statuses = config('ApiStatus');

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            //'device_name' => ['required', 'string']
        ]); 

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        //$token = $user->createToken($request->device_name)->plainTextToken;
        $token = $user->createToken('token-name')->plainTextToken;

        
        $this->response['data'] = $token;
        $this->response['message'] = 'New user token';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    /**
     * @OA\Post(
     *     path="/api/sanctum/registerManager",
     *     summary="Регистрация менеджера",
     *     description="Регистрация нового менеджера с использованием имени, адреса электронной почты и пароля",
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
    public function registerManager(Request $request)
    { 
        $statuses = config('ApiStatus');
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            //'device_name' => ['required', 'string']
        ]); 

        if ($validator->fails()) {
            $this->response['message'] = 'Register validation failed';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_role'] = 'manager';
        $user = User::create($input);

        //$token = $user->createToken($request->device_name)->plainTextToken;
        $token = $user->createToken('token-name')->plainTextToken;

        $this->response['data'] = $token;
        $this->response['message'] = 'New manager token';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
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
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            //'device_name' => ['required', 'string']
        ]);    
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

    
        $user = User::where('email', $request->email)->first();

    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }

        //response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
        return response()->json(['token' => $user->createToken('token-name')->plainTextToken]);

    }
}
