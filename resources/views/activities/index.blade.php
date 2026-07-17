@extends('layouts.app')
@section('title', 'سجل النشاطات')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4"><i class="bi bi-clock-history me-2"></i>سجل النشاطات</h1>
    <div class="card">
        <div class="card-body">
            @if($activities->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>النشاط</th><th>المستخدم</th><th>التاريخ</th></tr></thead>
                    <tbody>
                        @foreach($activities as $activity)
                        <tr>
                            <td>
                                <strong>{{ $activity->description }}</strong>
                                @if($activity->properties && count($activity->properties) > 0)
                                    <div class="mt-1 small text-muted">
                                        @if(isset($activity->properties['old']) || isset($activity->properties['new']))
                                            {{-- Update Event --}}
                                            <span class="d-block text-danger">القديم: {{ Str::limit(json_encode($activity->properties['old'], JSON_UNESCAPED_UNICODE), 50) }}</span>
                                            <span class="d-block text-success">الجديد: {{ Str::limit(json_encode($activity->properties['new'], JSON_UNESCAPED_UNICODE), 50) }}</span>
                                        @else
                                            {{-- Create/Delete Event --}}
                                            <pre class="mb-0" style="font-size: 0.75rem;">{{ Str::limit(json_encode($activity->properties, JSON_UNESCAPED_UNICODE), 100) }}</pre>
                                        @endif
                                    </div>
                                @endif
                                <div class="small text-secondary mt-1">
                                    <span class="badge bg-light text-dark border">{{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}</span>
                                    <span class="ms-2"><i class="bi bi-person me-1"></i>{{ $activity->ip_address }}</span>
                                </div>
                            </td>
                            <td>{{ $activity->user->name ?? 'System' }}</td>
                            <td>{{ $activity->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $activities->links() }}
            @else
            <p class="text-muted text-center py-4">لا توجد نشاطات</p>
            @endif
        </div>
    </div>
</div>
@endsection
