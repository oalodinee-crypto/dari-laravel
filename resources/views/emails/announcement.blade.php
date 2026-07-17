<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إعلان جديد</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; padding: 30px;">
        <h2 style="color: #2c3e50; margin-bottom: 20px;">{{ $announcement->title }}</h2>
        
        <p>مرحباً،</p>
        
        <p>تم نشر إعلان جديد:</p>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            {!! nl2br(e($announcement->content)) !!}
        </div>
        
        @if($announcement->expires_at)
        <p><small>صالح حتى: {{ $announcement->expires_at->format('Y-m-d') }}</small></p>
        @endif
        
        <p>شكراً لاستخدامك نظام داري.</p>
    </div>
</body>
</html>
