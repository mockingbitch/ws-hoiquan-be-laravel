<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public $bindings = [
        \App\Repositories\Contracts\RepositoryInterface\UserRepositoryInterface::class
        => \App\Repositories\Contracts\Repository\UserRepository::class,
        \App\Repositories\Contracts\RepositoryInterface\TagRepositoryInterface::class
        => \App\Repositories\Contracts\Repository\TagRepository::class,
        \App\Repositories\Contracts\RepositoryInterface\CategoryRepositoryInterface::class
        => \App\Repositories\Contracts\Repository\CategoryRepository::class,
        \App\Repositories\Contracts\RepositoryInterface\FilmRepositoryInterface::class
        => \App\Repositories\Contracts\Repository\FilmRepository::class,
        \App\Repositories\Contracts\RepositoryInterface\VoteRepositoryInterface::class
        => \App\Repositories\Contracts\Repository\VoteRepository::class,
        \App\Repositories\Contracts\RepositoryInterface\FilmTagRepositoryInterface::class
        => \App\Repositories\Contracts\Repository\FilmTagRepository::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
