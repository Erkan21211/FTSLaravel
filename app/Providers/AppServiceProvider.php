<?php

namespace App\Providers;

use App\Models\BusPlanning;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::model('busPlanning', BusPlanning::class);

        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });
    }
}
