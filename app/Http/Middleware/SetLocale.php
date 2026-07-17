<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

// وسيط تعيين لغة التطبيق
class SetLocale
{
    // تعيين اللغة بناءً على الجلسة أو الإعداد الافتراضي (العربية)
    public function handle(Request $request, Closure $next)
    {
        $locale = session('locale', config('app.locale', 'ar'));
        App::setLocale($locale);
        
        return $next($request);
    }
}
