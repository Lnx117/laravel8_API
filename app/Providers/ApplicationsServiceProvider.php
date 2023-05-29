<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\ApplicationsRepository;
use App\Services\ApplicationsService;
use App\Interfaces\ApplicationsRepositoryInterface;
use App\Interfaces\ApplicationsServiceInterface;

class ApplicationsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        //Говорим что при вызове ApplicationsRepositoryInterface должны иметь в виду ApplicationsRepository
        $this->app->singleton(ApplicationsRepositoryInterface::class, ApplicationsRepository::class);
        
        //Говорим что при вызове ApplicationsServiceInterface должны иметь в виду ApplicationsService
        $this->app->singleton(ApplicationsServiceInterface::class, ApplicationsService::class);

        //Если реализация класса имеет зависимости, которые также должны быть разрешены и внедрены. В моем случае
        //ApplicationsService имеет зависимость ApplicationsRepositoryInterface, и поэтому я явно связываю
        //ApplicationsService с анонимной функцией, чтобы создать экземпляр ApplicationsService с правильно
        //разрешенной зависимостью ApplicationsRepositoryInterface.

        //Объект ApplicationsService так и так будет создан на первой строке
        //Он проанализирует что при запросе ApplicationsServiceInterface нужно выдавать ApplicationsService
        //а в ApplicationsService требуется ApplicationsRepositoryInterface, а такая связь уже есть и все создаст сам
        //Поэтому эта строка излишня, но можно и оставить
        // $this->app->singleton(ApplicationsService::class, function($app) {
        //     $appRepository = $app->make(ApplicationsRepositoryInterface::class);
        //     return new ApplicationsService($appRepository);
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
