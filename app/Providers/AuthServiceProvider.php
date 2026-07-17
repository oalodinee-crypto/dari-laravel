<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\User;
use App\Policies\PropertyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

// مزود خدمة التوثيق والصلاحيات (Policies)
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Property::class => PropertyPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
