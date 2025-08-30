<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use App\Services\DiscountService;

class BroadcastServiceProvider extends ServiceProvider
{
     /**
     * Register services in the container.
     */
    public function register()
    {
        // Bind a "DiscountService" class into Laravel’s container
        $this->app->bind('DiscountService', function ($app) {
            return new \App\Services\DiscountService();
        });
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
