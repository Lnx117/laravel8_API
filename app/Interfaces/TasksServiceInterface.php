<?php

namespace App\Interfaces;

interface TasksServiceInterface
{
    public function getTasksList();

    public function updateTaskById($request, $id);

    public function getTaskById($id);

    public function deleteTaskById($id);

    public function createTask($application_id, $master_id, $status = 'Принято');
}
