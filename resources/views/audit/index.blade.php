@extends('layout')
@section('title', 'سجل المراقبة')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 style="font-size:2.2rem; font-weight:800; color:#0f172a;">🔍 سجل المراقبة (Audit Log)</h1>
</div>

<div class="card border-0 shadow-sm overflow-hidden" style="border-radius:16px;">
    <div style="overflow-x:auto">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="px-4 py-4" style="font-size:1.1rem">الموظف</th>
                    <th class="py-4" style="font-size:1.1rem">العملية</th>
                    <th class="py-4" style="font-size:1.1rem">الموديول</th>
                    <th class="py-4" style="font-size:1.1rem">الهدف</th>
                    <th class="py-4" style="font-size:1.1rem">الوقت</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td class="px-4 py-3 fw-bold" style="font-size:1.1rem">{{ $log->user_name }}</td>
                    <td class="py-3">
                        <span class="badge {{ str_contains($log->action, 'Login') ? 'bg-success' : (str_contains($log->action, 'حذف') ? 'bg-danger' : 'bg-primary') }}" style="font-size:0.95rem; padding:6px 12px; border-radius:20px;">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="py-3 text-muted" style="font-size:1rem">{{ $log->module }}</td>
                    <td class="py-3" style="font-size:1rem">{{ $log->target }}</td>
                    <td class="py-3 text-muted" style="font-size:0.95rem">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $logs->links() }}
</div>
@endsection
