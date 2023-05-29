<?php
namespace App\Services;

use App\Models\Tasks;
use Illuminate\Support\Facades\Config;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\TasksServiceInterface;

class TasksService implements TasksServiceInterface
{
    protected $taskRepository;

    //Dependency injection
    //UsersService получает на вход реализацию интерфейса UserRepositoryInterface
    //Реализация прописана в провайдере который создает объект
    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    protected $response = [
        'status' => '',
        'message' => '',
        'data' => '',
    ];

    public function getTasksList()
    {
        $statuses = config('ApiStatus');

        //Получаем список задач
        $this->response['data'] = $this->taskRepository->getAllTasks();
        $this->response['message'] = 'All tasks';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

    public function updateTaskById($request, $id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id) && !empty($id)) {
            $task = $this->taskRepository->getById($id);

            if (!$task) {
                $this->response['message'] = 'Task not found';
                $this->response['status'] = $statuses['warning'];
        
                return $this->response;
            }

            // заполняем модель только теми полями, которые пришли в запросе
            $task = $this->taskRepository->fill($task, $request->only([
                'application_id',
                'master_id',
                'status',
            ]));

            // сохраняем изменения в базу данных
            $this->taskRepository->save($task);
            //$task->save();
            $task = $this->taskRepository->getById($id);

            $this->response['data'] = $task;
            $this->response['message'] = 'Task updated successfully';
            $this->response['status'] = $statuses['ok'];
    
            return $this->response;
        }

    }

    public function getTaskById($id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id) && !empty($id)) {
            $task = $this->taskRepository->getById($id);
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

    public function deleteTaskById($id)
    {
        $statuses = config('ApiStatus');

        // проверяем, является ли параметр идентификатором пользователя
        if (is_numeric($id)) {
            $task = $this->taskRepository->getById($id);
        }
        if (empty($task)) {
            $this->response['message'] = 'Task not found';
            $this->response['status'] = $statuses['warning'];
    
            return $this->response;
        }

        $task = $this->taskRepository->delete($task);
        if ($task != true) {
            $this->response['message'] = 'Task not found';
            $this->response['status'] = $statuses['warning'];

            return $this->response;
        }
        
        $this->response['message'] = 'Task deleted successfully';
        $this->response['status'] = $statuses['ok'];

        return $this->response;
    }

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
            $task = $this->taskRepository->save($task);
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