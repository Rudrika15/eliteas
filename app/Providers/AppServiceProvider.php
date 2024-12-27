<?php

namespace App\Providers;

use App\Models\Circle;
use App\Models\Member;
use Illuminate\Pagination\Paginator;
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
        view()->share([
            'membersCount' => Member::where('status', 'Active')->count(),
            'circleCount' => Circle::where('status', 'Active')->count(),
        ]);

        Paginator::useBootstrap();
    }
}
