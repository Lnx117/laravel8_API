<?php
namespace App\Interfaces;

use App\Models\Tasks;

interface TaskRepositoryInterface
{
    public function getById(int $id): ?Tasks;

    public function getAllTasks(): array;

    public function save(Tasks $task): Tasks;

    public function delete(Tasks $task): bool;

    public function fill(Tasks $task, array $data): Tasks;
}
