<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Tasks;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
    public function getTasksList()
    {
        $statuses = config('ApiStatus');

        //Получаем список задач
        $this->response['data'] = Tasks::all();
        $this->response['message'] = 'All tasks';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
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
    public function updateTaskById(Request $request, $id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id) && !empty($id)) {
            $task = Tasks::find($id);

            if (!$task) {
                $this->response['message'] = 'Task not found';
                $this->response['status'] = $statuses['warning'];
        
                return $this->response;
            }

            // заполняем модель только теми полями, которые пришли в запросе
            $task->fill($request->only([
                'application_id',
                'master_id',
                'status',
            ]));

            // сохраняем изменения в базу данных
            $task->save();
            $task = Tasks::find($id);

            $this->response['data'] = $task;
            $this->response['message'] = 'Task updated successfully';
            $this->response['status'] = $statuses['ok'];
    
            return $this->response;
        }

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
    public function getTaskById($id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id) && !empty($id)) {
            $task = Tasks::find($id);
        }

        if (empty($task)) {
            $this->response['message'] = 'Task not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $this->response['data'] = $task;
        $this->response['message'] = 'Task founded successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
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
    public function deleteTaskById($id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id)) {
            $task = Tasks::find($id);
        }
        if (empty($task)) {
            $this->response['message'] = 'Task not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $task = $task->delete();
        if ($task != true) {
            $this->response['message'] = 'Task not found';
            $this->response['status'] = $statuses['warning'];

            return $this->response;
        }
        
        $this->response['message'] = 'Task deleted successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
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
    public function createTask($application_id, $master_id, $status = 'Принято')
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($application_id) && !empty($application_id) && is_numeric($master_id) && !empty($master_id)
        && !empty($status)) {
            $task = new Tasks;
            $task->application_id =  $application_id;
            $task->master_id =  $master_id;
            $task->status = $status;

            // сохраняем изменения в базу данных
            $task->save();
            if (empty($task)) {
                $this->response['message'] = 'Task not created';
                $this->response['status'] = $statuses['warning'];

                return $this->response;
            }
        } else {
            $this->response['message'] = 'IDs is not numeric or status is empty';
            $this->response['status'] = $statuses['warning'];

            return $this->response;
        }

        $this->response['data'] = $task;
        $this->response['message'] = 'Task created successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }
}
