<?php

namespace App\Http\Controllers\API\Applications;

use Illuminate\Http\Request;
use App\Models\Applications;
use App\Http\Controllers\Controller;
//Интерфейс сервиса
use App\Interfaces\ApplicationsServiceInterface;

class ApplicationsController extends Controller
{
    protected $appService;

    //На вход требуем объект, который реализует интерфейс ApplicationsServiceInterface
    //Он автоматически вернется благодаря сервис провайдеру
    public function __construct(ApplicationsServiceInterface $appService)
    {
        $this->appService = $appService;
    }

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

        //Получаем список задач
        $serviceResponse = $this->appService->getApplicationsList();

        return $serviceResponse;
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
        $serviceResponse = $this->appService->updateApplicationById($request, $id);

        return $serviceResponse;
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
        $serviceResponse = $this->appService->getApplicationById($id);

        return $serviceResponse;
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
        $serviceResponse = $this->appService->deleteApplicationById($id);

        return $serviceResponse;
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
        $serviceResponse = $this->appService->createApplication($request);

        return $serviceResponse;
    }
}
