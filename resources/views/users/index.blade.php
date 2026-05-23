@extends('layout')
@section('title', 'إدارة الموظفين')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 style="font-size:1.5rem; font-weight:800; color:#0f172a;">👥 إدارة الموظفين</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-4">
    {{-- إضافة موظف جديد --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4" style="border-radius:16px;">
            <h5 class="fw-bold mb-4">➕ إضافة موظف جديد</h5>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">الاسم بالكامل</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">البريد الإلكتروني (الدخول)</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">كلمة السر</label>
                    <input type="password" name="password" class="form-control" required minlength="8">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">الصلاحية</label>
                    <select name="role" class="form-select" required>
                        <option value="user">USER</option>
                        <option value="admin">Admin</option>
                        @if(auth()->user()->isSuperAdmin())
                        <option value="super_admin">SUPER ADMIN</option>
                        @endif
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">حفظ </button>
            </form>
        </div>
    </div>

    {{-- قائمة الموظفين --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:16px;">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3">الموظف</th>
                        <th class="py-3">الرتبة</th>
                        <th class="py-3 text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="fw-bold">{{ $user->name }}</div>
                            <div class="text-muted small">{{ $user->email }}</div>
                        </td>
                        <td class="py-3">
                            @if($user->role === 'super_admin')
                                <span class="badge bg-danger">سوبر أدمن</span>
                            @elseif($user->role === 'admin')
                                <span class="badge bg-primary">أدمن</span>
                            @else
                                <span class="badge bg-secondary">يوزر</span>
                            @endif
                        </td>
                        <td class="py-3 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @if(auth()->user()->isSuperAdmin())
                                <button type="button" class="btn btn-sm btn-outline-warning fw-bold reset-btn" 
                                    data-id="{{ $user->id }}" 
                                    data-name="{{ $user->name }}"
                                    onclick="openResetModal(this)">
                                    🔑 باسورد
                                </button>
                                @endif
                                
                                @if(auth()->id() !== $user->id)
                                    @if(!$user->isSuperAdmin() || auth()->user()->isSuperAdmin())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الموظف؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger fw-bold">🗑</button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Reset Password Modal (Super Admin Only) --}}
@if(auth()->user()->isSuperAdmin())
<div class="modal fade" id="resetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;">
            <form id="resetForm" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">🔑 إعادة ضبط كلمة السر</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3" id="resetSubTitle"></p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">كلمة السر الجديدة</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning fw-bold">تغيير الآن ⚡</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openResetModal(btn) {
    const id = btn.getAttribute('data-id');
    const name = btn.getAttribute('data-name');
    const modal = new bootstrap.Modal(document.getElementById('resetModal'));
    document.getElementById('resetSubTitle').innerText = 'تغيير كلمة السر للموظف: ' + name;
    document.getElementById('resetForm').action = '/users/' + id + '/reset-password';
    modal.show();
}
</script>
@endif
@endsection
