@extends('layouts.app')

@section('title', 'الإعدادات')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0">
                <i class="bi bi-gear text-primary me-2"></i>
                الإعدادات
            </h2>
            <p class="text-muted mt-2">تخصيص تجربتك في النظام</p>
        </div>
    </div>

    <div class="row">
        <!-- القائمة الجانبية للإعدادات -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="nav flex-column nav-pills" id="settings-tab" role="tablist">
                        <button class="nav-link active text-start rounded-0" id="notifications-tab" data-bs-toggle="pill" data-bs-target="#notifications" type="button">
                            <i class="bi bi-bell me-2"></i> الإشعارات
                        </button>
                        <button class="nav-link text-start rounded-0" id="appearance-tab" data-bs-toggle="pill" data-bs-target="#appearance" type="button">
                            <i class="bi bi-palette me-2"></i> المظهر
                        </button>
                        <button class="nav-link text-start rounded-0" id="language-tab" data-bs-toggle="pill" data-bs-target="#language" type="button">
                            <i class="bi bi-translate me-2"></i> اللغة
                        </button>
                        <button class="nav-link text-start rounded-0" id="security-tab" data-bs-toggle="pill" data-bs-target="#security" type="button">
                            <i class="bi bi-shield-lock me-2"></i> الأمان
                        </button>
                        <button class="nav-link text-start rounded-0" id="privacy-tab" data-bs-toggle="pill" data-bs-target="#privacy" type="button">
                            <i class="bi bi-eye-slash me-2"></i> الخصوصية
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- محتوى الإعدادات -->
        <div class="col-lg-9">
            <form action="{{ route('user-settings.update') }}" method="POST">
                @csrf
                
                <div class="tab-content" id="settings-tabContent">
                    
                    <!-- إعدادات الإشعارات -->
                    <div class="tab-pane fade show active" id="notifications" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-bell me-2"></i>إعدادات الإشعارات</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="notification_email" name="notification_email" value="1" checked>
                                        <label class="form-check-label" for="notification_email">
                                            <strong>إشعارات البريد الإلكتروني</strong>
                                            <p class="text-muted small mb-0">استلام الإشعارات عبر البريد الإلكتروني</p>
                                        </label>
                                    </div>
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="notification_sms" name="notification_sms" value="1">
                                        <label class="form-check-label" for="notification_sms">
                                            <strong>إشعارات SMS</strong>
                                            <p class="text-muted small mb-0">استلام الإشعارات عبر الرسائل القصيرة</p>
                                        </label>
                                    </div>
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="notification_push" name="notification_push" value="1" checked>
                                        <label class="form-check-label" for="notification_push">
                                            <strong>الإشعارات الفورية</strong>
                                            <p class="text-muted small mb-0">إشعارات داخل النظام</p>
                                        </label>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">أنواع الإشعارات</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="notify_invoices" checked>
                                            <label class="form-check-label" for="notify_invoices">الفواتير الجديدة</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="notify_payments" checked>
                                            <label class="form-check-label" for="notify_payments">تأكيد الدفع</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="notify_maintenance" checked>
                                            <label class="form-check-label" for="notify_maintenance">تحديثات الصيانة</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="notify_announcements" checked>
                                            <label class="form-check-label" for="notify_announcements">الإعلانات</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="notify_messages" checked>
                                            <label class="form-check-label" for="notify_messages">الرسائل الجديدة</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="notify_contracts" checked>
                                            <label class="form-check-label" for="notify_contracts">تذكير العقود</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- إعدادات المظهر -->
                    <div class="tab-pane fade" id="appearance" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-palette me-2"></i>المظهر</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="form-label"><strong>نمط العرض</strong></label>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="card theme-option selected" data-theme="light" onclick="selectTheme('light')">
                                                <div class="card-body text-center p-4">
                                                    <div class="bg-light border rounded p-3 mb-2">
                                                        <i class="bi bi-sun fs-1 text-warning"></i>
                                                    </div>
                                                    <strong>فاتح</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card theme-option" data-theme="dark" onclick="selectTheme('dark')">
                                                <div class="card-body text-center p-4">
                                                    <div class="bg-dark rounded p-3 mb-2">
                                                        <i class="bi bi-moon-stars fs-1 text-light"></i>
                                                    </div>
                                                    <strong>داكن</strong>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card theme-option" data-theme="auto" onclick="selectTheme('auto')">
                                                <div class="card-body text-center p-4">
                                                    <div class="bg-secondary bg-opacity-25 rounded p-3 mb-2">
                                                        <i class="bi bi-circle-half fs-1 text-secondary"></i>
                                                    </div>
                                                    <strong>تلقائي</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="theme" id="theme_input" value="light">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><strong>حجم الخط</strong></label>
                                    <select class="form-select">
                                        <option value="small">صغير</option>
                                        <option value="medium" selected>متوسط</option>
                                        <option value="large">كبير</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- إعدادات اللغة -->
                    <div class="tab-pane fade" id="language" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-translate me-2"></i>اللغة</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="form-label"><strong>لغة العرض</strong></label>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="card lang-option selected" data-lang="ar" onclick="selectLang('ar')">
                                                <div class="card-body text-center p-4">
                                                    <div class="fs-1 mb-2">🇾🇪</div>
                                                    <strong>العربية</strong>
                                                    <p class="text-muted small mb-0">Arabic</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card lang-option" data-lang="en" onclick="selectLang('en')">
                                                <div class="card-body text-center p-4">
                                                    <div class="fs-1 mb-2">🇺🇸</div>
                                                    <strong>English</strong>
                                                    <p class="text-muted small mb-0">الإنجليزية</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="language" id="language_input" value="ar">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- إعدادات الأمان -->
                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>الأمان</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-3">تغيير كلمة المرور</h6>
                                
                                <div class="mb-3">
                                    <label class="form-label">كلمة المرور الحالية</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">كلمة المرور الجديدة</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">
                                    <small class="text-muted">8 أحرف على الأقل</small>
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                                    <input type="password" class="form-control" name="new_password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- إعدادات الخصوصية -->
                    <div class="tab-pane fade" id="privacy" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-eye-slash me-2"></i>الخصوصية</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="show_profile" checked>
                                    <label class="form-check-label" for="show_profile">
                                        <strong>إظهار الملف الشخصي</strong>
                                        <p class="text-muted small mb-0">السماح للآخرين برؤية معلوماتك</p>
                                    </label>
                                </div>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="show_phone" checked>
                                    <label class="form-check-label" for="show_phone">
                                        <strong>إظهار رقم الهاتف</strong>
                                        <p class="text-muted small mb-0">للإدارة والمدير فقط</p>
                                    </label>
                                </div>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="show_email">
                                    <label class="form-check-label" for="show_email">
                                        <strong>إظهار البريد الإلكتروني</strong>
                                        <p class="text-muted small mb-0">للجميع</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- زر الحفظ -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-check-circle me-2"></i>حفظ الإعدادات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.theme-option, .lang-option {
    cursor: pointer;
    transition: all 0.3s;
    border: 2px solid transparent;
}
.theme-option:hover, .lang-option:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.theme-option.selected, .lang-option.selected {
    border-color: #198754;
    background: rgba(25, 135, 84, 0.05);
}
.nav-pills .nav-link {
    color: var(--text-color);
    padding: 12px 20px;
}
.nav-pills .nav-link.active {
    background: #667eea;
    color: #fff;
}
</style>

<script>
function selectTheme(theme) {
    document.querySelectorAll('.theme-option').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.theme-option[data-theme="${theme}"]`).classList.add('selected');
    document.getElementById('theme_input').value = theme;
}

function selectLang(lang) {
    document.querySelectorAll('.lang-option').forEach(el => el.classList.remove('selected'));
    document.querySelector(`.lang-option[data-lang="${lang}"]`).classList.add('selected');
    document.getElementById('language_input').value = lang;
}
</script>
@endsection