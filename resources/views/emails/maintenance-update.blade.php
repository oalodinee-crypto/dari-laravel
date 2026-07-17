<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تحديث طلب الصيانة</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; padding: 30px;">
        <h2 style="color: #2c3e50; margin-bottom: 20px;">تحديث طلب الصيانة</h2>
        
        <p>مرحباً،</p>
        
        <p>تم تحديث حالة طلب الصيانة الخاص بك:</p>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>العنوان:</strong> {{ $maintenance->title }}</p>
            <p><strong>الحالة:</strong> {{ $maintenance->status }}</p>
            <p><strong>الأولوية:</strong> {{ $maintenance->priority }}</p>
            @if($maintenance->notes)
            <p><strong>ملاحظات:</strong> {{ $maintenance->notes }}</p>
            @endif
        </div>
        
        <p>شكراً لاستخدامك نظام داري.</p>
    </div>
</body>
</html>
