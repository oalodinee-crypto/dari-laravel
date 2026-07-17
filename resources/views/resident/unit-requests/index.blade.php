@extends('layouts.app')

@section('title', 'طلباتي')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>طلباتي</h5>
            <a href="{{ route('resident.request-unit') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>طلب جديد</a>
        </div>
        <div class="card-body">
            @if($requests->isEmpty())
                <div class="text-center py-5 text-muted">لا توجد طلبات</div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>#</th><th>النوع</th><th>الحالة</th><th>التاريخ</th><th>إجراءات</th></tr></thead>
                        <tbody>
                            @foreach($requests as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->unit_type }}</td>
                                <td>
                                    @if($req->status == 'pending')
                                        <span class="badge bg-warning">قيد المراجعة</span>
                                    @elseif($req->status == 'approved')
                                        <span class="badge bg-success">مقبول</span>
                                    @else
                                        <span class="badge bg-danger">مرفوض</span>
                                    @endif
                                </td>
                                <td>{{ $req->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('resident.my-requests.show', $req) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                    @if($req->status == 'pending')
                                        <form action="{{ route('resident.my-requests.destroy', $req) }}" method="POST" class="d-inline" id="formDelete{{ $req->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="Swal.fire({title:'تأكيد الحذف',text:'هل تريد إلغاء هذا الطلب؟',icon:'warning',showCancelButton:true,confirmButtonColor:'#d33',cancelButtonColor:'#3085d6',confirmButtonText:'نعم، إلغاء',cancelButtonText:'تراجع'}).then((result)=>{if(result.isConfirmed){document.getElementById('formDelete{{ $req->id }}').submit();}})"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
