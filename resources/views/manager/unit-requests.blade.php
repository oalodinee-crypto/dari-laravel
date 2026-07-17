@extends('layouts.app')

@section('title', 'طلبات الوحدات')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-house-add me-2"></i>
            طلبات الوحدات من السكان
        </h4>
    </div>

    <div class="card">
        <div class="card-body">
            @if($requests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="requestsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الساكن</th>
                                <th>نوع الوحدة</th>
                                <th>عدد الغرف</th>
                                <th>الميزانية</th>
                                <th>تاريخ الطلب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->user->name ?? 'غير معروف' }}</td>
                                    <td>{{ $request->unit_type }}</td>
                                    <td>{{ $request->rooms_count ?? '-' }}</td>
                                    <td>
                                        @if($request->budget_min || $request->budget_max)
                                            {{ number_format($request->budget_min ?? 0) }} - {{ number_format($request->budget_max ?? 0) }} ر.س
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $request->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if($request->status == 'pending')
                                            <span class="badge bg-warning">قيد الانتظار</span>
                                        @elseif($request->status == 'approved')
                                            <span class="badge bg-success">مقبول</span>
                                        @elseif($request->status == 'rejected')
                                            <span class="badge bg-danger">مرفوض</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if($request->status == 'pending')
                                                <form action="{{ route('manager.unit-requests.approve', $request->id) }}" method="POST" class="d-inline" id="approveForm{{ $request->id }}">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-success" title="قبول"
                                                        onclick="Swal.fire({
                                                            title: 'تأكيد القبول',
                                                            text: 'هل تريد قبول هذا الطلب؟',
                                                            icon: 'question',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'نعم، قبول',
                                                            cancelButtonText: 'إلغاء',
                                                            confirmButtonColor: '#28a745'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) document.getElementById('approveForm{{ $request->id }}').submit();
                                                        })">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('manager.unit-requests.reject', $request->id) }}" method="POST" class="d-inline" id="rejectForm{{ $request->id }}">
                                                    @csrf
                                                    <button type="button" class="btn btn-sm btn-danger" title="رفض"
                                                        onclick="Swal.fire({
                                                            title: 'تأكيد الرفض',
                                                            text: 'هل تريد رفض هذا الطلب؟',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'نعم، رفض',
                                                            cancelButtonText: 'إلغاء',
                                                            confirmButtonColor: '#dc3545'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) document.getElementById('rejectForm{{ $request->id }}').submit();
                                                        })">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3">لا توجد طلبات حالياً</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#requestsTable').DataTable({
            language: {
                "sProcessing": "جارٍ التحميل...",
                "sLengthMenu": "أظهر _MENU_ مدخلات",
                "sZeroRecords": "لم يُعثر على أية سجلات",
                "sEmptyTable": "لا توجد بيانات متاحة في الجدول",
                "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sSearch": "بحث:",
                "sInfoThousands": ",",
                "sLoadingRecords": "جارٍ التحميل...",
                "oPaginate": {
                    "sFirst": "الأول",
                    "sPrevious": "السابق",
                    "sNext": "التالي",
                    "sLast": "الأخير"
                },
                "oAria": {
                    "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                    "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                }
            },
            order: [[0, 'desc']]
        });
    });
</script>
@endpush
@endsection