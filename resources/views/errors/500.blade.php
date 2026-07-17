<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ في الخادم - داري</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        .error-container {
            text-align: center;
            color: #fff;
        }
        .error-code {
            font-size: 8rem;
            font-weight: bold;
            text-shadow: 4px 4px 0 rgba(0,0,0,0.1);
            margin-bottom: 0;
        }
        .error-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: shake 0.5s ease-in-out infinite;
        }
        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }
        .error-message {
            font-size: 1.5rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        .btn-home {
            background: #fff;
            color: #e74c3c;
            padding: 12px 40px;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s;
            margin: 0 10px;
        }
        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        <h1 class="error-code">500</h1>
        <p class="error-message">عذراً، حدث خطأ في الخادم. نعمل على إصلاحه.</p>
        <a href="{{ url('/dashboard') }}" class="btn-home">
            <i class="bi bi-house-door me-2"></i>العودة للرئيسية
        </a>
        <a href="javascript:location.reload()" class="btn-home">
            <i class="bi bi-arrow-clockwise me-2"></i>إعادة المحاولة
        </a>
    </div>
</body>
</html>
