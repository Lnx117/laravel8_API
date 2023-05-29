<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Services\AuthService;
use App\Interfaces\AuthServiceInterface;

class AuthCustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //Говорим что при вызове AuthRepositoryInterface должны иметь в виду AuthRepository
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        
        //Говорим что при вызове AuthServiceInterface должны иметь в виду AuthService
        $this->app->singleton(AuthServiceInterface::class, AuthService::class);
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
