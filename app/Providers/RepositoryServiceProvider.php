<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repository\EloquentRepositoryInterface; 
use App\Repository\UserRepositoryInterface; 
use App\Repository\Eloquent\UserRepository; 
use App\Repository\Eloquent\BaseRepository; 

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
       $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
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
