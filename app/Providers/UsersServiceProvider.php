<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use App\Interfaces\UsersServiceInterface;
use App\Repositories\UserRepository;
use App\Services\UsersService;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\UsersServiceInterface;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //Говорим что при вызове UserRepositoryInterface будем создавать UserRepository
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        
        //Пишем такой же для UsersServiceInterface и UsersService (увидит что на вход UsersService нужен UserRepositoryInterface
        //и сам создаст UserRepository по связи выше)
        $this->app->singleton(UsersServiceInterface::class, UsersService::class);

        //строка излишня
        // $this->app->singleton(UsersService::class, function($app) {
        //     $userRepository = $app->make(UserRepositoryInterface::class);
        //     return new UsersService($userRepository);
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
