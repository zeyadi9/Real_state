@extends('layout')
@section('title', 'الوحدات المتاحة')

@section('styles')
<style>
.filter-card { background:#fff; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,.08); padding:1.75rem 2rem; margin-bottom:2rem; }
.prop-table-wrap { background:#fff; border-radius:18px; box-shadow:0 4px 20px rgba(0,0,0,.08); overflow:hidden; }
.prop-table { width:100%; border-collapse:collapse; font-size:1.05rem; } /* تكبير خط الجدول */
.prop-table thead { background:#0f172a; color:#fff; }
.prop-table thead th { padding:1.2rem 1rem; font-weight:700; white-space:nowrap; font-size:1.1rem; }
.prop-table tbody tr { border-bottom:1px solid #f1f5f9; transition:background .15s; }
.prop-table tbody tr:hover { background:#f8fafc; }
.prop-table tbody td { padding:1rem; vertical-align:middle; }
.badge-direct  { background:#dcfce7; color:#16a34a; padding:5px 12px; border-radius:20px; font-size:0.95rem; font-weight:700; }
.badge-broker  { background:#fef9c3; color:#b45309; padding:5px 12px; border-radius:20px; font-size:0.95rem; font-weight:700; }
.badge-finish  { background:#e0f2fe; color:#0369a1; padding:5px 12px; border-radius:20px; font-size:0.95rem; font-weight:700; }
.btn-sm-action { padding:7px 15px; border-radius:10px; font-size:1rem; font-weight:600; border:none; cursor:pointer; transition:all .15s; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
.btn-view  { background:#eff6ff; color:#2563eb; }
.btn-edit  { background:#f0fdf4; color:#16a34a; }
.btn-sell  { background:#fef9c3; color:#b45309; }
.btn-del   { background:#fef2f2; color:#dc2626; }
.btn-view:hover  { background:#2563eb; color:#fff; }
.btn-edit:hover  { background:#16a34a; color:#fff; }
.btn-sell:hover  { background:#f59e0b; color:#fff; }
.btn-del:hover   { background:#dc2626; color:#fff; }
.empty-state { padding:4rem 2rem; text-align:center; color:#94a3b8; }
.empty-state svg { width:64px; height:64px; margin-bottom:1rem; opacity:.4; }
.page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; flex-wrap:wrap; gap:1rem; }
.page-title { font-size:2.2rem; font-weight:800; color:#0f172a; margin:0; }
.btn-primary-add { background:#2563eb; color:#fff; padding:.8rem 1.6rem; border-radius:12px; font-weight:700; font-size:1.1rem; text-decoration:none; display:inline-flex; align-items:center; gap:.6rem; transition:background .2s; }
.btn-primary-add:hover { background:#1d4ed8; color:#fff; }
.stats-bar { display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:1.25rem; }
.stat-chip { background:#fff; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,.08); padding:.75rem 1.5rem; font-size:1.1rem; font-weight:700; color:#374151; display:flex; align-items:center; gap:.6rem; }
.stat-chip .num { color:#2563eb; font-size:1.4rem; }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">🏢 الوحدات المتاحة</h1>
    <div class="d-flex gap-2">
        @if(auth()->user()->isSuperAdmin())
        <button type="button" class="btn btn-outline-success btn-sm fw-bold px-3 d-inline-flex align-items-center" style="border-radius:10px" data-bs-toggle="modal" data-bs-target="#importModal">📥 استيراد Excel</button>
        @endif
        @if(auth()->user()->isStaff())
        <a href="{{ route('properties.export') }}" class="btn btn-success btn-sm fw-bold px-3 d-inline-flex align-items-center" style="border-radius:10px">📗 تصدير Excel</a>
        @endif
        <a href="{{ route('properties.create') }}" class="btn-primary-add">➕ إضافة وحدة</a>
    </div>
</div>

{{-- Import Modal --}}
@if(auth()->user()->isStaff())
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;">
            <form action="{{ route('properties.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">📥 استيراد بيانات من إكسيل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-muted small mb-4">يرجى التأكد من أن رؤوس الأعمدة في ملف الإكسيل تتوافق مع النظام.</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">اختر الملف (.xlsx, .xls)</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success fw-bold px-4">بدء الاستيراد ⚡</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- Stats --}}
<div class="stats-bar">
    <div class="stat-chip">📋 إجمالي الوحدات: <span class="num">{{ $properties->total() }}</span></div>
</div>

{{-- Flash --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Filters --}}
<div class="filter-card">
    <form method="GET" action="{{ route('properties.index') }}">
        <div class="row g-3">
            {{-- الصف الأساسي --}}
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1">📍 المنطقة</label>
                <input type="text" name="region" class="form-control" placeholder="المنطقة..." value="{{ request('region') }}">
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1">🏠 نوع الوحدة</label>
                <select name="unit_type" class="form-select">
                    <option value="">الكل</option>
                @foreach(['منزل' , 'شقة' , 'فيلا' , 'دوبلكس' , 'برج' , 'محل' , 'مكتب' , 'أرض' , 'مخزن', 'عماره' ] as $t)
                    <option value="{{ $t }}" {{ request('unit_type')==$t?'selected':'' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1">✨ التشطيب</label>
                <select name="finishing_status" class="form-select">
                    <option value="">الكل</option>
                    @foreach(['3/4 تشطيب', 'ارض', 'تشطيب الترا سوبرلوكس', 'تشطيب سوبر لوكس', 'تشطيب لوكس', 'تشطيب وعضم', 'عضم', 'فيه تشطيب وفيه عضم', 'متشطبه تشطيب قدم', 'نصف تشطيب'] as $f)
                    <option value="{{ $f }}" {{ request('finishing_status')==$f?'selected':'' }}>{{ $f }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1">👤 العميل</label>
                <input type="text" name="client_name" class="form-control" placeholder="اسم العميل..." value="{{ request('client_name') }}">
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1">📞 الهاتف</label>
                <input type="text" name="client_phone" class="form-control" placeholder="رقم الهاتف..." value="{{ request('client_phone') }}">
            </div>
            <div class="col-12 col-md-2">
                <label class="form-label fw-bold mb-1">🏷️ الحالة</label>
                <select name="status" class="form-select">
                    <option value="">الكل</option>
                    <option value="مباشر" {{ request('status')=='مباشر'?'selected':'' }}>مباشر</option>
                    <option value="بروكر" {{ request('status')=='بروكر'?'selected':'' }}>بروكر</option>
                </select>
            </div>

            {{-- قسم البحث المتقدم --}}
            <div class="col-12">
                <button class="btn btn-sm btn-outline-secondary fw-bold py-1 px-3" type="button" onclick="toggleAdvancedFilters()">
                    ⚙️ بحث متقدم ...
                </button>
            </div>

            <div class="col-12 {{ request()->hasAny(['neighborhood','address','project_name','rooms_count','bathrooms_count','floor','price_per_sqm','unit_details','required_action','unit_purpose','min_price','max_price','min_area','max_area']) ? '' : 'd-none' }}" id="advancedFilters">
                <div class="row g-3 pt-2">
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-bold mb-1">🏘️ الحي</label>
                        <input type="text" name="neighborhood" class="form-control" placeholder="الحي..." value="{{ request('neighborhood') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-bold mb-1">📍 العنوان بالتفصيل</label>
                        <input type="text" name="address" class="form-control" placeholder="العنوان..." value="{{ request('address') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-bold mb-1">🏢 المشروع</label>
                        <input type="text" name="project_name" class="form-control" placeholder="اسم المشروع..." value="{{ request('project_name') }}">
                    </div>
                    <div class="col-12 col-md-1">
                        <label class="form-label fw-bold mb-1">🛌 الغرف</label>
                        <input type="text" name="rooms_count" class="form-control" placeholder="غرف" value="{{ request('rooms_count') }}">
                    </div>
                    <div class="col-12 col-md-1">
                        <label class="form-label fw-bold mb-1">🚿 حمام</label>
                        <input type="text" name="bathrooms_count" class="form-control" placeholder="حمام" value="{{ request('bathrooms_count') }}">
                    </div>
                    <div class="col-12 col-md-1">
                        <label class="form-label fw-bold mb-1">🔝 الطابق</label>
                        <input type="text" name="floor" class="form-control" placeholder="طابق" value="{{ request('floor') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-bold mb-1">💰 سعر المتر</label>
                        <input type="text" name="price_per_sqm" class="form-control" placeholder="سعر المتر" value="{{ request('price_per_sqm') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-bold mb-1">🎯 الهدف</label>
                        <select name="unit_purpose" class="form-select">
                            <option value="">الكل</option>
                            @foreach(['سكن','إيجار','استثمار','تجاري'] as $p)
                            <option value="{{ $p }}" {{ request('unit_purpose')==$p?'selected':'' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-bold mb-1">📝 التفاصيل</label>
                        <input type="text" name="unit_details" class="form-control" placeholder="تفاصيل الوحدة..." value="{{ request('unit_details') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-bold mb-1">⚡ الإجراء المطلوب</label>
                        <input type="text" name="required_action" class="form-control" placeholder="الإجراء..." value="{{ request('required_action') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-bold mb-1">💵 السعر (من)</label>
                        <input type="number" name="min_price" class="form-control" placeholder="الأدنى" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-bold mb-1">💵 السعر (إلى)</label>
                        <input type="number" name="max_price" class="form-control" placeholder="الأقصى" value="{{ request('max_price') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-bold mb-1">📏 المساحة (من)</label>
                        <input type="number" name="min_area" class="form-control" placeholder="الأصغر" value="{{ request('min_area') }}">
                    </div>
                    <div class="col-12 col-md-2">
                        <label class="form-label fw-bold mb-1">📏 المساحة (إلى)</label>
                        <input type="number" name="max_area" class="form-control" placeholder="الأكبر" value="{{ request('max_area') }}">
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex gap-2 justify-content-end mt-2">
                <button type="submit" class="btn btn-primary px-5 fw-bold">🔍 بحث</button>
                <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary px-4">✖ مسح الفلاتر</a>
            </div>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="prop-table-wrap">
    @if($properties->isEmpty())
        <div class="empty-state">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <p class="fw-semibold fs-5">لا توجد وحدات متاحة</p>
            <a href="{{ route('properties.create') }}" class="btn btn-primary mt-2">➕ أضف أول وحدة</a>
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
                <th>التشطيب</th>
                <th>الغرف</th>
                <th>الطابق</th>
                <th>سعر المتر</th>
                <th>إجمالي السعر</th>
                <th>العميل</th>
                <th>الموظف</th>
                <th>التاريخ</th>
                <th>آخر إجراء</th>
                <th>البائع</th>
                <th>الحالة</th>
                <th>الهدف</th>
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
                <td>{{ $p->area_sqm ? (is_numeric($p->area_sqm) ? number_format($p->area_sqm).' م²' : $p->area_sqm) : '—' }}</td>
                <td><span class="badge-finish">{{ $p->finishing_status ?? '—' }}</span></td>
                <td>{{ $p->rooms_count ?? '—' }}</td>
                <td>{{ $p->floor ?? '—' }}</td>
                <td>{{ $p->price_per_sqm ? (is_numeric($p->price_per_sqm) ? 'EGP '.number_format($p->price_per_sqm) : $p->price_per_sqm) : '—' }}</td>
                <td class="fw-bold">{{ $p->total_price ? (is_numeric($p->total_price) ? 'EGP '.number_format($p->total_price) : $p->total_price) : '—' }}</td>
                <td>
                    <div>{{ $p->client_name ?? '—' }}</div>
                    @if($p->client_phone)<small class="text-muted">{{ $p->client_phone }}</small>@endif
                </td>
                {{-- الموظف --}}
                <td><small class="fw-semibold">{{ $p->creator->name ?? '—' }}</small></td>
                {{-- التاريخ --}}
                <td><small class="text-muted">{{ $p->created_at->format('Y-m-d') }}</small></td>
                {{-- آخر إجراء --}}
                <td>
                    @if($p->latestLog)
                        <div style="font-size:.78rem; font-weight:600">{{ $p->latestLog->user_name }}</div>
                        <div style="font-size:.7rem; color:#64748b" title="{{ $p->latestLog->note }}">{{ Str::limit($p->latestLog->note, 20) }}</div>
                    @else
                        <span class="text-muted small">—</span>
                    @endif
                </td>
                {{-- البائع --}}
                <td><small class="fw-semibold text-success">{{ $p->seller->name ?? '—' }}</small></td>
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
                        <a href="{{ route('properties.show', $p->id) }}" class="btn-sm-action btn-view" title="عرض التفاصيل">👁</a>
                        
                        @if($p->media && count($p->media))
                        <button type="button" class="btn-sm-action photo-btn" style="background:#fef3c7; color:#d97706" 
                            data-type="{{ $p->unit_type ?? 'وحدة' }}"
                            data-urls="{{ json_encode(array_map(fn($path) => Storage::url($path), $p->media)) }}"
                            onclick="showPhotosModal(this)" title="عرض الصور">
                            📸
                        </button>
                        @endif

                        @if(auth()->user()->isStaff())
                        <a href="{{ route('properties.edit', $p->id) }}" class="btn-sm-action btn-edit">✏️</a>
                        @endif
                        <button type="button" class="btn-sm-action btn-sell sell-modal-trigger"
                            data-id="{{ $p->id }}"
                            data-title="{{ $p->unit_type ?? 'وحدة' }} #{{ $p->id }}"
                            data-price="{{ $p->total_price ?? 0 }}"
                            data-deposit="{{ $p->deposit ?? 0 }}"
                            data-remaining="{{ $p->remaining ?? 0 }}"
                            onclick="openSellModal(this)">
                            💰
                        </button>
                        @if(auth()->user()->isStaff())
                        <form action="{{ route('properties.destroy', $p->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-sm-action btn-del" onclick="return confirm('حذف هذه الوحدة نهائياً؟')">🗑</button>
                        </form>
                        @endif
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
@endsection

@section('scripts')
{{-- Sell Modal --}}
<div class="modal fade" id="sellModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; border:none; box-shadow:0 10px 30px rgba(0,0,0,0.2)">
            <form id="sellForm" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="sellModalTitle">💰 إتمام عملية البيع</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-muted mb-3" id="sellModalSubTitle"></p>
                    <div id="depositInfo" class="alert alert-info py-2 mb-3" style="font-size: .85rem; display: none;">
                        ℹ️ تم دفع مقدم: <strong id="modalDepositVal"></strong> EGP
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">السعر النهائي للبيع (المتبقي)</label>
                        <input type="number" name="final_sale_price" id="final_sale_price" class="form-control form-control-lg" required step="0.01" min="0">
                        <div class="form-text mt-2">القيمة الافتراضية هي المتبقي بعد خصم المقدم.</div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success px-5 fw-bold">تأكيد البيع ✅</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Photos Modal --}}
<div class="modal fade" id="photosModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="photosModalTitle">📸 صور الوحدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="photosContainer" class="d-flex flex-wrap gap-2 justify-content-center">
                    {{-- Images injected here --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleAdvancedFilters() {
    const el = document.getElementById('advancedFilters');
    if (el.classList.contains('d-none')) {
        el.classList.remove('d-none');
    } else {
        el.classList.add('d-none');
    }
}

function showPhotosModal(btn) {
    const title = btn.getAttribute('data-type');
    const images = JSON.parse(btn.getAttribute('data-urls'));
    const modal = new bootstrap.Modal(document.getElementById('photosModal'));
    document.getElementById('photosModalTitle').innerText = '📸 صور: ' + title;
    const container = document.getElementById('photosContainer');
    container.innerHTML = '';
    
    images.forEach(src => {
        const div = document.createElement('div');
        div.className = 'photo-item';
        if (src.toLowerCase().match(/\.(mp4|mov|avi)$/)) {
            div.innerHTML = `<video src="${src}" controls style="width:220px; height:160px; object-fit:cover; border-radius:8px; border:1px solid #ddd"></video>`;
        } else {
            div.innerHTML = `<img src="${src}" style="width:220px; height:160px; object-fit:cover; border-radius:8px; border:1px solid #ddd; cursor:pointer" onclick="window.open('${src}')">`;
        }
        container.appendChild(div);
    });
    
    modal.show();
}

function openSellModal(btn) {
    const id = btn.getAttribute('data-id');
    const title = btn.getAttribute('data-title');
    const totalPrice = btn.getAttribute('data-price');
    const deposit = btn.getAttribute('data-deposit');
    const remaining = btn.getAttribute('data-remaining');

    const modal = new bootstrap.Modal(document.getElementById('sellModal'));
    document.getElementById('sellModalSubTitle').innerText = 'تأكيد بيع: ' + title + ' (السعر الكلي: ' + totalPrice + ')';
    
    const depInfo = document.getElementById('depositInfo');
    if (deposit != 0 && deposit != '') {
        depInfo.style.display = 'block';
        document.getElementById('modalDepositVal').innerText = deposit;
        document.getElementById('final_sale_price').value = remaining;
    } else {
        depInfo.style.display = 'none';
        document.getElementById('final_sale_price').value = totalPrice;
    }
    
    document.getElementById('sellForm').action = '/properties/' + id + '/sell';
    modal.show();
}
</script>
@endsection
