

<?php $__env->startSection('title', 'الإعدادات'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0"><i class="bi bi-gear text-primary me-2"></i>الإعدادات</h2>
            
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="nav flex-column nav-pills" id="settings-tab" role="tablist">
                        <button class="nav-link active text-start rounded-0" data-bs-toggle="pill" data-bs-target="#notifications" type="button"><i class="bi bi-bell me-2"></i>الإشعارات</button>
                        <button class="nav-link text-start rounded-0" data-bs-toggle="pill" data-bs-target="#appearance" type="button"><i class="bi bi-palette me-2"></i>المظهر</button>
                        <button class="nav-link text-start rounded-0" data-bs-toggle="pill" data-bs-target="#language" type="button"><i class="bi bi-translate me-2"></i>اللغة</button>
                        <button class="nav-link text-start rounded-0" data-bs-toggle="pill" data-bs-target="#security" type="button"><i class="bi bi-shield-lock me-2"></i>الأمان</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <form action="<?php echo e(route('user-settings.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="notifications" role="tabpanel">
                        <div class="card">
                            <div class="card-header"><h5 class="mb-0"><i class="bi bi-bell me-2"></i>إعدادات الإشعارات</h5></div>
                            <div class="card-body">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="notification_email" name="notification_email" checked>
                                    <label class="form-check-label" for="notification_email"><strong>إشعارات البريد الإلكتروني</strong></label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="notification_push" name="notification_push" checked>
                                    <label class="form-check-label" for="notification_push"><strong>الإشعارات الفورية</strong></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="appearance" role="tabpanel">
                        <div class="card">
                            <div class="card-header"><h5 class="mb-0"><i class="bi bi-palette me-2"></i>المظهر</h5></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6"><div class="card text-center p-3" onclick="selectTheme('light')"><i class="bi bi-sun fs-1 text-warning"></i><p class="mt-2 mb-0">فاتح</p></div></div>
                                    <div class="col-md-6"><div class="card text-center p-3" onclick="selectTheme('dark')"><i class="bi bi-moon-stars fs-1"></i><p class="mt-2 mb-0">داكن</p></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="language" role="tabpanel">
                        <div class="card">
                            <div class="card-header"><h5 class="mb-0"><i class="bi bi-translate me-2"></i>اللغة</h5></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6"><div class="card text-center p-3"><div class="fs-1">🇾🇪</div><strong>العربية</strong></div></div>
                                    <div class="col-md-6"><div class="card text-center p-3"><div class="fs-1">🇺🇸</div><strong>English</strong></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <div class="card">
                            <div class="card-header"><h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>الأمان</h5></div>
                            <div class="card-body">
                                <div class="mb-3"><label class="form-label">كلمة المرور الحالية</label><input type="password" class="form-control" name="current_password"></div>
                                <div class="mb-3"><label class="form-label">كلمة المرور الجديدة</label><input type="password" class="form-control" name="new_password"></div>
                                <div class="mb-3"><label class="form-label">تأكيد كلمة المرور</label><input type="password" class="form-control" name="new_password_confirmation"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4"><button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-circle me-2"></i>حفظ الإعدادات</button></div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\سنة ثالثة ترم ثاني\العملي\لارافل عملي\dari-laravel\resources\views/user-settings.blade.php ENDPATH**/ ?>