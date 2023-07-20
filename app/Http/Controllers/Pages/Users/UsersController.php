<?php

namespace App\Http\Controllers\Pages\Users;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Interfaces\UsersServiceInterface;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    public function getFreeUsersList(UsersServiceInterface $usersService)
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'user_status' => 'Свободен',
            'user_role' => 'master'
        ];

        //Токен юзера
        $user = auth()->user();
        $token = $user->createToken('token-name')->plainTextToken;

        //Получаем список задач
        $serviceResponse = $usersService->getUsersByField($request);
        $serviceResponse = $serviceResponse['data'];

        $data['token'] = $token;
        $data['users'] = $serviceResponse;

        return view('UsersPages/users-page')->with('data', $data);
    }

    public function getWorkingUsersList(UsersServiceInterface $usersService)
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'user_status' => 'В работе',
            'user_role' => 'master'
        ];

        //Токен юзера
        $user = auth()->user();
        $token = $user->createToken('token-name')->plainTextToken;

        //Получаем список задач
        $serviceResponse = $usersService->getUsersByField($request);
        $serviceResponse = $serviceResponse['data'];

        $data['token'] = $token;
        $data['users'] = $serviceResponse;

        return view('UsersPages/users-page')->with('data', $data);
    }

    public function getVacationUsersList(UsersServiceInterface $usersService)
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'user_status' => 'В отпуске/выходной',
            'user_role' => 'master'
        ];

        //Токен юзера
        $user = auth()->user();
        $token = $user->createToken('token-name')->plainTextToken;

        //Получаем список задач
        $serviceResponse = $usersService->getUsersByField($request);
        $serviceResponse = $serviceResponse['data'];

        $data['token'] = $token;
        $data['users'] = $serviceResponse;

        return view('UsersPages/users-page')->with('data', $data);
    }

    public function CreateMaster()
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'user_status' => 'В отпуске/выходной',
            'user_role' => 'master'
        ];

        //Токен юзера
        return view('UsersPages/users-create');
    }
}
