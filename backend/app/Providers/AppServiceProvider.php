<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\ParallelTesting;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Executed when a test database is created...
        ParallelTesting::setUpTestDatabase(function ($database, $token) {
            Artisan::call('migrate:fresh', [
                '--database' => $database,
                '--seed' => true,
            ]);
            // Artisan::call('db:seed');
        });
    }
}
