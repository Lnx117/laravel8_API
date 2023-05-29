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

    //Dependency injection
    //На вход требуем объект, который реализует интерфейс ApplicationsServiceInterface
    //Он автоматически вернется благодаря сервис провайдеру
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    public function register($request)
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
        $user = $this->userRepository->createUser($input);

        //$token = $user->createToken($request->device_name)->plainTextToken;
        $token = $user->createToken('token-name')->plainTextToken;

        
        $this->response['data'] = $token;
        $this->response['message'] = 'New user token';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function registerManager($request)
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
        $user = $this->userRepository->createUser($input);

        //$token = $user->createToken($request->device_name)->plainTextToken;
        $token = $user->createToken('token-name')->plainTextToken;

        $this->response['data'] = $token;
        $this->response['message'] = 'New manager token';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function token($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            //'device_name' => ['required', 'string']
        ]);    
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

    
        $user = $this->userRepository->getByEmail($request->email);

    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }

        //response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
        return response()->json(['token' => $user->createToken('token-name')->plainTextToken]);

    }
}