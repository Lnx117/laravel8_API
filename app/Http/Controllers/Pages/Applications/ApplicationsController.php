<?php

namespace App\Http\Controllers\Pages\Applications;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Applications;
use App\Http\Controllers\Controller;
use App\Interfaces\ApplicationsServiceInterface;
use App\Interfaces\UsersServiceInterface;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;

class ApplicationsController extends Controller
{
    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    protected $appService;
    protected $usersService;

    //На вход требуем объект, который реализует интерфейс ApplicationsServiceInterface
    //Он автоматически вернется благодаря сервис провайдеру
    public function __construct(ApplicationsServiceInterface $appService, UsersServiceInterface $usersService)
    {
        $this->appService = $appService;
        $this->usersService = $usersService;
    }

    public function getApplicationsFreeList()
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'app_status' => 'Принято'
        ];

        //Токен юзера
        $user = auth()->user();
        $token = $user->createToken('token-name')->plainTextToken;

        //Получаем список задач
        $applications = $this->appService->getByFields($request);
        $applications = $applications['data'];

        //Получаем список пользователей
        $masters = [];
        $free = ['user_status' => 'Свободен'];
        $working = ['user_status' => 'В работе'];
        $vacation = ['user_status' => 'В отпуске/выходной'];
        $masters['free'] = $this->usersService->getUsersByField($free)['data'];
        $masters['working'] = $this->usersService->getUsersByField($working)['data'];
        $masters['vacation'] = $this->usersService->getUsersByField($vacation)['data'];

        $data['applications'] = $applications;
        $data['masters'] = $masters;
        $data['token'] = $token;
        
        return view('ApplicationsPages/app-page')->with('data', $data);
    }

    public function getApplicationsWaitList()
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'app_status' => 'Назначена'
        ];

        //Токен юзера
        $user = auth()->user();
        $token = $user->createToken('token-name')->plainTextToken;

        //Получаем список задач
        $applications = $this->appService->getByFields($request);
        $applications = $applications['data'];

        //Получаем список пользователей
        $masters = [];
        $free = ['user_status' => 'Свободен'];
        $working = ['user_status' => 'В работе'];
        $vacation = ['user_status' => 'В отпуске/выходной'];
        $masters['free'] = $this->usersService->getUsersByField($free)['data'];
        $masters['working'] = $this->usersService->getUsersByField($working)['data'];
        $masters['vacation'] = $this->usersService->getUsersByField($vacation)['data'];

        $data['applications'] = $applications;
        $data['masters'] = $masters;
        $data['token'] = $token;
        
        return view('ApplicationsPages/app-inProgress')->with('data', $data);
    }

    public function getApplicationsInProgressList()
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'app_status' => 'В работе'
        ];

        //Токен юзера
        $user = auth()->user();
        $token = $user->createToken('token-name')->plainTextToken;

        //Получаем список задач
        $applications = $this->appService->getByFields($request);
        $applications = $applications['data'];

        //Получаем список пользователей
        $masters = [];
        $free = ['user_status' => 'Свободен'];
        $working = ['user_status' => 'В работе'];
        $vacation = ['user_status' => 'В отпуске/выходной'];
        $masters['free'] = $this->usersService->getUsersByField($free)['data'];
        $masters['working'] = $this->usersService->getUsersByField($working)['data'];
        $masters['vacation'] = $this->usersService->getUsersByField($vacation)['data'];

        $data['applications'] = $applications;
        $data['masters'] = $masters;
        $data['token'] = $token;
        
        return view('ApplicationsPages/app-inProgress')->with('data', $data);
    }

    public function getApplicationsDoneList()
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'app_status' => 'Выполнена'
        ];

        //Токен юзера
        $user = auth()->user();
        $token = $user->createToken('token-name')->plainTextToken;

        //Получаем список задач
        $applications = $this->appService->getByFields($request);
        $applications = $applications['data'];

        //Получаем список пользователей
        $masters = [];
        $free = ['user_status' => 'Свободен'];
        $working = ['user_status' => 'В работе'];
        $vacation = ['user_status' => 'В отпуске/выходной'];
        $masters['free'] = $this->usersService->getUsersByField($free)['data'];
        $masters['working'] = $this->usersService->getUsersByField($working)['data'];
        $masters['vacation'] = $this->usersService->getUsersByField($vacation)['data'];

        $data['applications'] = $applications;
        $data['masters'] = $masters;
        $data['token'] = $token;
        
        return view('ApplicationsPages/app-inProgress')->with('data', $data);
    }

    public function getApplicationsDeletedList()
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'app_status' => 'Удалена'
        ];

        //Токен юзера
        $user = auth()->user();
        $token = $user->createToken('token-name')->plainTextToken;

        //Получаем список задач
        $applications = $this->appService->getByFields($request);
        $applications = $applications['data'];

        //Получаем список пользователей
        $masters = [];
        $free = ['user_status' => 'Свободен'];
        $working = ['user_status' => 'В работе'];
        $vacation = ['user_status' => 'В отпуске/выходной'];
        $masters['free'] = $this->usersService->getUsersByField($free)['data'];
        $masters['working'] = $this->usersService->getUsersByField($working)['data'];
        $masters['vacation'] = $this->usersService->getUsersByField($vacation)['data'];

        $data['applications'] = $applications;
        $data['masters'] = $masters;
        $data['token'] = $token;
        
        return view('ApplicationsPages/app-done')->with('data', $data);
    }

    public function getApplicationsCreateList()
    {
        //Токен юзера
        $user = auth()->user();
        $token = $user->createToken('token-name')->plainTextToken;
        $data['token'] = $token;

        return view('ApplicationsPages/app-create')->with('data', $data);;
    }

    // public function deleteApplicationById(ApplicationsService $applicationsService, $id)
    // {
    //     $serviceResponse = $applicationsService->deleteApplicationById($id);

    //     return $serviceResponse;
    // }

    // public function createApplication(ApplicationsService $applicationsService, Request $request)
    // {
    //     $serviceResponse = $applicationsService->createApplication($request);

    //     return $serviceResponse;
    // }
}
