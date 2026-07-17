@extends('layouts.app')

@section('title', 'تقديم شكوى')
@section('page-title', 'تقديم شكوى جديدة')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">
                    <i class="bi bi-plus-circle text-primary me-2"></i>
                    تقديم شكوى / مقترح
                </h2>
                <a href="{{ route('complaints.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-right me-1"></i>
                    العودة
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('complaints.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">النوع <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" name="type" required>
                                    <option value="complaint" {{ old('type') == 'complaint' ? 'selected' : '' }}>شكوى</option>
                                    <option value="suggestion" {{ old('type') == 'suggestion' ? 'selected' : '' }}>مقترح</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">الأولوية <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" name="priority" required>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>متوسطة</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">العنوان <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">التفاصيل <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>
                                إرسال
                            </button>
                            <a href="{{ route('complaints.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6><i class="bi bi-lightbulb text-warning me-2"></i>نصائح</h6>
                    <ul class="mb-0 small">
                        <li class="mb-2">اكتب عنواناً واضحاً ومختصراً</li>
                        <li class="mb-2">اشرح المشكلة بالتفصيل</li>
                        <li class="mb-2">حدد الأولوية بدقة</li>
                        <li>سيتم الرد عليك في أقرب وقت</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
