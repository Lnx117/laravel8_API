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

    private $apiStatuses;
    private $masterStatuses;
    private $roles;

    public function __construct()
    {
        $this->apiStatuses = config('ApiStatus');
        $this->masterStatuses = config('MasterStatuses');
        $this->roles = config('Roles');
    }


    public function getFreeUsersList(UsersServiceInterface $usersService)
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'user_status' => $this->masterStatuses['free'],
            'user_role' => $this->roles['master']
        ];

        //Токен юзера
        $user = auth()->user();
        $token = session('user_token');

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
            'user_status' => $this->masterStatuses['working'],
            'user_role' => $this->roles['master']
        ];

        //Токен юзера
        $user = auth()->user();
        $token = session('user_token');

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
            'user_status' => $this->masterStatuses['vacation'],
            'user_role' => $this->roles['master']
        ];

        //Токен юзера
        $user = auth()->user();
        $token = session('user_token');

        //Получаем список задач
        $serviceResponse = $usersService->getUsersByField($request);
        $serviceResponse = $serviceResponse['data'];

        $data['token'] = $token;
        $data['users'] = $serviceResponse;

        return view('UsersPages/users-page')->with('data', $data);
    }

    public function createMaster()
    {
        return view('UsersPages/users-create');
    }

    public function createManager()
    {
        //Токен юзера
        $user = auth()->user();
        $token = session('user_token');

        $data['token'] = $token;

        return view('UsersPages/managers-create')->with('data', $data);;
    }

    public function managers(UsersServiceInterface $usersService)
    {
        $request = [
            'user_role' => 'manager',
            'user_status' => 'Активен',
        ];

        //Токен юзера
        $user = auth()->user();
        $token = session('user_token');

        $serviceResponse = $usersService->getUsersByField($request);
        $serviceResponse = $serviceResponse['data'];

        $data['token'] = $token;
        $data['managers'] = $serviceResponse;

        return view('UsersPages/managers')->with('data', $data);
    }

    public function deletedManagers(UsersServiceInterface $usersService)
    {
        $request = [
            'user_role' => $this->roles['manager'],
            'user_status' => $this->masterStatuses['deleted'],
        ];

        //Токен юзера
        $user = auth()->user();
        $token = session('user_token');

        $serviceResponse = $usersService->getUsersByField($request);
        $serviceResponse = $serviceResponse['data'];

        $data['token'] = $token;
        $data['managers'] = $serviceResponse;

        return view('UsersPages/managersDeleted')->with('data', $data);
    }

    public function deletedMasters(UsersServiceInterface $usersService)
    {
        $request = [
            'user_role' => $this->roles['master'],
            'user_status' => $this->masterStatuses['deleted'],
        ];

        //Токен юзера
        $user = auth()->user();
        $token = session('user_token');

        $serviceResponse = $usersService->getUsersByField($request);
        $serviceResponse = $serviceResponse['data'];

        $data['token'] = $token;
        $data['isDeletePage'] = true;
        $data['users'] = $serviceResponse;

        return view('UsersPages/users-page')->with('data', $data);
    }
}
