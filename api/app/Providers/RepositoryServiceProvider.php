<?php

namespace App\Providers;

use App\Interfaces\RegistrationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\RegistrationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RegistrationRepositoryInterface::class, RegistrationRepository::class);

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
