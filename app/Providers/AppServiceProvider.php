<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Repository\TaskRepositoryInterface;
use Src\Domain\Repository\TaskTimeRepositoryInterface;
use Src\Infrastructure\Persistence\Eloquent\EloquentTaskRepository;
use Src\Infrastructure\Persistence\Eloquent\EloquentTaskTimeRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind interfaces to implementations
        $this->app->bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);
        $this->app->bind(TaskTimeRepositoryInterface::class, EloquentTaskTimeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
