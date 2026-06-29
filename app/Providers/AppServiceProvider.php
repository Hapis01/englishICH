<?php

namespace App\Providers;

use App\Support\DashboardNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        View::composer(['layouts.admin', 'layouts.teacher', 'layouts.student'], function ($view) {
            $user = Auth::user();
            $notifications = collect();

            if ($user) {
                $notifications = match ($user->role) {
                    'admin' => DashboardNotifications::forAdmin(),
                    'teacher' => DashboardNotifications::forTeacher($user),
                    'student' => DashboardNotifications::forStudent($user),
                    default => collect(),
                };
            }

            $view->with('dashboardNotifications', $notifications);
        });
    }
}
