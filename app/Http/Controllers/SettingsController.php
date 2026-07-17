<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// تحكم الإعدادات العامة للنظام
class SettingsController extends Controller
{
    // عرض صفحة الإعدادات
    public function index()
    {
        $settings = Setting::getAllSettings();
        return view('settings.index', compact('settings'));
    }

    // تحديث إعدادات النظام
    public function update(Request $request)
    {
        $settingsKeys = [
            'site_name', 'email', 'phone', 'address', 'language', 'currency',
            'tax_rate', 'late_fee_rate', 'grace_days',
            'email_notifications', 'system_notifications', 'contract_reminder_days', 'invoice_reminder_days',
            'primary_color', 'default_theme',
            'auto_logout', 'session_timeout',
            'backup_frequency'
        ];

        foreach ($settingsKeys as $key) {
            $value = $request->has($key) ? $request->input($key) : null;

            if (in_array($key, ['email_notifications', 'system_notifications', 'auto_logout'], true)) {
                $value = $request->has($key) ? '1' : '0';
            }

            Setting::set($key, $value);
        }

        return redirect()->route('settings.index')->with('success', 'تم حفظ الإعدادات بنجاح');
    }

    public function general()
    {
        return redirect()->route('settings.index');
    }

    /**
     * إعدادات المستخدم (للساكن والمدير)
     */
    public function userSettings()
    {
        $user = auth()->user();
        return view('user-settings', compact('user'));
    } // ✅ هذا القوس هو اللي ناقص عندك

    /**
     * تحديث إعدادات المستخدم
     */
    public function updateUserSettings(Request $request)
    {
        $user = auth()->user();

        if ($request->filled('new_password')) {
            $request->validate([
                'current_password' => ['required'],
                'new_password'     => ['required', 'min:8', 'confirmed'],
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return back()->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}
