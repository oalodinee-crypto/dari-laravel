<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// نموذج الإعدادات العامة للنظام
class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    
    public $timestamps = false;
    
    // جلب إعداد معين
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
    
    // تحديث أو إنشاء إعداد
    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
    
    // جلب كل الإعدادات
    public static function getAllSettings()
    {
        return self::pluck('value', 'key')->toArray();
    }
}