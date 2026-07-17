<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('messages.register')); ?> - <?php echo e(config('app.name', 'DARI')); ?></title>
    <?php if(app()->getLocale() == 'ar'): ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <?php else: ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #3D4F5F;
            --secondary-color: #C4A574;
            --accent-color: #B8956E;
            --bg-light: #f5f5f5;
            --text-dark: #1b263b;
            --card-light: #ffffff;
            --border-light: #d0d7de;
        }
        * { transition: all 0.3s ease; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 50%, var(--accent-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px 20px;
        }

        .auth-container {
            background: var(--card-light);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 35px;
            width: 100%;
            max-width: 580px;
        }
        .logo-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-section img {
            width: 70px;
            height: 70px;
            border-radius: 14px;
            object-fit: contain;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            margin-bottom: 10px;
            background: white;
            padding: 6px;
        }
        .logo-section h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 3px;
        }
        .logo-section p {
            color: var(--text-dark);
            opacity: 0.7;
            font-size: 0.9rem;
        }
        .form-control, .form-select {
            background: var(--bg-light);
            border: 2px solid var(--border-light);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 0.95rem;
            color: var(--text-dark);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(26,95,122,0.1);
        }
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
            font-size: 0.9rem;
        }
        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.95rem;
            margin: 20px 0 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid var(--border-light);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1.05rem;
            font-weight: 600;
            width: 100%;
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26,95,122,0.4);
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 18px 0;
            color: var(--text-dark);
            opacity: 0.5;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-light);
        }
        .divider span { padding: 0 12px; font-size: 0.85rem; }
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .social-btn {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            border: 2px solid var(--border-light);
            background: var(--bg-light);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .social-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        .auth-footer {
            text-align: center;
            margin-top: 20px;
            color: var(--text-dark);
        }
        .auth-footer a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer a:hover { text-decoration: underline; }
        .form-check-label { color: var(--text-dark); font-size: 0.85rem; }
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .required-star { color: #dc3545; }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            <?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?>: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            cursor: pointer;
        }
        .input-icon .form-control {
            <?php echo e(app()->getLocale() == 'ar' ? 'padding-left' : 'padding-right'); ?>: 40px;
        }
        .profile-upload {
            text-align: center;
            margin-bottom: 15px;
        }
        .profile-upload-box {
            width: 80px;
            height: 80px;
            border: 2px dashed var(--border-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            cursor: pointer;
            transition: all 0.3s;
            background: var(--bg-light);
            overflow: hidden;
        }
        .profile-upload-box:hover { border-color: var(--primary-color); }
        .profile-upload-box i { font-size: 1.5rem; color: #6c757d; }
        .profile-upload-box img { width: 100%; height: 100%; object-fit: cover; }
        .profile-upload small { color: #6c757d; font-size: 0.8rem; }
        a { color: var(--primary-color); text-decoration: none; }
        a:hover { text-decoration: underline; }
        .invalid-feedback { display: block; color: #dc3545; font-size: 0.85rem; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo-section">
            <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="DARI">
            <h1><?php echo e(app()->getLocale() == 'ar' ? 'داري' : 'DARI'); ?></h1>
            <p><?php echo e(app()->getLocale() == 'ar' ? 'نظام إدارة المباني السكنية' : 'Building Management System'); ?></p>
        </div>

        <div class="social-login">
            <button type="button" class="social-btn google" title="Google">
                <svg width="22" height="22" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            </button>
            <button type="button" class="social-btn facebook" title="Facebook">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </button>
        </div>

        <div class="divider"><span><?php echo e(app()->getLocale() == 'ar' ? 'أو أنشئ حساباً جديداً' : 'or create a new account'); ?></span></div>

        <form method="POST" action="<?php echo e(route('register')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <!-- Profile Picture -->
            <div class="profile-upload">
                <label for="profilePic">
                    <div class="profile-upload-box" id="profilePreview">
                        <i class="bi bi-camera"></i>
                    </div>
                </label>
                <input type="file" id="profilePic" name="avatar" accept="image/*" hidden onchange="previewImage(this)">
                <small><?php echo e(app()->getLocale() == 'ar' ? 'الصورة الشخصية (اختياري)' : 'Profile Picture (optional)'); ?></small>
            </div>

            <!-- Basic Info -->
            <h6 class="section-title"><i class="bi bi-person me-2"></i><?php echo e(app()->getLocale() == 'ar' ? 'المعلومات الأساسية' : 'Basic Information'); ?></h6>
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(__('messages.name')); ?> <span class="required-star">*</span></label>
                    <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(app()->getLocale() == 'ar' ? 'اسم المستخدم' : 'Username'); ?> <span class="required-star">*</span></label>
                    <input type="text" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="username" value="<?php echo e(old('username')); ?>" required>
                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(__('messages.email')); ?> <span class="required-star">*</span></label>
                    <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(__('messages.phone')); ?> <span class="required-star">*</span></label>
                    <input type="tel" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone" value="<?php echo e(old('phone')); ?>" required>
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Location -->
            <h6 class="section-title"><i class="bi bi-geo-alt me-2"></i><?php echo e(app()->getLocale() == 'ar' ? 'الموقع' : 'Location'); ?></h6>
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(app()->getLocale() == 'ar' ? 'الدولة' : 'Country'); ?> <span class="required-star">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="country" id="countrySelect" required onchange="updateGovernorate()">
                        <option value="">-- اختر الدولة --</option>
                        <option value="YE" <?php echo e(old('country') == 'YE' ? 'selected' : ''); ?>>اليمن</option>
                        <option value="SA" <?php echo e(old('country') == 'SA' ? 'selected' : ''); ?>>السعودية</option>
                        <option value="AE" <?php echo e(old('country') == 'AE' ? 'selected' : ''); ?>>الإمارات</option>
                        <option value="KW" <?php echo e(old('country') == 'KW' ? 'selected' : ''); ?>>الكويت</option>
                        <option value="QA" <?php echo e(old('country') == 'QA' ? 'selected' : ''); ?>>قطر</option>
                        <option value="BH" <?php echo e(old('country') == 'BH' ? 'selected' : ''); ?>>البحرين</option>
                        <option value="OM" <?php echo e(old('country') == 'OM' ? 'selected' : ''); ?>>عُمان</option>
                        <option value="EG" <?php echo e(old('country') == 'EG' ? 'selected' : ''); ?>>مصر</option>
                        <option value="JO" <?php echo e(old('country') == 'JO' ? 'selected' : ''); ?>>الأردن</option>
                        <option value="LB" <?php echo e(old('country') == 'LB' ? 'selected' : ''); ?>>لبنان</option>
                        <option value="SY" <?php echo e(old('country') == 'SY' ? 'selected' : ''); ?>>سوريا</option>
                        <option value="IQ" <?php echo e(old('country') == 'IQ' ? 'selected' : ''); ?>>العراق</option>
                        <option value="PS" <?php echo e(old('country') == 'PS' ? 'selected' : ''); ?>>فلسطين</option>
                        <option value="SD" <?php echo e(old('country') == 'SD' ? 'selected' : ''); ?>>السودان</option>
                        <option value="LY" <?php echo e(old('country') == 'LY' ? 'selected' : ''); ?>>ليبيا</option>
                        <option value="TN" <?php echo e(old('country') == 'TN' ? 'selected' : ''); ?>>تونس</option>
                        <option value="DZ" <?php echo e(old('country') == 'DZ' ? 'selected' : ''); ?>>الجزائر</option>
                        <option value="MA" <?php echo e(old('country') == 'MA' ? 'selected' : ''); ?>>المغرب</option>
                        <option value="MR" <?php echo e(old('country') == 'MR' ? 'selected' : ''); ?>>موريتانيا</option>
                        <option value="SO" <?php echo e(old('country') == 'SO' ? 'selected' : ''); ?>>الصومال</option>
                        <option value="DJ" <?php echo e(old('country') == 'DJ' ? 'selected' : ''); ?>>جيبوتي</option>
                        <option value="KM" <?php echo e(old('country') == 'KM' ? 'selected' : ''); ?>>جزر القمر</option>
                    </select>
                    <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(app()->getLocale() == 'ar' ? 'المحافظة' : 'Governorate'); ?> <span class="required-star">*</span></label>
                    <select class="form-select <?php $__errorArgs = ['governorate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="governorate" id="governorateSelect" required disabled>
                        <option value="">-- اختر الدولة أولاً --</option>
                    </select>
                    <?php $__errorArgs = ['governorate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Password -->
            <h6 class="section-title"><i class="bi bi-lock me-2"></i><?php echo e(__('messages.password')); ?></h6>
            
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(__('messages.password')); ?> <span class="required-star">*</span></label>
                    <div class="input-icon">
                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" required>
                        <i class="bi bi-eye" onclick="togglePassword('password', this)"></i>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(__('messages.confirm_password')); ?> <span class="required-star">*</span></label>
                    <div class="input-icon">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        <i class="bi bi-eye" onclick="togglePassword('password_confirmation', this)"></i>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <h6 class="section-title"><i class="bi bi-info-circle me-2"></i><?php echo e(app()->getLocale() == 'ar' ? 'معلومات إضافية' : 'Additional Information'); ?></h6>
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(app()->getLocale() == 'ar' ? 'تاريخ الميلاد' : 'Date of Birth'); ?></label>
                    <input type="date" class="form-control" name="birthdate" value="<?php echo e(old('birthdate')); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><?php echo e(app()->getLocale() == 'ar' ? 'الجنس' : 'Gender'); ?></label>
                    <select class="form-select" name="gender">
                        <option value=""><?php echo e(app()->getLocale() == 'ar' ? 'اختر الجنس' : 'Select Gender'); ?></option>
                        <option value="male" <?php echo e(old('gender') == 'male' ? 'selected' : ''); ?>><?php echo e(app()->getLocale() == 'ar' ? 'ذكر' : 'Male'); ?></option>
                        <option value="female" <?php echo e(old('gender') == 'female' ? 'selected' : ''); ?>><?php echo e(app()->getLocale() == 'ar' ? 'أنثى' : 'Female'); ?></option>
                    </select>
                </div>
            </div>

            <!-- Terms -->
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                <label class="form-check-label" for="terms">
                    <?php echo e(app()->getLocale() == 'ar' ? 'أوافق على' : 'I agree to'); ?> <a href="#"><?php echo e(app()->getLocale() == 'ar' ? 'الشروط والأحكام' : 'Terms and Conditions'); ?></a> <?php echo e(app()->getLocale() == 'ar' ? 'و' : 'and'); ?> <a href="#"><?php echo e(app()->getLocale() == 'ar' ? 'سياسة الخصوصية' : 'Privacy Policy'); ?></a> <span class="required-star">*</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-2"></i><?php echo e(__('messages.register')); ?>

            </button>
        </form>

        <div class="auth-footer">
            <?php echo e(app()->getLocale() == 'ar' ? 'لديك حساب بالفعل؟' : 'Already have an account?'); ?> <a href="<?php echo e(route('login')); ?>"><?php echo e(__('messages.login')); ?></a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // المحافظات تبقى بالعربي دائماً
        const governorates = {
            'YE': ['صنعاء', 'عدن', 'تعز', 'الحديدة', 'إب', 'ذمار', 'حضرموت', 'المكلا', 'عمران', 'صعدة', 'مأرب', 'البيضاء', 'لحج', 'أبين', 'شبوة', 'المهرة', 'سقطرى', 'ريمة', 'الجوف', 'حجة', 'الضالع'],
            'SA': ['الرياض', 'جدة', 'مكة المكرمة', 'المدينة المنورة', 'الدمام', 'الخبر', 'الظهران', 'الأحساء', 'الطائف', 'تبوك', 'بريدة', 'خميس مشيط', 'أبها', 'نجران', 'جازان', 'ينبع', 'حائل', 'الجبيل', 'القطيف', 'عرعر'],
            'AE': ['دبي', 'أبوظبي', 'الشارقة', 'عجمان', 'رأس الخيمة', 'الفجيرة', 'أم القيوين', 'العين'],
            'KW': ['مدينة الكويت', 'حولي', 'الفروانية', 'الأحمدي', 'الجهراء', 'مبارك الكبير'],
            'QA': ['الدوحة', 'الوكرة', 'الخور', 'الريان', 'أم صلال', 'الشمال', 'الضعاين'],
            'BH': ['المنامة', 'المحرق', 'الرفاع', 'مدينة عيسى', 'مدينة حمد', 'سترة', 'جدحفص'],
            'OM': ['مسقط', 'صلالة', 'صحار', 'نزوى', 'صور', 'البريمي', 'عبري', 'بهلاء', 'الرستاق', 'إبراء'],
            'EG': ['القاهرة', 'الإسكندرية', 'الجيزة', 'شرم الشيخ', 'الأقصر', 'أسوان', 'بورسعيد', 'السويس', 'المنصورة', 'طنطا', 'الزقازيق', 'أسيوط', 'سوهاج', 'المنيا', 'دمياط'],
            'JO': ['عمّان', 'إربد', 'الزرقاء', 'العقبة', 'السلط', 'المفرق', 'الكرك', 'معان', 'جرش', 'عجلون', 'مادبا', 'الطفيلة'],
            'LB': ['بيروت', 'طرابلس', 'صيدا', 'صور', 'زحلة', 'جونيه', 'بعلبك', 'النبطية', 'حلبا'],
            'SY': ['دمشق', 'حلب', 'حمص', 'اللاذقية', 'حماة', 'طرطوس', 'دير الزور', 'الرقة', 'إدلب', 'درعا', 'السويداء', 'القنيطرة'],
            'IQ': ['بغداد', 'البصرة', 'الموصل', 'أربيل', 'النجف', 'كربلاء', 'السليمانية', 'كركوك', 'الأنبار', 'ديالى', 'واسط', 'ميسان', 'ذي قار', 'المثنى', 'بابل', 'صلاح الدين', 'دهوك'],
            'PS': ['غزة', 'رام الله', 'نابلس', 'الخليل', 'بيت لحم', 'جنين', 'طولكرم', 'قلقيلية', 'أريحا', 'طوباس', 'سلفيت', 'القدس'],
            'SD': ['الخرطوم', 'أم درمان', 'بورتسودان', 'كسلا', 'الأبيض', 'ود مدني', 'القضارف', 'عطبرة', 'الفاشر', 'نيالا'],
            'LY': ['طرابلس', 'بنغازي', 'مصراتة', 'الزاوية', 'زليتن', 'البيضاء', 'طبرق', 'سبها', 'سرت', 'درنة'],
            'TN': ['تونس', 'صفاقس', 'سوسة', 'القيروان', 'بنزرت', 'قابس', 'المنستير', 'نابل', 'مدنين', 'باجة'],
            'DZ': ['الجزائر', 'وهران', 'قسنطينة', 'عنابة', 'باتنة', 'سطيف', 'تلمسان', 'بجاية', 'الشلف', 'البليدة'],
            'MA': ['الرباط', 'الدار البيضاء', 'فاس', 'مراكش', 'طنجة', 'أكادير', 'مكناس', 'وجدة', 'القنيطرة', 'تطوان'],
            'MR': ['نواكشوط', 'نواذيبو', 'كيفة', 'روصو', 'أطار', 'زويرات', 'ألاك'],
            'SO': ['مقديشو', 'هرجيسا', 'كيسمايو', 'بوصاصو', 'بيدوا', 'غالكعيو', 'بربرة'],
            'DJ': ['جيبوتي', 'تاجورة', 'علي صبيح', 'أوبوك', 'دخيل'],
            'KM': ['موروني', 'موتسامودو', 'فومبوني', 'دوموني']
        };

        function updateGovernorate() {
            const country = document.getElementById('countrySelect').value;
            const govSelect = document.getElementById('governorateSelect');
            govSelect.innerHTML = '<option value="">-- اختر المحافظة --</option>';
            
            if (governorates[country]) {
                governorates[country].forEach(gov => {
                    govSelect.innerHTML += '<option value="' + gov + '">' + gov + '</option>';
                });
                govSelect.disabled = false;
            } else {
                govSelect.disabled = true;
            }
        }

        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').innerHTML = '<img src="' + e.target.result + '" alt="Profile">';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Initialize governorate on page load
        if (document.getElementById('countrySelect').value) {
            updateGovernorate();
        }
    </script>
</body>
</html>
<?php /**PATH D:\New folder (2)\dari-laravel\resources\views/auth/register.blade.php ENDPATH**/ ?>