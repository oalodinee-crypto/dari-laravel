<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $unit->building->name }} - {{ $unit->unit_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .card { border: none; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .unit-header { background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; border-radius: 20px 20px 0 0; padding: 30px; text-align: center; }
        .feature-badge { background: #f1f5f9; padding: 8px 15px; border-radius: 20px; margin: 5px; display: inline-block; }
        .gallery img { width: 100%; height: 150px; object-fit: cover; border-radius: 10px; cursor: pointer; transition: transform 0.3s; }
        .gallery img:hover { transform: scale(1.05); }
        .action-btn { padding: 15px 25px; border-radius: 12px; font-size: 1.1rem; }
    </style>
</head>
<body class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div class="card mb-4">
                    <div class="unit-header">
                        <h1 class="mb-2"><i class="bi bi-building me-2"></i>{{ $unit->building->name }}</h1>
                        <h3 class="mb-0">الوحدة {{ $unit->unit_number }}</h3>
                        <p class="mb-0 mt-2 opacity-75">
                            <i class="bi bi-geo-alt"></i> الطابق {{ $unit->floor_number }}
                        </p>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Unit Info -->
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3 text-center">
                                <div class="p-3 bg-light rounded-3">
                                    <i class="bi bi-arrows-fullscreen fs-3 text-primary"></i>
                                    <p class="mb-0 mt-2 fw-bold">{{ $unit->area }} م²</p>
                                    <small class="text-muted">المساحة</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 text-center">
                                <div class="p-3 bg-light rounded-3">
                                    <i class="bi bi-door-open fs-3 text-primary"></i>
                                    <p class="mb-0 mt-2 fw-bold">{{ $unit->bedrooms }}</p>
                                    <small class="text-muted">غرف نوم</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 text-center">
                                <div class="p-3 bg-light rounded-3">
                                    <i class="bi bi-droplet fs-3 text-primary"></i>
                                    <p class="mb-0 mt-2 fw-bold">{{ $unit->bathrooms }}</p>
                                    <small class="text-muted">حمامات</small>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 text-center">
                                <div class="p-3 bg-light rounded-3">
                                    <i class="bi bi-house fs-3 text-primary"></i>
                                    <p class="mb-0 mt-2 fw-bold">{{ $unit->type }}</p>
                                    <small class="text-muted">النوع</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        @if($unit->features && count($unit->features) > 0)
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="bi bi-stars me-2"></i>المميزات</h5>
                            <div>
                                @foreach($unit->features as $feature)
                                    <span class="feature-badge"><i class="bi bi-check-circle text-success me-1"></i>{{ $feature }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Gallery -->
                        @if($unit->images && count($unit->images) > 0)
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="bi bi-images me-2"></i>معرض الصور</h5>
                            <div class="row g-2 gallery">
                                @foreach($unit->images as $image)
                                    <div class="col-4">
                                        <img src="{{ asset('storage/' . $image) }}" alt="صورة الوحدة" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage('{{ asset('storage/' . $image) }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Status -->
                        <div class="mb-4">
                            <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>حالة الوحدة</h5>
                            @if($unit->status == 'occupied')
                                <span class="badge bg-success fs-6 p-2"><i class="bi bi-check-circle me-1"></i>مؤجرة</span>
                            @elseif($unit->status == 'available')
                                <span class="badge bg-primary fs-6 p-2"><i class="bi bi-house me-1"></i>متاحة للإيجار</span>
                            @else
                                <span class="badge bg-warning fs-6 p-2"><i class="bi bi-tools me-1"></i>تحت الصيانة</span>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <a href="{{ route('units.maintenance-form', $unit) }}" class="btn btn-primary action-btn">
                                <i class="bi bi-tools me-2"></i>طلب صيانة
                            </a>
                            <a href="tel:+966500000000" class="btn btn-outline-secondary action-btn">
                                <i class="bi bi-telephone me-2"></i>اتصل بالإدارة
                            </a>
                        </div>
                    </div>
                </div>
                
                <p class="text-center text-white opacity-75">
                    <i class="bi bi-shield-check me-1"></i> نظام داري لإدارة العقارات
                </p>
            </div>
        </div>
    </div>
    
    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <img id="modalImage" src="" class="img-fluid rounded-3">
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>
</body>
</html>
