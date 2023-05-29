<?php
namespace App\Services;

use App\Models\Applications;
use Illuminate\Support\Facades\Config;
use App\Interfaces\ApplicationsRepositoryInterface;
use App\Interfaces\ApplicationsServiceInterface;

class ApplicationsService implements ApplicationsServiceInterface
{
    protected $appRepository;

    //Dependency injection
    //На вход требуем объект, который реализует интерфейс ApplicationsServiceInterface
    //Он автоматически вернется благодаря сервис провайдеру
    public function __construct(ApplicationsRepositoryInterface $appRepository)
    {
        $this->appRepository = $appRepository;
    }

    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    public function getApplicationsList()
    {
        $statuses = Config::get('ApiStatus');

        $this->response['data'] = $this->appRepository->getAllApplications();
        $this->response['message'] = 'All apps';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function updateApplicationById($request, $id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id) && !empty($id)) {
            $app = $this->appRepository->getById($id);

            if (!$app) {
                $this->response['message'] = 'App not found';
                $this->response['status'] = $statuses['warning'];
        
                return $this->response;
            }

            // заполняем модель только теми полями, которые пришли в запросе
            $app = $this->appRepository->fill($app, $request->only([
                'customer_first_name',
                'customer_last_name',
                'customer_patronymic',
                'customer_phone',
                'app_city',
                'app_street',
                'app_house_number',
                'app_house_building',
                'app_flat_num',
                'app_floor_num',
                'app_house_entrance',
                'app_created_at',
                'app_to_execute_at',
                'problem_text',
                'master_id',
                'app_status',
                'bitrix_customer_id',
            ]));

            // сохраняем изменения в базу данных
            $this->appRepository->save($app);
            //$task->save();
            $app = $this->appRepository->getById($id);

            $this->response['data'] = $app;
            $this->response['message'] = 'App updated successfully';
            $this->response['status'] = $statuses['ok'];
    
            return $this->response;
        } else {
            $this->response['message'] = 'Id is not numeric or empty';
            $this->response['status'] = $statuses['warning'];
        }
    }

    public function getApplicationById($id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id) && !empty($id)) {
            $app = $this->appRepository->getById($id);
        }

        if (empty($app)) {
            $this->response['message'] = 'App not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $app;
        $this->response['message'] = 'App founded successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function deleteApplicationById($id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id)) {
            $app = $this->appRepository->getById($id);
        }
        if (empty($app)) {
            $this->response['message'] = 'App not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $app = $this->appRepository->delete($app);
        if ($app != true) {
            $this->response['message'] = 'App not found';
            $this->response['status'] = $statuses['warning'];

            return $this->response;
        }
        
        $this->response['message'] = 'App deleted successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function createApplication($request)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (!empty($request)) {
            $app = new Applications;

            $app = $this->appRepository->fill($app, $request->only([
                'bitrix_customer_id',
                'customer_first_name',
                'customer_last_name',
                'customer_patronymic',
                'customer_phone',
                'app_city',
                'app_street',
                'app_house_number',
                'app_house_building',
                'app_flat_num',
                'app_floor_num',
                'app_house_entrance',
                'problem_text',
                'app_status',
            ]));

            // сохраняем изменения в базу данных
            $this->appRepository->save($app);

            if (empty($app)) {
                $this->response['message'] = 'Application is not created';
                $this->response['status'] = $statuses['warning'];

                return $this->response;
            }
        } else {
            $this->response['message'] = 'Application data is empty';
            $this->response['status'] = $statuses['warning'];

            return $this->response;
        }

        $this->response['data'] = $app;
        $this->response['message'] = 'Application created successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }
}