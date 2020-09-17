<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\CategoryRepository::class, \App\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BookRepository::class, \App\Repositories\BookRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BookCategoryRepository::class, \App\Repositories\BookCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DeviceRepository::class, \App\Repositories\DeviceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FavoriteBookRepository::class, \App\Repositories\FavoriteBookRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PaymentRepository::class, \App\Repositories\PaymentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
    }
}
