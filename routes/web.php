<?php
use App\Http\Controllers\SearchController;
// استيراد واجهة مسارات لارافل
use Illuminate\Support\Facades\Route;
// استيراد وحدات التحكم (Controllers) الخاصة بالمشروع
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportExportController;
use App\Http\Controllers\PdfExportController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\PublicUnitController;
use App\Http\Controllers\BuildingCategoryController;
use App\Http\Controllers\BuildingTypeController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UnitRequestController;


// تغيير لغة التطبيق (عربي / إنجليزي)
// Language Switch
Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
});

// المسارات العامة التي لا تتطلب تسجيل دخول
// Public Routes
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
})->name('home');

// مسار آخر لتغيير اللغة
// Language Switch
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// صفحات الوحدات العامة (الوصول عبر رمز QR)
// Public Unit Pages (QR Code Access)
Route::prefix('unit')->name('units.')->group(function () {
    Route::get('/{unit}/public', [PublicUnitController::class, 'show'])->name('public');
    Route::get('/{unit}/maintenance', [PublicUnitController::class, 'maintenanceForm'])->name('maintenance-form');
    Route::post('/{unit}/maintenance', [PublicUnitController::class, 'submitMaintenance'])->name('submit-maintenance');
});

// مسارات المصادقة (تسجيل الدخول، التسجيل، استعادة كلمة المرور)
// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    
    // تسجيل الدخول عبر جوجل
    // Social Login - Google
    Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
    
    // تسجيل الدخول عبر فيسبوك
    // Social Login - Facebook
    Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// المسارات المحمية (تتطلب تسجيل دخول المستخدم)
// Protected Routes
Route::middleware('auth')->group(function () {
    // لوحة التحكم الرئيسية
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    
    // =====================
    // البحث الشامل - Search
    // =====================
    Route::get('/search', [SearchController::class, 'index'])->name('search');
    
    // إدارة العقارات / المباني
    // Buildings
    Route::resource('buildings', BuildingController::class);
    
    // تصنيفات وأنواع المباني
    // Building Categories & Types
    Route::resource('building-categories', BuildingCategoryController::class);
    Route::resource('building-types', BuildingTypeController::class);
    
    // إدارة الوحدات السكنية
    // Units
    Route::resource('units', UnitController::class);
    Route::post('units/{unit}/upload-images', [UnitController::class, 'uploadImages'])->name('units.upload-images');
    Route::delete('units/{unit}/delete-image', [UnitController::class, 'deleteImage'])->name('units.delete-image');
    Route::post('units/{unit}/generate-qr', [UnitController::class, 'generateQrCode'])->name('units.generate-qr');
    
    // إدارة العقود
    // Contracts
    Route::resource('contracts', ContractController::class);
    
    // إدارة الفواتير
    // Invoices
    Route::resource('invoices', InvoiceController::class);
    
    // إدارة الممتلكات
    // Properties
    Route::resource('properties', PropertyController::class);
    
    // إدارة طلبات الصيانة
    // Maintenance
    Route::resource('maintenance', MaintenanceController::class);
    Route::patch('/maintenance/{maintenance}/status', [MaintenanceController::class, 'updateStatus'])->name('maintenance.status');
    
    // الإعلانات والتعاميم
    // Announcements
    Route::resource('announcements', AnnouncementController::class);
    
    // المدفوعات والسجل المالي
    // Payments
    Route::resource('payments', PaymentController::class);
    
    // الشكاوى والمقترحات
    // Complaints
    Route::resource('complaints', ComplaintController::class);
    Route::post('complaints/{complaint}/reject', [ComplaintController::class, 'reject'])->name('complaints.reject');
    Route::post('complaints/{complaint}/assign', [ComplaintController::class, 'assign'])->name('complaints.assign');
    
    // إدارة المستخدمين (عرض وتعديل الصلاحيات)
    // Users Management
    Route::middleware('permission:view users')->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/users/{user}/permissions', [UserController::class, 'permissions'])->name('users.permissions');
        Route::post('/users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.permissions.update');
    });
    
    // الأدوار والصلاحيات
    // Roles & Permissions
    Route::middleware('permission:manage roles')->group(function () {
        Route::resource('roles', RoleController::class);
    });
    
    // إعدادات النظام العامة
    // Settings
    Route::middleware('permission:manage settings')->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/', [SettingsController::class, 'update'])->name('update');
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
    });
    
    // الملف الشخصي للمستخدم الحالي
    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // إعدادات المستخدم (للساكن والمدير) تخصيص الحساب
    // User Settings (للساكن والمدير)
    Route::prefix('user-settings')->name('user-settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'userSettings'])->name('index');
        Route::post('/', [SettingsController::class, 'updateUserSettings'])->name('update');
    });
    
    // التقارير العامة للنظام
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportsController::class, 'index'])->name('index');
        Route::get('/export', [ReportsController::class, 'export'])->name('export');
        Route::get('/custom', [ReportsController::class, 'custom'])->name('custom');
    });
    
    // سجل النشاطات (Log)
    // Activities
    Route::get('/activities', [DashboardController::class, 'activities'])->name('activities.index');
    
    // نظام الإشعارات والتنبيهات
    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/create', [NotificationController::class, 'create'])->name('create');
        Route::post('/send', [NotificationController::class, 'send'])->name('send');
        Route::get('/unread', [NotificationController::class, 'unread'])->name('unread');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('markRead');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('markAllRead');
        Route::post('/clear-read', [NotificationController::class, 'clearRead'])->name('clearRead');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });
    
    // نظام المراسلات والدردشة الداخلية
    // Messages - نظام المراسلات
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/create', [MessageController::class, 'create'])->name('create');
        Route::post('/', [MessageController::class, 'store'])->name('store');
        Route::get('/unread-count', [MessageController::class, 'unreadCount'])->name('unreadCount');
        Route::get('/{userId}', [MessageController::class, 'show'])->name('show');
        Route::post('/{userId}/reply', [MessageController::class, 'reply'])->name('reply');
        Route::post('/{message}/read', [MessageController::class, 'markAsRead'])->name('markAsRead');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
    });
    
    // تصدير التقارير (Excel/CSV)
    // Export Reports
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/buildings', [ReportExportController::class, 'exportBuildings'])->name('buildings');
        Route::get('/units', [ReportExportController::class, 'exportUnits'])->name('units');
        Route::get('/contracts', [ReportExportController::class, 'exportContracts'])->name('contracts');
        Route::get('/invoices', [ReportExportController::class, 'exportInvoices'])->name('invoices');
        Route::get('/payments', [ReportExportController::class, 'exportPayments'])->name('payments');
        Route::get('/financial', [ReportExportController::class, 'exportFinancialSummary'])->name('financial');
        Route::get('/users', [ReportExportController::class, 'exportUsers'])->name('users');
    });
    
    // تصدير ملفات PDF (عقود، فواتير، سندات)
    // PDF Export
    Route::prefix('pdf')->name('pdf.')->group(function () {
        Route::get('/contract/{id}', [PdfExportController::class, 'exportContract'])->name('contract');
        Route::get('/invoice/{id}', [PdfExportController::class, 'exportInvoice'])->name('invoice');
        Route::get('/payment/{id}', [PdfExportController::class, 'exportPayment'])->name('payment');
    });
    
    // =====================
    // Resident Routes - مسارات الساكن (واجهة المستأجر)
    // =====================
    Route::prefix('resident')->name('resident.')->middleware('role:Resident')->group(function () {
        Route::get('/my-unit', [DashboardController::class, 'residentUnit'])->name('my-unit');
        Route::get('/my-invoices', [DashboardController::class, 'residentInvoices'])->name('my-invoices');
        Route::get('/my-payments', [DashboardController::class, 'residentPayments'])->name('my-payments');
        Route::get('/my-maintenance', [DashboardController::class, 'residentMaintenance'])->name('my-maintenance');
        Route::post('/my-maintenance', [MaintenanceController::class, 'store'])->name('my-maintenance.store');
        Route::get('/my-complaints', [DashboardController::class, 'residentComplaints'])->name('my-complaints');
        Route::post('/my-complaints', [ComplaintController::class, 'store'])->name('my-complaints.store');
        Route::get('/pay-online', function() { return view('resident.pay-online'); })->name('pay-online');
        
        // طلب وحدة جديدة
        Route::get('/request-unit', [UnitRequestController::class, 'create'])->name('request-unit');
        Route::post('/request-unit', [UnitRequestController::class, 'store'])->name('request-unit.store');
        
        // طلباتي
        Route::get('/my-requests', [UnitRequestController::class, 'index'])->name('my-requests');
        Route::get('/my-requests/{request}', [UnitRequestController::class, 'show'])->name('my-requests.show');
        Route::delete('/my-requests/{request}', [UnitRequestController::class, 'destroy'])->name('my-requests.destroy');
        
        // Chatbot AI
        Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot');
    });
    
    // =====================
    // Manager Routes - مسارات المدير (الإدارة)
    // =====================
    Route::prefix('manager')->name('manager.')->middleware('role:Manager')->group(function () {
        // طلبات الوحدات من السكان
        Route::get('/unit-requests', [UnitRequestController::class, 'managerIndex'])->name('unit-requests');
        Route::get('/unit-requests/{request}', [UnitRequestController::class, 'managerShow'])->name('unit-requests.show');
        Route::post('/unit-requests/{request}/approve', [UnitRequestController::class, 'approve'])->name('unit-requests.approve');
        Route::post('/unit-requests/{request}/reject', [UnitRequestController::class, 'reject'])->name('unit-requests.reject');
    });
});
