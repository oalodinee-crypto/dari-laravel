<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// تعريف أوامر الحرفي (Artisan Commands)
// أمر لإظهار اقتباس ملهم
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
