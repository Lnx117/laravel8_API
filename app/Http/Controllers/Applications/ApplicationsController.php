<?php

namespace App\Http\Controllers\Applications;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Applications;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;

class ApplicationsController extends Controller
{
    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

/**
 * @OA\Get(
 *     path="/api/sanctum/getApplicationsList",
 *     summary="Получение списка заявок",
 *     description="Возвращает список всех заявок.",
 *     tags={"Заявки"},
 *     security={{"apiAuth":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Список заявок",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/RegisterRequest")
 *         )
 *     ),
 *     @OA\Response(
 *         response="401",
 *         description="Не авторизован. Токен доступа отсутствует или недействителен.",
 *     ),
 * )
 */
    public function getApplicationsList()
    {
        $statuses = config('ApiStatus');

        //Получаем список задач
        $this->response['data'] = Applications::all();
        $this->response['message'] = 'All apps';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

/**
 * @OA\Put(
 *      path="/api/sanctum/updateApplicationById/{id}",
 *      description="Меняет заявку по ее Id",
 *      tags={"Заявки"},
 *      summary="Update app by ID",
 *      security={{"apiAuth":{}}},
 *      @OA\Parameter(
 *          name="id",
 *          description="App ID",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(
 *                  type="object",
 *                  @OA\Property(
 *                      property="bitrix_customer_id",
 *                      type="string",
 *                      example="1221321",
 *                      description="bitrix_customer_id name"
 *                  ),
 *                  @OA\Property(
 *                      property="customer_first_name",
 *                      type="string",
 *                      example="Владислав",
 *                      description="customer_first_name"
 *                  ),
 *                  @OA\Property(
 *                      property="customer_last_name",
 *                      type="string",
 *                      example="Остряков",
 *                      description="customer_last_name"
 *                  ),
 *                  @OA\Property(
 *                      property="customer_patronymic",
 *                      type="string",
 *                      example="Павлович",
 *                      description="customer_patronymic"
 *                  ),
 *                  @OA\Property(
 *                      property="customer_phone",
 *                      type="string",
 *                      example="+79128539823",
 *                      description="User email"
 *                  ),
 *                  @OA\Property(
 *                      property="app_city",
 *                      type="string",
 *                      example="Москва",
 *                      description="app_city"
 *                  ),
 *                  @OA\Property(
 *                      property="app_street",
 *                      type="string",
 *                      example="Поляны",
 *                      description="app_street"
 *                  ),
 *                  @OA\Property(
 *                      property="app_house_number",
 *                      type="string",
 *                      example="45",
 *                      description="app_house_number"
 *                  ),
 *                  @OA\Property(
 *                      property="app_house_building",
 *                      type="string",
 *                      example="-",
 *                      description="app_house_building"
 *                  ),
 *                  @OA\Property(
 *                      property="app_flat_num",
 *                      type="string",
 *                      example="3598",
 *                      description="app_flat_num"
 *                  ),
 *                  @OA\Property(
 *                      property="app_floor_num",
 *                      type="string",
 *                      example="32",
 *                      description="app_floor_num"
 *                  ),
 *                  @OA\Property(
 *                      property="app_house_entrance",
 *                      type="string",
 *                      example="цу",
 *                      description="app_house_entrance"
 *                  ),
 *                  @OA\Property(
 *                      property="problem_text",
 *                      type="string",
 *                      example="Все оки)",
 *                      description="problem_text"
 *                  ),
 *                  @OA\Property(
 *                      property="master_id",
 *                      type="string",
 *                      example="332",
 *                      description="master_id"
 *                  ),
 *                  @OA\Property(
 *                      property="app_status",
 *                      type="string",
 *                      example="Принято",
 *                      description="app_status"
 *                  ),
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Task updated successfully"
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Task not found"
 *      )
 * )
 */
    public function updateApplicationById(Request $request, $id)
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

/**
 * @OA\get(
 *      path="/api/sanctum/getApplicationById/{id}",
 *      description="Получает заявку по ID",
 *      tags={"Заявки"},
 *      summary="Get app by ID",
 *      security={{"apiAuth":{}}},
 *      @OA\Parameter(
 *          name="id",
 *          description="App ID",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="App founded successfully"
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="App not found"
 *      )
 * )
 */
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

    /**
     * @OA\delete(
     *      path="/api/sanctum/deleteApplicationById/{id}",
     *      description="Удаляет заявку по ID",
     *      tags={"Заявки"},
     *      summary="Delete app by ID",
     *      security={{"apiAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="App ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="App deleted successfully"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="App not found"
     *      )
     * )
     */
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

    /**
     * @OA\Post(
     *      path="/api/sanctum/createApplication",
     *      description="Создает заявку",
     *      tags={"Заявки"},
     *      summary="Create task",
     *      security={{"apiAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="bitrix_customer_id",
     *                      type="string",
     *                      example="1221321",
     *                      description="bitrix_customer_id name"
     *                  ),
     *                  @OA\Property(
     *                      property="customer_first_name",
     *                      type="string",
     *                      example="Владислав",
     *                      description="customer_first_name"
     *                  ),
     *                  @OA\Property(
     *                      property="customer_last_name",
     *                      type="string",
     *                      example="Остряков",
     *                      description="customer_last_name"
     *                  ),
     *                  @OA\Property(
     *                      property="customer_patronymic",
     *                      type="string",
     *                      example="Павлович",
     *                      description="customer_patronymic"
     *                  ),
     *                  @OA\Property(
     *                      property="customer_phone",
     *                      type="string",
     *                      example="+79128539823",
     *                      description="User email"
     *                  ),
     *                  @OA\Property(
     *                      property="app_city",
     *                      type="string",
     *                      example="Москва",
     *                      description="app_city"
     *                  ),
     *                  @OA\Property(
     *                      property="app_street",
     *                      type="string",
     *                      example="Поляны",
     *                      description="app_street"
     *                  ),
     *                  @OA\Property(
     *                      property="app_house_number",
     *                      type="string",
     *                      example="45",
     *                      description="app_house_number"
     *                  ),
     *                  @OA\Property(
     *                      property="app_house_building",
     *                      type="string",
     *                      example="-",
     *                      description="app_house_building"
     *                  ),
     *                  @OA\Property(
     *                      property="app_flat_num",
     *                      type="string",
     *                      example="3598",
     *                      description="app_flat_num"
     *                  ),
     *                  @OA\Property(
     *                      property="app_floor_num",
     *                      type="string",
     *                      example="32",
     *                      description="app_floor_num"
     *                  ),
     *                  @OA\Property(
     *                      property="app_house_entrance",
     *                      type="string",
     *                      example="цу",
     *                      description="app_house_entrance"
     *                  ),
     *                  @OA\Property(
     *                      property="problem_text",
     *                      type="string",
     *                      example="Все оки)",
     *                      description="problem_text"
     *                  ),
     *                  @OA\Property(
     *                      property="master_id",
     *                      type="string",
     *                      example="332",
     *                      description="master_id"
     *                  ),
     *                  @OA\Property(
     *                      property="app_status",
     *                      type="string",
     *                      example="Принято",
     *                      description="app_status"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Task created successfully"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Task not created"
     *      )
     * )
     */
    public function createApplication(Request $request)
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
