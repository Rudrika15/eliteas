<?php

namespace App\Providers;

use App\Models\Circle;
use App\Models\Member;
use App\Models\Connection;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
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
        view()->composer('*', function ($view) {

            if (!Auth::check()) {
                return;
            }

            $authUser = Auth::user();

            $notifications = Notifications::latest()->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->get()->filter(function ($notification) use ($authUser) {

                $data = json_decode($notification->data, true);
                $type = $data['type'] ?? null;
                if ($type == 'connection_request') {
                    return isset($data['memberId']) && $data['memberId'] == $authUser->id;
                }
                if ($type == 'connection_accept' || $type == 'connection_reject') {
                    return isset($data['memberId']) && $data['memberId'] == $authUser->id;
                }
                return false;
            })->map(function ($notification) {
                $data = json_decode($notification->data, true);
                $notification->type = $data['type'] ?? null;
                $notification->connection_id = $data['connection_id'] ?? null;
                $notification->sender = User::find($data['userId'] ?? null);
                $notification->receiver = User::find($data['memberId'] ?? null);
                return $notification;
            });

            $notificationCount = $notifications->where('is_read', false)->count();
            $view->with([
                'membersCount' => Member::where('status', 'Active')->count(),
                'circleCount' => Circle::where('status', 'Active')->count(),
                'notifications' => $notifications,
                'notificationCount' => $notificationCount,
                'authId' => $authUser->id
            ]);
        });

        Paginator::useBootstrap();
    }
}
