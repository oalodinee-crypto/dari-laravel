<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Tahoma', sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; }
        .header { background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .amount { font-size: 2rem; color: #4f46e5; font-weight: bold; text-align: center; margin: 20px 0; }
        .info-box { background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .btn { display: inline-block; background: #4f46e5; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; }
        .footer { background: #f8fafc; padding: 20px; text-align: center; color: #666; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>نظام داري</h1>
            <p>تذكير بموعد الدفع</p>
        </div>
        
        <div class="content">
            <p>مرحباً {{ $user->name }}،</p>
            
            <p>نود تذكيرك بأن لديك فاتورة مستحقة الدفع:</p>
            
            <div class="amount">{{ number_format($invoice->amount, 2) }} ر.س</div>
            
            <div class="info-box">
                <p><strong>رقم الفاتورة:</strong> #{{ $invoice->id }}</p>
                <p><strong>تاريخ الاستحقاق:</strong> {{ $invoice->due_date->format('Y-m-d') }}</p>
                <p><strong>الوصف:</strong> {{ $invoice->description ?? 'إيجار شهري' }}</p>
            </div>
            
            <p style="text-align: center;">
                <a href="{{ url('/dashboard') }}" class="btn">الدخول للنظام</a>
            </p>
            
            <p>شكراً لتعاونكم.</p>
        </div>
        
        <div class="footer">
            <p>هذا البريد آلي من نظام داري لإدارة العقارات</p>
        </div>
    </div>
</body>
</html>
