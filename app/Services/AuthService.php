<?php
namespace App\Services;

use App\Models\Applications;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\AuthServiceInterface;
use App\Interfaces\UserRepositoryInterface;

class AuthService implements AuthServiceInterface
{
    protected $userRepository;
    private $apiStatuses;
    private $masterStatuses;
    private $roles;

    //Dependency injection
    //На вход требуем объект, который реализует интерфейс ApplicationsServiceInterface
    //Он автоматически вернется благодаря сервис провайдеру
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->apiStatuses = config('ApiStatus');
        $this->masterStatuses = config('MasterStatuses');
        $this->roles = config('Roles');
    }

    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    public function register($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'user_firstname' => ['required', 'string', 'min:3'],
            'user_lastname' => ['required', 'string', 'min:3'],
            'user_patronymic' => ['required', 'string', 'min:3'],
        ]); 

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_role'] = $this->roles['master'];
        $input['user_status'] = $this->masterStatuses['free'];
        $user = $this->userRepository->createUser($input);

        $token = $user->createToken('token-name')->plainTextToken;

        
        $this->response['data'] = $token;
        $this->response['message'] = 'New user token';
        $this->response['status'] = $this->apiStatuses['ok'];

        return $this->response;
    }

    public function registerManager($request)
    { 
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]); 

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_role'] = $this->roles['manager'];
        $input['user_status'] = 'Активен';
        $user = $this->userRepository->createUser($input);

        $token = $user->createToken('token-name')->plainTextToken;

        $this->response['data'] = $token;
        $this->response['message'] = 'New manager token';
        $this->response['status'] = $this->apiStatuses['ok'];

        return $this->response;
    }

    public function token($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);    
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

    
        $user = $this->userRepository->getByEmail($request->email);

    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }

        return response()->json(['token' => $user->createToken('token-name')->plainTextToken]);

    }
}