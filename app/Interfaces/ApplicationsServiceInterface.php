<?php
namespace App\Interfaces;

interface ApplicationsServiceInterface
{
    public function getApplicationsList();

    public function updateApplicationById($request, $id);

    public function getApplicationById($id);

    public function deleteApplicationById($id);

    public function createApplication($request);

    public function getByFields(array $request);
}
