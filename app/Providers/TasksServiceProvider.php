<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

use App\Repositories\TaskRepository;
use App\Services\TasksService;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\TasksServiceInterface;

class TasksServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TaskRepositoryInterface::class, TaskRepository::class);
        
        $this->app->singleton(TasksServiceInterface::class, TasksService::class);

        //строка излишня
        // $this->app->singleton(TasksService::class, function($app) {
        //     $taskRepository = $app->make(TaskRepositoryInterface::class);
        //     return new TasksService($taskRepository);
        // });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
