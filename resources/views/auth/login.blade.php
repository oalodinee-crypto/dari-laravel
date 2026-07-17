<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login') }} - {{ config('app.name', 'DARI') }}</title>
    @if(app()->getLocale() == 'ar')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
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
        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 50%, var(--accent-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        .lang-switcher {
            position: fixed;
            top: 20px;
            {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 20px;
            z-index: 1000;
        }
        .lang-dropdown {
            background: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.95rem;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .lang-dropdown:hover {
            background: #f8f9fa;
        }
        .lang-menu {
            position: absolute;
            top: 100%;
            {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            margin-top: 5px;
            min-width: 140px;
            display: none;
            overflow: hidden;
        }
        .lang-menu.show { display: block; }
        .lang-menu a {
            display: block;
            padding: 10px 16px;
            color: #333;
            text-decoration: none;
            transition: background 0.2s;
        }
        .lang-menu a:hover { background: #f0f0f0; }
        .lang-menu a.active { background: var(--primary-color); color: white; }
        .auth-container {
            background: var(--card-light);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-section img {
            width: 90px;
            height: 90px;
            border-radius: 18px;
            object-fit: contain;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            margin-bottom: 12px;
            background: white;
            padding: 8px;
        }
        .logo-section h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        .logo-section p {
            color: var(--text-dark);
            opacity: 0.7;
            font-size: 0.95rem;
        }
        .outlined-group {
            position: relative;
            margin-bottom: 25px;
        }
        .outlined-group input {
            width: 100%;
            padding: 16px 15px 16px 45px;
            font-size: 1rem;
            border: 2px solid var(--border-light);
            border-radius: 12px;
            background: transparent;
            color: var(--text-dark);
            outline: none;
            transition: border-color 0.3s;
        }
        .outlined-group input:focus {
            border-color: var(--primary-color);
        }
        .outlined-group label {
            position: absolute;
            {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            color: #6c757d;
            pointer-events: none;
            transition: all 0.25s ease;
            background: var(--card-light);
            padding: 0 8px;
        }
        .outlined-group input:focus + label,
        .outlined-group input.has-value + label {
            top: 0;
            transform: translateY(-50%);
            font-size: 0.85rem;
            color: var(--primary-color);
            font-weight: 600;
        }
        .outlined-group .input-icon {
            position: absolute;
            {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.3s;
        }
        .outlined-group input:focus ~ .input-icon {
            color: var(--primary-color);
        }
        .invalid-feedback { display: block; color: #dc3545; font-size: 0.85rem; margin-top: 5px; }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26,95,122,0.4);
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: var(--text-dark);
            opacity: 0.5;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-light);
        }
        .divider span { padding: 0 15px; font-size: 0.9rem; }
        .social-login {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .social-btn {
            width: 60px;
            height: 60px;
            border-radius: 16px;
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
            margin-top: 25px;
            color: var(--text-dark);
        }
        .auth-footer a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-footer a:hover { text-decoration: underline; }
        .form-check-label { color: var(--text-dark); font-size: 0.9rem; }
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .options-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .options-row a {
            color: var(--primary-color);
            font-size: 0.9rem;
            text-decoration: none;
        }
        .options-row a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <!-- Language Switcher -->
    <div class="lang-switcher">
        <div class="lang-dropdown" onclick="toggleLangMenu()">
            <span>{{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}</span>
            <i class="bi bi-chevron-down"></i>
        </div>
        <div class="lang-menu" id="langMenu">
            <a href="{{ url('language/ar') }}" class="{{ app()->getLocale() == 'ar' ? 'active' : '' }}">العربية</a>
            <a href="{{ url('language/en') }}" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">English</a>
        </div>
    </div>

    <div class="auth-container">
        <div class="logo-section">
            <img src="{{ asset('images/logo.jpg') }}" alt="DARI">
            <h1>{{ app()->getLocale() == 'ar' ? 'داري' : 'DARI' }}</h1>
            <p>{{ app()->getLocale() == 'ar' ? 'نظام إدارة المباني السكنية' : 'Building Management System' }}</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="outlined-group">
                <input type="text" id="email" name="email" value="{{ old('email') }}" required>
                <label for="email">{{ __('messages.email') }}</label>
                <i class="bi bi-person input-icon"></i>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="outlined-group">
                <input type="password" id="password" name="password" required>
                <label for="password">{{ __('messages.password') }}</label>
                <i class="bi bi-eye input-icon" id="togglePass" onclick="togglePassword()"></i>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="options-row">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">{{ app()->getLocale() == 'ar' ? 'تذكرني' : 'Remember me' }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">{{ app()->getLocale() == 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot password?' }}</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} me-2"></i>{{ __('messages.login') }}
            </button>
        </form>

        <div class="divider"><span>{{ app()->getLocale() == 'ar' ? 'أو' : 'or' }}</span></div>

        <div class="social-login">
            <button type="button" class="social-btn google" title="Google">
                <svg width="24" height="24" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
            </button>
            <button type="button" class="social-btn facebook" title="Facebook">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </button>
        </div>

        <div class="auth-footer">
            {{ app()->getLocale() == 'ar' ? 'ليس لديك حساب؟' : "Don't have an account?" }} <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.outlined-group input').forEach(input => {
            if (input.value.trim() !== '') input.classList.add('has-value');
            input.addEventListener('input', function() {
                this.value.trim() !== '' ? this.classList.add('has-value') : this.classList.remove('has-value');
            });
        });

        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('togglePass');
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.className = input.type === 'password' ? 'bi bi-eye input-icon' : 'bi bi-eye-slash input-icon';
        }

        function toggleLangMenu() {
            document.getElementById('langMenu').classList.toggle('show');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.lang-switcher')) {
                document.getElementById('langMenu').classList.remove('show');
            }
        });
    </script>
</body>
</html>
