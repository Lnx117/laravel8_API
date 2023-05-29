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

    public function getApplicationsList(ApplicationsService $applicationsService)
    {

        //Получаем список задач
        $serviceResponse = $applicationsService->getApplicationsList();
        $serviceResponse = $serviceResponse['data'];

        return view('my-page')->with('applications', $serviceResponse);
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
