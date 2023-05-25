<?php
namespace App\Services;

use App\Models\Applications;
use Illuminate\Support\Facades\Config;

class ApplicationsService
{
    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    public function getApplicationsList()
    {
        $statuses = Config::get('ApiStatus');

        $this->response['data'] = Applications::all();
        $this->response['message'] = 'All apps';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function updateApplicationById($request, $id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id) && !empty($id)) {
            $app = Applications::find($id);

            if (!$app) {
                $this->response['message'] = 'App not found';
                $this->response['status'] = $statuses['warning'];
        
                return $this->response;
            }

            // заполняем модель только теми полями, которые пришли в запросе
            $app->fill($request->only([
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
            $app->save();
            $app = Applications::find($id);

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
            $app = Applications::find($id);
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
            $app = Applications::find($id);
        }
        if (empty($app)) {
            $this->response['message'] = 'App not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $app = $app->delete();
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

            $app->fill($request->only([
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
                'master_id',
                'app_status',
            ]));

            // сохраняем изменения в базу данных
            $app->save();

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