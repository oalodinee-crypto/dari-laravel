@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">طلبات الوحدات</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>مقدم الطلب</th>
                        <th>نوع الوحدة</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->user->name ?? '-' }}</td>
                        <td>{{ $request->unit_type }}</td>
                        <td>
                            @if($request->status == 'pending')
                                <span class="badge bg-warning">قيد الانتظار</span>
                            @elseif($request->status == 'approved')
                                <span class="badge bg-success">مقبول</span>
                            @else
                                <span class="badge bg-danger">مرفوض</span>
                            @endif
                        </td>
                        <td>{{ $request->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($request->status == 'pending')
                                <form action="{{ route('manager.unit-requests.approve', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">قبول</button>
                                </form>
                                <form action="{{ route('manager.unit-requests.reject', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">رفض</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">لا توجد طلبات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
