<?php
namespace App\Repositories;

use App\Models\Applications;
use App\Interfaces\ApplicationsRepositoryInterface;

class ApplicationsRepository implements ApplicationsRepositoryInterface
{
    public function getAllApplications(): array
    {
        return Applications::all()->toArray();
    }
    
    public function getById(int $id): ?Applications
    {
        return Applications::find($id);
    }

    public function save(Applications $app): Applications
    {
        $app->save();
        return $app;
    }

    public function delete(Applications $app): bool
    {
        return $app->delete();
    }

    public function fill(Applications $app, array $data): Applications
    {
        $app->fill($data);
        return $app;
    }
}
