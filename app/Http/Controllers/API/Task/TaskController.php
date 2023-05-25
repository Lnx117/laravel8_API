<?php

namespace App\Http\Controllers\API\Task;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Tasks;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Services\TasksService;

class TaskController extends Controller
{
    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

/**
 * @OA\Get(
 *     path="/api/sanctum/getTasksList",
 *     summary="Получение списка задач",
 *     description="Возвращает список всех задач.",
 *     tags={"Задачи"},
 *     security={{"apiAuth":{}}},
 *     @OA\Response(
 *         response="200",
 *         description="Список задач",
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
    public function getTasksList(TasksService $tasksService)
    {
        $serviceResponse = $tasksService->getTasksList();

        return $serviceResponse;
    }

/**
 * @OA\Put(
 *      path="/api/sanctum/updateTaskById/{id}",
 *      description="Меняет задачу по ее Id",
 *      tags={"Задачи"},
 *      summary="Update task by ID",
 *      security={{"apiAuth":{}}},
 *      @OA\Parameter(
 *          name="id",
 *          description="Task ID",
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
 *                      property="application_id",
 *                      type="string",
 *                      example="1",
 *                      description="Task application_id"
 *                  ),
 *                  @OA\Property(
 *                      property="master_id",
 *                      type="string",
 *                      example="1",
 *                      description="Task master_id"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="string",
 *                      example="Принято",
 *                      description="Task status"
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
    public function updateTaskById(TasksService $tasksService, Request $request, $id)
    {
        $serviceResponse = $tasksService->updateTaskById($request, $id);

        return $serviceResponse;
    }

/**
 * @OA\get(
 *      path="/api/sanctum/getTaskById/{id}",
 *      description="Получает задачу по ID",
 *      tags={"Задачи"},
 *      summary="Get task by ID",
 *      security={{"apiAuth":{}}},
 *      @OA\Parameter(
 *          name="id",
 *          description="Task ID",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Task founded successfully"
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Task not found"
 *      )
 * )
 */
    public function getTaskById(TasksService $tasksService, $id)
    {
        $serviceResponse = $tasksService->getTaskById($id);

        return $serviceResponse;
    }

    /**
     * @OA\delete(
     *      path="/api/sanctum/deleteTaskById/{id}",
     *      description="Удаляет задачу по ID",
     *      tags={"Задачи"},
     *      summary="Delete task by ID",
     *      security={{"apiAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Task ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Task deleted successfully"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Task not found"
     *      )
     * )
     */
    public function deleteTaskById(TasksService $tasksService, $id)
    {
        $serviceResponse = $tasksService->deleteTaskById($id);

        return $serviceResponse;
    }

    /**
     * @OA\Get(
     *      path="/api/sanctum/createTask/{application_id}/{master_id}/{status}",
     *      description="Меняет задачу по ее Id",
     *      tags={"Задачи"},
     *      summary="Create task",
     *      security={{"apiAuth":{}}},
     *      @OA\Parameter(
     *          name="application_id",
     *          description="application_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *          @OA\Parameter(
     *          name="master_id",
     *          description="master_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *          @OA\Parameter(
     *          name="status",
     *          description="status",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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
    public function createTask(TasksService $tasksService, $application_id, $master_id, $status = 'Принято')
    {
        $serviceResponse = $tasksService->createTask($application_id, $master_id, $status = 'Принято');

        return $serviceResponse;
    }
}
