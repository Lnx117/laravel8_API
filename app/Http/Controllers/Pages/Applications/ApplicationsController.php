<?php

namespace App\Http\Controllers\Pages\Applications;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Applications;
use App\Http\Controllers\Controller;
use App\Services\ApplicationsService;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;

class ApplicationsController extends Controller
{
    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    public function getApplicationsFreeList(ApplicationsService $applicationsService)
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'app_status' => 'Принято'
        ];

        //Получаем список задач
        $serviceResponse = $applicationsService->getByFields($request);
        $serviceResponse = $serviceResponse['data'];

        return view('ApplicationsPages/app-page')->with('applications', $serviceResponse);
    }

    public function getApplicationsWaitList(ApplicationsService $applicationsService)
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'app_status' => 'Назначена'
        ];

        //Получаем список задач
        $serviceResponse = $applicationsService->getByFields($request);
        $serviceResponse = $serviceResponse['data'];

        return view('ApplicationsPages/app-page')->with('applications', $serviceResponse);
    }

    public function getApplicationsInProgressList(ApplicationsService $applicationsService)
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'app_status' => 'В работе'
        ];

        //Получаем список задач
        $serviceResponse = $applicationsService->getByFields($request);
        $serviceResponse = $serviceResponse['data'];

        return view('ApplicationsPages/app-page')->with('applications', $serviceResponse);
    }

    public function getApplicationsDoneList(ApplicationsService $applicationsService)
    {
        //Так как используем метод апишки, то моделруем запрос и вкладываем в него поля по которым отсеиваем
        //В нашем случае ищем те заявки которые в статусе Принято
        $request = [
            'app_status' => 'Выполнена'
        ];

        //Получаем список задач
        $serviceResponse = $applicationsService->getByFields($request);
        $serviceResponse = $serviceResponse['data'];

        return view('ApplicationsPages/app-page')->with('applications', $serviceResponse);
    }

    // public function updateApplicationById(Request $request, ApplicationsService $applicationsService, $id)
    // {
    //     $serviceResponse = $applicationsService->updateApplicationById($request, $id);

    //     return $serviceResponse;
    // }

    // public function getApplicationById(ApplicationsService $applicationsService, $id)
    // {
    //     $serviceResponse = $applicationsService->getApplicationById($id);

    //     return $serviceResponse;
    // }

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
