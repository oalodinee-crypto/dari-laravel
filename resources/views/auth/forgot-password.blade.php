<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ app()->getLocale() == 'ar' ? 'نسيت كلمة المرور' : 'Forgot Password' }} - {{ config('app.name', 'DARI') }}</title>
    @if(app()->getLocale() == 'ar')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3D4F5F;
            --secondary-color: #C4A574;
        }
        body { 
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
        }

        .card { border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); 
            border: none; 
            padding: 12px; 
        }
        .btn-primary:hover { 
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color)); 
            transform: translateY(-2px);
        }
        .form-control { padding: 12px 15px; border-radius: 10px; }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(61,79,95,0.25); border-color: var(--primary-color); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-key-fill text-primary fs-1"></i>
                            </div>
                            <h4 class="fw-bold">{{ app()->getLocale() == 'ar' ? 'نسيت كلمة المرور؟' : 'Forgot Password?' }}</h4>
                            <p class="text-muted">{{ app()->getLocale() == 'ar' ? 'أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين' : 'Enter your email and we will send you a reset link' }}</p>
                        </div>

                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label">{{ __('messages.email') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-send me-2"></i>{{ app()->getLocale() == 'ar' ? 'إرسال رابط إعادة التعيين' : 'Send Reset Link' }}
                            </button>
                        </form>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="bi bi-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} me-1"></i>{{ app()->getLocale() == 'ar' ? 'العودة لتسجيل الدخول' : 'Back to Login' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
