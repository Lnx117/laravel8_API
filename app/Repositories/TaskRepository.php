<?php
namespace App\Repositories;

use App\Models\Tasks;
use App\Interfaces\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllTasks(): array
    {
        return Tasks::all()->toArray();
    }
    
    public function getById(int $id): ?Tasks
    {
        return Tasks::find($id);
    }

    public function save(Tasks $task): Tasks
    {
        $task->save();
        return $task;
    }

    public function delete(Tasks $task): bool
    {
        return $task->delete();
    }

    public function fill(Tasks $task, array $data): Tasks
    {
        $task->fill($data);
        return $task;
    }
}
