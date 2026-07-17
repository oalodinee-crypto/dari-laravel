<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

// مزود الخدمة التطبيقي (إعدادات عامة ومراقبة النماذج)
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // تسجيل المراقبين (Audit Observers) لتتبع التغييرات
        \App\Models\User::observe(\App\Observers\AuditObserver::class);
        \App\Models\Contract::observe(\App\Observers\AuditObserver::class);
        \App\Models\Invoice::observe(\App\Observers\AuditObserver::class);
        \App\Models\Payment::observe(\App\Observers\AuditObserver::class);
        \App\Models\Building::observe(\App\Observers\AuditObserver::class);
        \App\Models\Unit::observe(\App\Observers\AuditObserver::class);
        \App\Models\MaintenanceRequest::observe(\App\Observers\AuditObserver::class);
    }
}
