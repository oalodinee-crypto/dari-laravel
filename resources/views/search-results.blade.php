@extends('layouts.app')

@section('title', 'نتائج البحث')

@section('content')
<div class="container-fluid">
    <!-- عنوان الصفحة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">
                <i class="bi bi-search me-2"></i>
                نتائج البحث
            </h4>
            <p class="text-muted mb-0">
                @if($query)
                    تم العثور على <strong>{{ $totalCount }}</strong> نتيجة لـ "<strong>{{ $query }}</strong>"
                    @if($filter !== 'all')
                        في <span class="badge bg-secondary">{{ $filter }}</span>
                    @endif
                @else
                    أدخل كلمة للبحث
                @endif
            </p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-right me-1"></i>
            العودة
        </a>
    </div>

    @if($totalCount === 0 && $query)
        <!-- لا توجد نتائج -->
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <h5>لم يتم العثور على نتائج</h5>
                <p class="text-muted">جرب البحث بكلمات مختلفة أو تغيير الفلتر</p>
            </div>
        </div>
    @else
        <div class="row">
            <!-- المباني -->
            @if(isset($results['buildings']) && $results['buildings']->count() > 0)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-building me-2"></i>
                            المباني ({{ $results['buildings']->count() }})
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم المبنى</th>
                                            <th>العنوان</th>
                                            <th>عدد الوحدات</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['buildings'] as $building)
                                            <tr>
                                                <td>{{ $building->id }}</td>
                                                <td><strong>{{ $building->name }}</strong></td>
                                                <td>{{ $building->address }}</td>
                                                <td>{{ $building->units_count ?? $building->units()->count() }}</td>
                                                <td>
                                                    <a href="{{ route('buildings.show', $building->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- الوحدات -->
            @if(isset($results['units']) && $results['units']->count() > 0)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <i class="bi bi-door-open me-2"></i>
                            الوحدات ({{ $results['units']->count() }})
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>رقم الوحدة</th>
                                            <th>النوع</th>
                                            <th>المبنى</th>
                                            <th>الحالة</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['units'] as $unit)
                                            <tr>
                                                <td>{{ $unit->id }}</td>
                                                <td><strong>{{ $unit->unit_number }}</strong></td>
                                                <td>{{ $unit->type }}</td>
                                                <td>{{ $unit->building->name ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $unit->status === 'available' ? 'success' : 'warning' }}">
                                                        {{ $unit->status === 'available' ? 'متاحة' : 'مشغولة' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('units.show', $unit->id) }}" class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- المستخدمين -->
            @if(isset($results['users']) && $results['users']->count() > 0)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <i class="bi bi-people me-2"></i>
                            المستخدمين ({{ $results['users']->count() }})
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>البريد</th>
                                            <th>الهاتف</th>
                                            <th>الدور</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['users'] as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td><strong>{{ $user->name }}</strong></td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $user->roles->first()->name ?? '-' }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- العقود -->
            @if(isset($results['contracts']) && $results['contracts']->count() > 0)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            العقود ({{ $results['contracts']->count() }})
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الوحدة</th>
                                            <th>المستأجر</th>
                                            <th>تاريخ البداية</th>
                                            <th>تاريخ النهاية</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['contracts'] as $contract)
                                            <tr>
                                                <td>{{ $contract->id }}</td>
                                                <td>{{ $contract->unit->unit_number ?? '-' }}</td>
                                                <td>{{ $contract->tenant->name ?? '-' }}</td>
                                                <td>{{ $contract->start_date }}</td>
                                                <td>{{ $contract->end_date }}</td>
                                                <td>
                                                    <a href="{{ route('contracts.show', $contract->id) }}" class="btn btn-sm btn-outline-warning">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- طلبات الصيانة -->
            @if(isset($results['maintenance']) && $results['maintenance']->count() > 0)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <i class="bi bi-tools me-2"></i>
                            طلبات الصيانة ({{ $results['maintenance']->count() }})
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>العنوان</th>
                                            <th>الوصف</th>
                                            <th>الحالة</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['maintenance'] as $request)
                                            <tr>
                                                <td>{{ $request->id }}</td>
                                                <td><strong>{{ $request->title }}</strong></td>
                                                <td>{{ Str::limit($request->description, 50) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $request->status === 'completed' ? 'success' : ($request->status === 'pending' ? 'warning' : 'info') }}">
                                                        {{ $request->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('maintenance.show', $request->id) }}" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- المدفوعات -->
            @if(isset($results['payments']) && $results['payments']->count() > 0)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header" style="background: #C4A574; color: #fff;">
                            <i class="bi bi-cash-stack me-2"></i>
                            المدفوعات ({{ $results['payments']->count() }})
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>المبلغ</th>
                                            <th>التاريخ</th>
                                            <th>الحالة</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['payments'] as $payment)
                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td><strong>{{ number_format($payment->amount) }} ر.ي</strong></td>
                                                <td>{{ $payment->payment_date ?? $payment->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <span class="badge bg-success">مدفوع</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- الفواتير -->
            @if(isset($results['invoices']) && $results['invoices']->count() > 0)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <i class="bi bi-receipt me-2"></i>
                            الفواتير ({{ $results['invoices']->count() }})
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>المبلغ</th>
                                            <th>تاريخ الاستحقاق</th>
                                            <th>الحالة</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['invoices'] as $invoice)
                                            <tr>
                                                <td>{{ $invoice->id }}</td>
                                                <td><strong>{{ number_format($invoice->amount) }} ر.ي</strong></td>
                                                <td>{{ $invoice->due_date }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : 'warning' }}">
                                                        {{ $invoice->status === 'paid' ? 'مدفوعة' : 'معلقة' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- الشكاوى -->
            @if(isset($results['complaints']) && $results['complaints']->count() > 0)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <i class="bi bi-chat-dots me-2"></i>
                            الشكاوى ({{ $results['complaints']->count() }})
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>العنوان</th>
                                            <th>الوصف</th>
                                            <th>الحالة</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($results['complaints'] as $complaint)
                                            <tr>
                                                <td>{{ $complaint->id }}</td>
                                                <td><strong>{{ $complaint->title }}</strong></td>
                                                <td>{{ Str::limit($complaint->description, 50) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $complaint->status === 'resolved' ? 'success' : 'warning' }}">
                                                        {{ $complaint->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-dark">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
