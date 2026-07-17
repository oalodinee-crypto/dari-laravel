@extends('layouts.app')

@section('title', 'نتائج البحث')

@section('content')
@php
    // تهيئة المصفوفة بقيم افتراضية لمنع الأخطاء
    $results = array_merge([
        'buildings' => collect(),
        'units' => collect(),
        'users' => collect(),
        'contracts' => collect(),
        'invoices' => collect(),
        'payments' => collect(),
        'maintenance' => collect(),
        'complaints' => collect(),
        'announcements' => collect(),
    ], $results ?? []);
@endphp

<div class="container-fluid">
    <!-- Search Header -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 flex-wrap mb-3">
                <h4 class="mb-0">
                    <i class="bi bi-search me-2"></i>
                    نتائج البحث
                </h4>
                @if($query)
                    <span class="badge bg-primary fs-6">"{{ $query }}"</span>
                @endif
            </div>
            
            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="ابحث هنا بالعربي أو الإنجليزي..." value="{{ $query }}" id="searchInput">
                            <button type="button" class="btn btn-outline-primary" onclick="startVoiceSearchPage()" title="البحث الصوتي">
                                <i class="bi bi-mic-fill" id="micIconPage"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="filter" class="form-select form-select-lg">
                            <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>الكل</option>
                            @if(auth()->user()->hasRole('Admin'))
                                <option value="buildings" {{ $filter == 'buildings' ? 'selected' : '' }}>المباني</option>
                                <option value="units" {{ $filter == 'units' ? 'selected' : '' }}>الوحدات</option>
                                <option value="users" {{ $filter == 'users' ? 'selected' : '' }}>المستخدمين</option>
                                <option value="contracts" {{ $filter == 'contracts' ? 'selected' : '' }}>العقود</option>
                                <option value="invoices" {{ $filter == 'invoices' ? 'selected' : '' }}>الفواتير</option>
                                <option value="payments" {{ $filter == 'payments' ? 'selected' : '' }}>المدفوعات</option>
                                <option value="maintenance" {{ $filter == 'maintenance' ? 'selected' : '' }}>الصيانة</option>
                                <option value="complaints" {{ $filter == 'complaints' ? 'selected' : '' }}>الشكاوى</option>
                            @elseif(auth()->user()->hasRole('Manager'))
                                <option value="buildings" {{ $filter == 'buildings' ? 'selected' : '' }}>مبانيي</option>
                                <option value="units" {{ $filter == 'units' ? 'selected' : '' }}>وحداتي</option>
                                <option value="contracts" {{ $filter == 'contracts' ? 'selected' : '' }}>العقود</option>
                                <option value="invoices" {{ $filter == 'invoices' ? 'selected' : '' }}>الفواتير</option>
                                <option value="maintenance" {{ $filter == 'maintenance' ? 'selected' : '' }}>الصيانة</option>
                                <option value="complaints" {{ $filter == 'complaints' ? 'selected' : '' }}>الشكاوى</option>
                            @else
                                <option value="invoices" {{ $filter == 'invoices' ? 'selected' : '' }}>فواتيري</option>
                                <option value="payments" {{ $filter == 'payments' ? 'selected' : '' }}>مدفوعاتي</option>
                                <option value="maintenance" {{ $filter == 'maintenance' ? 'selected' : '' }}>طلبات الصيانة</option>
                                <option value="complaints" {{ $filter == 'complaints' ? 'selected' : '' }}>شكاواي</option>
                                <option value="announcements" {{ $filter == 'announcements' ? 'selected' : '' }}>الإعلانات</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    @php
        $totalResults = 0;
        foreach($results as $category => $items) {
            if($items instanceof \Illuminate\Support\Collection) {
                $totalResults += $items->count();
            }
        }
    @endphp
    
    @if($query && $totalResults == 0)
        <!-- No Results -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <h4>لا توجد نتائج</h4>
                <p class="text-muted">لم نعثر على أي نتائج تطابق "{{ $query }}"</p>
                <p class="text-muted">جرب كلمات مختلفة أو تحقق من الإملاء</p>
            </div>
        </div>
    @elseif($query)
        <!-- Results Summary -->
        <div class="alert alert-info mb-4">
            <i class="bi bi-info-circle me-2"></i>
            تم العثور على <strong>{{ $totalResults }}</strong> نتيجة للبحث عن "{{ $query }}"
        </div>
        
        <!-- Buildings Results -->
        @if($results['buildings']->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-building me-2"></i>المباني ({{ $results['buildings']->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>الكود</th>
                                <th>الاسم</th>
                                <th>المدينة</th>
                                <th>الحالة</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['buildings'] as $building)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $building->code ?? '-' }}</span></td>
                                <td>{{ $building->name ?? '-' }}</td>
                                <td>{{ $building->city ?? '-' }}</td>
                                <td>
                                    @if(($building->status ?? '') == 'active')
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-warning">{{ $building->status ?? '-' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('buildings.show', $building) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Units Results -->
        @if($results['units']->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-door-open me-2"></i>الوحدات ({{ $results['units']->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الوحدة</th>
                                <th>المبنى</th>
                                <th>الحالة</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['units'] as $unit)
                            <tr>
                                <td><strong>{{ $unit->unit_number ?? '-' }}</strong></td>
                                <td>{{ $unit->building->name ?? '-' }}</td>
                                <td>
                                    @if(($unit->status ?? '') == 'available')
                                        <span class="badge bg-success">متاحة</span>
                                    @elseif(($unit->status ?? '') == 'occupied')
                                        <span class="badge bg-info">مؤجرة</span>
                                    @else
                                        <span class="badge bg-warning">{{ $unit->status ?? '-' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('units.show', $unit) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Users Results -->
        @if($results['users']->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i>المستخدمين ({{ $results['users']->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الهاتف</th>
                                <th>الحالة</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['users'] as $user)
                            <tr>
                                <td>{{ $user->name ?? '-' }}</td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    @if($user->is_active ?? false)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-danger">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Contracts Results -->
        @if($results['contracts']->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>العقود ({{ $results['contracts']->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>رقم العقد</th>
                                <th>المستأجر</th>
                                <th>تاريخ البداية</th>
                                <th>تاريخ النهاية</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['contracts'] as $contract)
                            <tr>
                                <td><strong>{{ $contract->contract_number ?? '-' }}</strong></td>
                                <td>{{ $contract->tenant->name ?? '-' }}</td>
                                <td>{{ $contract->start_date ?? '-' }}</td>
                                <td>{{ $contract->end_date ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('contracts.show', $contract) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Invoices Results -->
        @if($results['invoices']->count() > 0)
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>الفواتير ({{ $results['invoices']->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['invoices'] as $invoice)
                            <tr>
                                <td><strong>{{ $invoice->invoice_number ?? '-' }}</strong></td>
                                <td>{{ number_format($invoice->amount ?? 0, 2) }} ر.س</td>
                                <td>
                                    @if(($invoice->status ?? '') == 'paid')
                                        <span class="badge bg-success">مدفوعة</span>
                                    @elseif(($invoice->status ?? '') == 'pending')
                                        <span class="badge bg-warning">معلقة</span>
                                    @else
                                        <span class="badge bg-danger">{{ $invoice->status ?? '-' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Payments Results -->
        @if($results['payments']->count() > 0)
        <div class="card mb-4">
            <div class="card-header" style="background: #28a745; color: white;">
                <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>المدفوعات ({{ $results['payments']->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>المبلغ</th>
                                <th>التاريخ</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['payments'] as $payment)
                            <tr>
                                <td><strong>{{ $payment->id }}</strong></td>
                                <td>{{ number_format($payment->amount ?? 0, 2) }} ر.س</td>
                                <td>{{ $payment->created_at ? $payment->created_at->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Maintenance Results -->
        @if($results['maintenance']->count() > 0)
        <div class="card mb-4">
            <div class="card-header" style="background: #6f42c1; color: white;">
                <h5 class="mb-0"><i class="bi bi-tools me-2"></i>طلبات الصيانة ({{ $results['maintenance']->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['maintenance'] as $maintenance)
                            <tr>
                                <td><strong>{{ $maintenance->id }}</strong></td>
                                <td>{{ $maintenance->status ?? '-' }}</td>
                                <td>{{ $maintenance->created_at ? $maintenance->created_at->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <a href="{{ route('maintenance.show', $maintenance) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Complaints Results -->
        @if($results['complaints']->count() > 0)
        <div class="card mb-4">
            <div class="card-header" style="background: #e83e8c; color: white;">
                <h5 class="mb-0"><i class="bi bi-chat-dots me-2"></i>الشكاوى ({{ $results['complaints']->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['complaints'] as $complaint)
                            <tr>
                                <td><strong>{{ $complaint->id }}</strong></td>
                                <td>{{ $complaint->status ?? '-' }}</td>
                                <td>{{ $complaint->created_at ? $complaint->created_at->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Announcements Results -->
        @if($results['announcements']->count() > 0)
        <div class="card mb-4">
            <div class="card-header" style="background: #20c997; color: white;">
                <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>الإعلانات ({{ $results['announcements']->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>العنوان</th>
                                <th>التاريخ</th>
                                <th>الإجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results['announcements'] as $announcement)
                            <tr>
                                <td>{{ $announcement->title ?? '-' }}</td>
                                <td>{{ $announcement->created_at ? $announcement->created_at->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <a href="{{ route('announcements.show', $announcement) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
    @else
        <!-- Welcome Search -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-search display-1 text-primary mb-3"></i>
                <h4>ابحث في النظام</h4>
                <p class="text-muted">اكتب كلمة البحث أعلاه للبحث في المباني، الوحدات، المستخدمين، والمزيد...</p>
                <div class="mt-4">
                    <span class="badge bg-light text-dark p-2 me-2">
                        <i class="bi bi-mic me-1"></i> البحث الصوتي متاح
                    </span>
                    <span class="badge bg-light text-dark p-2">
                        <i class="bi bi-translate me-1"></i> يدعم العربي والإنجليزي
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function startVoiceSearchPage() {
    const micIcon = document.getElementById('micIconPage');
    const searchInput = document.getElementById('searchInput');
    
    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = new SpeechRecognition();
        
        recognition.lang = 'ar-SA';
        recognition.continuous = false;
        recognition.interimResults = false;
        
        micIcon.className = 'bi bi-mic-fill text-danger';
        recognition.start();
        
        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            searchInput.value = transcript;
            micIcon.className = 'bi bi-mic-fill';
            
            if(typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'تم التعرف على الصوت',
                    text: transcript,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    searchInput.closest('form').submit();
                });
            } else {
                searchInput.closest('form').submit();
            }
        };
        
        recognition.onend = function() {
            micIcon.className = 'bi bi-mic-fill';
        };
        
        recognition.onerror = function(event) {
            micIcon.className = 'bi bi-mic-fill';
            let errorMessage = 'حدث خطأ في التعرف على الصوت';
            if (event.error === 'no-speech') {
                errorMessage = 'لم يتم اكتشاف صوت، حاول مرة أخرى';
            } else if (event.error === 'not-allowed') {
                errorMessage = 'يرجى السماح بالوصول للميكروفون';
            }
            if(typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'error', title: 'خطأ', text: errorMessage });
            } else {
                alert(errorMessage);
            }
        };
    } else {
        alert('المتصفح لا يدعم البحث الصوتي');
    }
}
</script>
@endpush