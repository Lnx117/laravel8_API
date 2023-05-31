<?php
namespace App\Interfaces;

use App\Models\Applications;

interface ApplicationsRepositoryInterface
{
    public function getById(int $id): ?Applications;

    public function getAllApplications(): array;

    public function getByFields(array $data): array;

    public function save(Applications $app): Applications;

    public function delete(Applications $app): bool;

    public function fill(Applications $app, array $data): Applications;
}
