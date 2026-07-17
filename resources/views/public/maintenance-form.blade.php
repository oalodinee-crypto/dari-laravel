<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب صيانة - {{ $unit->unit_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .form-control, .form-select { border-radius: 10px; padding: 12px 15px; }
        .btn-submit { padding: 15px; border-radius: 12px; font-size: 1.1rem; }
    </style>
</head>
<body class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                
                <div class="card">
                    <div class="card-header bg-primary text-white text-center py-4" style="border-radius: 20px 20px 0 0;">
                        <h3 class="mb-1"><i class="bi bi-tools me-2"></i>طلب صيانة</h3>
                        <p class="mb-0 opacity-75">{{ $unit->building->name }} - {{ $unit->unit_number }}</p>
                    </div>
                    
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('units.submit-maintenance', $unit) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-tag me-1"></i>عنوان المشكلة
                                </label>
                                <input type="text" name="title" class="form-control" 
                                       placeholder="مثال: تسرب مياه في الحمام" 
                                       value="{{ old('title') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-exclamation-triangle me-1"></i>الأولوية
                                </label>
                                <select name="priority" class="form-select" required>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>منخفضة - يمكن الانتظار</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>متوسطة - خلال أيام</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>عاجلة - تحتاج تدخل سريع</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-chat-text me-1"></i>وصف المشكلة
                                </label>
                                <textarea name="description" class="form-control" rows="4" 
                                          placeholder="اشرح المشكلة بالتفصيل..." required>{{ old('description') }}</textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-telephone me-1"></i>رقم الجوال للتواصل
                                </label>
                                <input type="tel" name="contact_phone" class="form-control" 
                                       placeholder="05xxxxxxxx" 
                                       value="{{ old('contact_phone') }}" required>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-submit">
                                    <i class="bi bi-send me-2"></i>إرسال الطلب
                                </button>
                                <a href="{{ route('units.public', $unit) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-right me-2"></i>رجوع
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <p class="text-center text-white opacity-75 mt-4">
                    <i class="bi bi-shield-check me-1"></i> نظام داري لإدارة العقارات
                </p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
