@extends('layout')
@section('title', 'الوحدات المباعة')

@section('styles')
<style>
.filter-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.07); padding:1.25rem 1.5rem; margin-bottom:1.5rem; }
.prop-table-wrap { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }
.prop-table { width:100%; border-collapse:collapse; font-size:.87rem; }
.prop-table thead { background:#7f1d1d; color:#fff; }
.prop-table thead th { padding:.85rem .8rem; font-weight:600; white-space:nowrap; }
.prop-table tbody tr { border-bottom:1px solid #f1f5f9; transition:background .15s; }
.prop-table tbody tr:hover { background:#fff7f7; }
.prop-table tbody td { padding:.75rem .8rem; vertical-align:middle; }
.badge-direct  { background:#dcfce7; color:#16a34a; padding:3px 10px; border-radius:20px; font-size:.78rem; font-weight:700; }
.badge-broker  { background:#fef9c3; color:#b45309; padding:3px 10px; border-radius:20px; font-size:.78rem; font-weight:700; }
.btn-sm-action { padding:5px 12px; border-radius:8px; font-size:.78rem; font-weight:600; border:none; cursor:pointer; transition:all .15s; text-decoration:none; display:inline-flex; align-items:center; gap:4px; }
.btn-view  { background:#eff6ff; color:#2563eb; }
.btn-avail { background:#f0fdf4; color:#16a34a; }
.btn-del   { background:#fef2f2; color:#dc2626; }
.btn-view:hover  { background:#2563eb; color:#fff; }
.btn-avail:hover { background:#16a34a; color:#fff; }
.btn-del:hover   { background:#dc2626; color:#fff; }
.empty-state { padding:4rem 2rem; text-align:center; color:#94a3b8; }
.page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; flex-wrap:wrap; gap:.75rem; }
.page-title { font-size:1.4rem; font-weight:800; color:#0f172a; margin:0; }
.stats-bar { display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:1.25rem; }
.stat-chip { background:#fff; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,.06); padding:.5rem 1.1rem; font-size:.85rem; font-weight:700; color:#374151; display:flex; align-items:center; gap:.4rem; }
.stat-chip .num { color:#dc2626; font-size:1.1rem; }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">💰 الوحدات المباعة</h1>
    <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary btn-sm">🏢 الوحدات المتاحة</a>
</div>

<div class="stats-bar">
    <div class="stat-chip">📋 إجمالي المباع: <span class="num">{{ $properties->total() }}</span></div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Filters --}}
<div class="filter-card">
    <form method="GET" action="{{ route('properties.sold') }}">
        <div class="row g-3">
            {{-- الصف الأساسي --}}
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1" style="font-size:.8rem">📍 المنطقة</label>
                <input type="text" name="region" class="form-control form-control-sm" placeholder="المنطقة..." value="{{ request('region') }}">
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1" style="font-size:.8rem">🏠 نوع الوحدة</label>
                <select name="unit_type" class="form-select form-select-sm">
                    <option value="">الكل</option>
                @foreach(['منزل' , 'شقة' , 'فيلا' , 'دوبلكس' , 'برج' , 'محل' , 'مكتب' , 'أرض' , 'مخزن', 'عماره' ] as $t)
                    <option value="{{ $t }}" {{ request('unit_type')==$t?'selected':'' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1" style="font-size:.8rem">✨ التشطيب</label>
                <select name="finishing_status" class="form-select form-select-sm">
                    <option value="">الكل</option>
                    @foreach(['3/4 تشطيب', 'ارض', 'تشطيب الترا سوبرلوكس', 'تشطيب سوبر لوكس', 'تشطيب لوكس', 'تشطيب وعضم', 'عضم', 'فيه تشطيب وفيه عضم', 'متشطبه تشطيب قدم', 'نصف تشطيب'] as $f)
                    <option value="{{ $f }}" {{ request('finishing_status')==$f?'selected':'' }}>{{ $f }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1" style="font-size:.8rem">👤 العميل</label>
                <input type="text" name="client_name" class="form-control form-control-sm" placeholder="اسم العميل..." value="{{ request('client_name') }}">
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1" style="font-size:.8rem">📞 الهاتف</label>
                <input type="text" name="client_phone" class="form-control form-control-sm" placeholder="رقم الهاتف..." value="{{ request('client_phone') }}">
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1" style="font-size:.8rem">🏷️ الحالة</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">الكل</option>
                    <option value="مباشر" {{ request('status')=='مباشر'?'selected':'' }}>مباشر</option>
                    <option value="بروكر" {{ request('status')=='بروكر'?'selected':'' }}>بروكر</option>
                </select>
            </div>

            {{-- قسم البحث المتقدم --}}
            <div class="col-12">
                <button class="btn btn-sm btn-link text-decoration-none fw-bold p-0 text-danger" type="button" onclick="toggleAdvancedFilters()" style="font-size:.75rem">
                    ⚙️ بحث متقدم ...
                </button>
            </div>

            <div class="col-12 {{ request()->hasAny(['neighborhood','address','project_name','rooms_count','bathrooms_count','floor','price_per_sqm','unit_details','required_action','unit_purpose','min_price','max_price','min_area','max_area']) ? '' : 'd-none' }}" id="advancedFilters">
                <div class="row g-2 pt-2">
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">🏘️ الحي</label>
                        <input type="text" name="neighborhood" class="form-control form-control-sm" placeholder="الحي..." value="{{ request('neighborhood') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">📍 العنوان بالتفصيل</label>
                        <input type="text" name="address" class="form-control form-control-sm" placeholder="العنوان..." value="{{ request('address') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">🏢 المشروع</label>
                        <input type="text" name="project_name" class="form-control form-control-sm" placeholder="اسم المشروع..." value="{{ request('project_name') }}">
                    </div>
                    <div class="col-12 col-md-1">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">🛌 الغرف</label>
                        <input type="text" name="rooms_count" class="form-control form-control-sm" placeholder="غرف" value="{{ request('rooms_count') }}">
                    </div>
                    <div class="col-12 col-md-1">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">🚿 حمام</label>
                        <input type="text" name="bathrooms_count" class="form-control form-control-sm" placeholder="حمام" value="{{ request('bathrooms_count') }}">
                    </div>
                    <div class="col-12 col-md-1">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">🔝 الطابق</label>
                        <input type="text" name="floor" class="form-control form-control-sm" placeholder="طابق" value="{{ request('floor') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">💰 سعر المتر</label>
                        <input type="text" name="price_per_sqm" class="form-control form-control-sm" placeholder="سعر المتر" value="{{ request('price_per_sqm') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">🎯 الهدف</label>
                        <select name="unit_purpose" class="form-select form-select-sm">
                            <option value="">الكل</option>
                            @foreach(['سكن','إيجار','استثمار','تجاري'] as $p)
                            <option value="{{ $p }}" {{ request('unit_purpose')==$p?'selected':'' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">📝 التفاصيل</label>
                        <input type="text" name="unit_details" class="form-control form-control-sm" placeholder="تفاصيل الوحدة..." value="{{ request('unit_details') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">⚡ الإجراء المطلوب</label>
                        <input type="text" name="required_action" class="form-control form-control-sm" placeholder="الإجراء..." value="{{ request('required_action') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">💵 السعر (من)</label>
                        <input type="number" name="min_price" class="form-control form-control-sm" placeholder="الأدنى" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">💵 السعر (إلى)</label>
                        <input type="number" name="max_price" class="form-control form-control-sm" placeholder="الأقصى" value="{{ request('max_price') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">📏 المساحة (من)</label>
                        <input type="number" name="min_area" class="form-control form-control-sm" placeholder="الأصغر" value="{{ request('min_area') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-semibold mb-1" style="font-size:.75rem">📏 المساحة (إلى)</label>
                        <input type="number" name="max_area" class="form-control form-control-sm" placeholder="الأكبر" value="{{ request('max_area') }}">
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex gap-2 justify-content-end mt-2">
                <button type="submit" class="btn btn-danger btn-sm px-5 fw-bold">🔍 بحث</button>
                <a href="{{ route('properties.sold') }}" class="btn btn-outline-secondary btn-sm px-4">✖ مسح الفلاتر</a>
            </div>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="prop-table-wrap">
    @if($properties->isEmpty())
        <div class="empty-state">
            <p class="fw-semibold fs-5">لا توجد وحدات مباعة</p>
        </div>
    @else
    <div style="overflow-x:auto">
    <table class="prop-table">
        <thead>
            <tr>
                <th>#</th>
                <th>المنطقة / الحي</th>
                <th>نوع الوحدة</th>
                <th>المشروع</th>
                <th>المساحة</th>
                <th>إجمالي السعر</th>
                <th>العميل</th>
                <th>الحالة</th>
                <th>الهدف</th>
                <th>آخر إجراء</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($properties as $p)
            <tr>
                <td class="text-muted" style="font-size:.78rem">{{ $p->id }}</td>
                <td>
                    <div class="fw-semibold">{{ $p->region ?? '—' }}</div>
                    @if($p->neighborhood)<small class="text-muted">{{ $p->neighborhood }}</small>@endif
                </td>
                <td>{{ $p->unit_type ?? '—' }}</td>
                <td>{{ $p->project_name ?? '—' }}</td>
                <td>{{ $p->area_sqm ? number_format($p->area_sqm).' م²' : '—' }}</td>
                <td class="fw-bold">
                    <div class="text-success">{{ $p->final_sale_price ? 'EGP '.number_format($p->final_sale_price) : '—' }}</div>
                    <small class="text-muted" style="text-decoration:line-through; font-size:.7rem">{{ $p->total_price ? number_format($p->total_price) : '' }}</small>
                </td>
                <td>
                    <div>{{ $p->client_name ?? '—' }}</div>
                    @if($p->client_phone)<small class="text-muted">{{ $p->client_phone }}</small>@endif
                </td>
                <td>
                    <span class="{{ $p->status=='مباشر' ? 'badge-direct' : 'badge-broker' }}">{{ $p->status }}</span>
                </td>
                <td>{{ $p->unit_purpose ?? '—' }}</td>
                <td>
                    @if($p->latestLog)
                        <div style="font-size:.78rem; max-width:150px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis" title="{{ $p->latestLog->note }}">
                            {{ $p->latestLog->note }}
                        </div>
                        <small class="text-muted" style="font-size:.7rem">{{ $p->latestLog->created_at->format('m/d H:i') }}</small>
                    @else
                        <span class="text-muted small">لا يوجد</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-1 flex-wrap">
                        <a href="{{ route('properties.show', $p->id) }}" class="btn-sm-action btn-view">👁</a>
                        <form action="{{ route('properties.markAsAvailable', $p->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-sm-action btn-avail" onclick="return confirm('إعادة إلى المتاح؟')">↩️</button>
                        </form>
                        <form action="{{ route('properties.destroy', $p->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-sm-action btn-del" onclick="return confirm('حذف هذه الوحدة نهائياً؟')">🗑</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="p-3">
        {{ $properties->links() }}
    </div>
    @endif
</div>
@section('scripts')
<script>
function toggleAdvancedFilters() {
    const el = document.getElementById('advancedFilters');
    if (el.classList.contains('d-none')) {
        el.classList.remove('d-none');
    } else {
        el.classList.add('d-none');
    }
}
</script>
@endsection
