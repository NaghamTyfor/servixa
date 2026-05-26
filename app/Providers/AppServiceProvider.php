<?php

namespace App\Providers;

use App\Models\BusinessAccount;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Observers\BusinessAccountObserver;
use App\Observers\ServiceObserver;
use App\Observers\ServiceRequestObserver;
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
       BusinessAccount::observe(BusinessAccountObserver::class);
        Service::observe(ServiceObserver::class);
        ServiceRequest::observe(ServiceRequestObserver::class);
        }
}
