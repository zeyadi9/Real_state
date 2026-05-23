@extends('layout')
@section('title', 'تفاصيل الوحدة')

@section('styles')
<style>
.detail-card { background:#fff; border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,.08); padding:2rem; margin-bottom:1.5rem; }
.section-title { font-size:1rem; font-weight:800; color:#0f172a; margin-bottom:1.25rem; padding-bottom:.5rem; border-bottom:2px solid #e2e8f0; display:flex; align-items:center; gap:.4rem; }
.info-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:1rem; }
.info-item label { font-size:.78rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:.03em; margin-bottom:.25rem; display:block; }
.info-item .val { font-size:.95rem; font-weight:600; color:#0f172a; }
.info-item .val.empty { color:#94a3b8; font-weight:400; font-style:italic; }
.badge-direct  { background:#dcfce7; color:#16a34a; padding:4px 14px; border-radius:20px; font-size:.82rem; font-weight:700; }
.badge-broker  { background:#fef9c3; color:#b45309; padding:4px 14px; border-radius:20px; font-size:.82rem; font-weight:700; }
.badge-avail   { background:#dcfce7; color:#16a34a; padding:4px 14px; border-radius:20px; font-size:.82rem; font-weight:700; }
.badge-sold    { background:#fef2f2; color:#dc2626; padding:4px 14px; border-radius:20px; font-size:.82rem; font-weight:700; }
.media-gallery { display:flex; flex-wrap:wrap; gap:1rem; }
.media-item { border-radius:12px; overflow:hidden; border:2px solid #e2e8f0; }
.media-item img  { width:200px; height:150px; object-fit:cover; display:block; cursor:pointer; transition:transform .2s; }
.media-item img:hover { transform:scale(1.03); }
.media-item video { width:200px; height:150px; object-fit:cover; display:block; }
.action-bar { display:flex; gap:.75rem; flex-wrap:wrap; margin-bottom:1.5rem; }
.btn-action { padding:.55rem 1.25rem; border-radius:10px; font-weight:700; font-size:.9rem; border:none; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem; transition:all .15s; }
.btn-edit-main  { background:#2563eb; color:#fff; }
.btn-edit-main:hover { background:#1d4ed8; color:#fff; }
.btn-sell-main  { background:#f59e0b; color:#fff; }
.btn-sell-main:hover { background:#d97706; color:#fff; }
.btn-avail-main { background:#16a34a; color:#fff; }
.btn-avail-main:hover { background:#15803d; color:#fff; }
.btn-del-main   { background:#dc2626; color:#fff; }
.btn-del-main:hover { background:#b91c1c; color:#fff; }
.price-hero { background:linear-gradient(135deg, #0f172a 0%, #1e40af 100%); color:#fff; border-radius:16px; padding:2rem; text-align:center; margin-bottom:1.5rem; }
.price-hero .price-label { font-size:.85rem; opacity:.75; margin-bottom:.25rem; }
.price-hero .price-val { font-size:2.2rem; font-weight:900; }
.price-hero .sub-info { display:flex; justify-content:center; gap:2rem; margin-top:1rem; font-size:.9rem; opacity:.8; }

/* Lightbox */
#lightbox { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.9); z-index:9999; align-items:center; justify-content:center; }
#lightbox.open { display:flex; }
#lightbox img { max-width:90vw; max-height:90vh; border-radius:8px; }
#lightbox .close-lb { position:absolute; top:1rem; right:1rem; background:#fff; border:none; border-radius:50%; width:40px; height:40px; font-size:1.2rem; cursor:pointer; }
</style>
@endsection

@section('content')
{{-- Action Bar --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 style="font-size:1.4rem;font-weight:800;color:#0f172a;margin:0">
        🏠 {{ $property->unit_type ?? 'وحدة' }} — #{{ $property->id }}
    </h1>
    <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary btn-sm">← رجوع</a>
</div>

<div class="action-bar">
    <a href="{{ route('properties.edit', $property->id) }}" class="btn-action btn-edit-main">✏️ تعديل</a>
    @if($property->sale_status === 'متاح')
    <button type="button" class="btn-action btn-sell-main" 
        onclick="openSellModal({{ $property->id }}, '{{ addslashes($property->unit_type ?? 'وحدة') }} #{{ $property->id }}', {{ $property->total_price ?? 0 }}, {{ $property->deposit ?? 0 }}, {{ $property->remaining ?? 0 }})">
        💰 تحديد كمباع
    </button>
    @else
    <form action="{{ route('properties.markAsAvailable', $property->id) }}" method="POST" style="display:inline">
        @csrf
        <button type="submit" class="btn-action btn-avail-main" onclick="return confirm('إعادة إلى المتاح؟')">✅ إعادة للمتاح</button>
    </form>
    @endif
    <form action="{{ route('properties.destroy', $property->id) }}" method="POST" style="display:inline">
        @csrf
        <button type="submit" class="btn-action btn-del-main" onclick="return confirm('حذف هذه الوحدة نهائياً؟')">🗑 حذف</button>
    </form>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Price Hero --}}
<div class="price-hero">
    @if($property->sale_status === 'مباع' && $property->final_sale_price)
        <div class="price-label">السعر النهائي للبيع</div>
        <div class="price-val">EGP {{ number_format($property->final_sale_price) }}</div>
        <div class="sub-info">
            <span class="text-white-50">السعر الأصلي: {{ number_format($property->total_price) }} EGP</span>
        </div>
    @else
        <div class="price-label">إجمالي سعر الوحدة</div>
        <div class="price-val">EGP {{ number_format($property->total_price) }}</div>
        <div class="sub-info">
            @if($property->deposit)
                <span class="text-info fw-bold">المقدم: {{ number_format($property->deposit) }} EGP</span>
                <span class="text-warning fw-bold">المتبقي: {{ number_format($property->remaining) }} EGP</span>
            @endif
        </div>
    @endif
    
    <div class="sub-info mt-3">
        @if($property->area_sqm)<span>📐 {{ number_format($property->area_sqm) }} م²</span>@endif
        @if($property->price_per_sqm)<span>💵 {{ number_format($property->price_per_sqm) }} EGP/م²</span>@endif
        <span class="{{ $property->sale_status=='متاح' ? 'badge-avail' : 'badge-sold' }}">{{ $property->sale_status }}</span>
    </div>
</div>

{{-- الموقع --}}
<div class="detail-card">
    <div class="section-title">📍 الموقع</div>
    <div class="info-grid">
        <div class="info-item">
            <label>المنطقة</label>
            <div class="val {{ !$property->region ? 'empty' : '' }}">{{ $property->region ?? 'غير محدد' }}</div>
        </div>
        <div class="info-item">
            <label>الحي</label>
            <div class="val {{ !$property->neighborhood ? 'empty' : '' }}">{{ $property->neighborhood ?? 'غير محدد' }}</div>
        </div>
        <div class="info-item">
            <label>اسم المشروع</label>
            <div class="val {{ !$property->project_name ? 'empty' : '' }}">{{ $property->project_name ?? 'غير محدد' }}</div>
        </div>
    </div>
    @if($property->address)
    <div class="mt-3">
        <label class="form-label" style="font-size:.78rem;font-weight:700;color:#64748b">العنوان بالتفصيل</label>
        <div style="background:#f8fafc;border-radius:8px;padding:.75rem 1rem;font-size:.9rem;color:#374151">{{ $property->address }}</div>
    </div>
    @endif
</div>

{{-- تفاصيل الوحدة --}}
<div class="detail-card">
    <div class="section-title">🏠 تفاصيل الوحدة</div>
    <div class="info-grid">
        <div class="info-item">
            <label>نوع الوحدة</label>
            <div class="val {{ !$property->unit_type ? 'empty' : '' }}">{{ $property->unit_type ?? 'غير محدد' }}</div>
        </div>
        <div class="info-item">
            <label>حالة التشطيب</label>
            <div class="val {{ !$property->finishing_status ? 'empty' : '' }}">{{ $property->finishing_status ?? 'غير محدد' }}</div>
        </div>
        <div class="info-item">
            <label>المساحة</label>
            <div class="val {{ !$property->area_sqm ? 'empty' : '' }}">{{ $property->area_sqm ? number_format($property->area_sqm).' م²' : 'غير محدد' }}</div>
        </div>
        <div class="info-item">
            <label>الطابق</label>
            <div class="val {{ !$property->floor ? 'empty' : '' }}">{{ $property->floor ?? 'غير محدد' }}</div>
        </div>
        <div class="info-item">
            <label>عدد الغرف</label>
            <div class="val {{ !$property->rooms_count ? 'empty' : '' }}">{{ $property->rooms_count ?? 'غير محدد' }}</div>
        </div>
        <div class="info-item">
            <label>عدد الحمامات</label>
            <div class="val {{ !$property->bathrooms_count ? 'empty' : '' }}">{{ $property->bathrooms_count ?? 'غير محدد' }}</div>
        </div>
        <div class="info-item">
            <label>الهدف من الوحدة</label>
            <div class="val {{ !$property->unit_purpose ? 'empty' : '' }}">{{ $property->unit_purpose ?? 'غير محدد' }}</div>
        </div>
    </div>
    @if($property->unit_details)
    <div class="mt-3">
        <label class="form-label" style="font-size:.78rem;font-weight:700;color:#64748b">تفاصيل الوحدة والموقع</label>
        <div style="background:#f8fafc;border-radius:8px;padding:.75rem 1rem;font-size:.9rem;color:#374151;white-space:pre-line">{{ $property->unit_details }}</div>
    </div>
    @endif
</div>

{{-- بيانات العميل --}}
<div class="detail-card">
    <div class="section-title">👤 بيانات العميل</div>
    <div class="info-grid">
        <div class="info-item">
            <label>اسم العميل</label>
            <div class="val {{ !$property->client_name ? 'empty' : '' }}">{{ $property->client_name ?? 'غير محدد' }}</div>
        </div>
        <div class="info-item">
            <label>رقم الهاتف</label>
            <div class="val {{ !$property->client_phone ? 'empty' : '' }}">
                @if($property->client_phone)
                <a href="tel:{{ $property->client_phone }}" style="color:#2563eb">{{ $property->client_phone }}</a>
                @else غير محدد @endif
            </div>
        </div>
        <div class="info-item">
            <label>الحالة</label>
            <div><span class="{{ $property->status=='مباشر' ? 'badge-direct' : 'badge-broker' }}">{{ $property->status }}</span></div>
        </div>
        <div class="info-item">
            <label>حالة البيع</label>
            <div><span class="{{ $property->sale_status=='متاح' ? 'badge-avail' : 'badge-sold' }}">{{ $property->sale_status }}</span></div>
        </div>
    </div>
    @if($property->required_action)
    <div class="mt-3">
        <label class="form-label" style="font-size:.78rem;font-weight:700;color:#64748b">الإجراء المطلوب</label>
        <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:.75rem 1rem;font-size:.9rem;color:#92400e;white-space:pre-line">{{ $property->required_action }}</div>
    </div>
    @endif
</div>

{{-- سجل الإجراءات --}}
<div class="detail-card">
    <div class="section-title">📝 سجل الإجراءات والمتابعة</div>
    
    {{-- Form to add log --}}
    <form action="{{ route('properties.addLog', $property->id) }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="note" class="form-control" placeholder="أدخل إجراء جديد (مثال: تم الاتصال بالعميل، موعد معاينة يوم...)" required>
            <button type="submit" class="btn btn-primary px-4">➕ إضافة إجراء</button>
        </div>
    </form>

    {{-- List of logs --}}
    <div class="log-timeline">
        @forelse($property->logs as $log)
        <div class="log-item p-3 mb-2 border-bottom">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-primary" style="font-size:.85rem">👤 {{ $log->user->name ?? 'موظف' }}</span>
                <span class="text-muted" style="font-size:.75rem">{{ $log->created_at->format('Y-m-d h:i A') }}</span>
            </div>
            <div class="log-note" style="font-size:.9rem; color:#374151">{{ $log->note }}</div>
        </div>
        @empty
        <p class="text-center text-muted py-3">لا توجد إجراءات مسجلة لهذه الوحدة حتى الآن.</p>
        @endforelse
    </div>
</div>

@if($property->media && count($property->media))
<div class="detail-card">
    <div class="section-title">📸 الصور والفيديو</div>
    <div class="media-gallery">
        @foreach($property->media as $path)
            @if(Str::endsWith($path, ['mp4','mov','avi']))
            <div class="media-item">
                <video src="{{ Storage::url($path) }}" controls></video>
            </div>
            @else
            <div class="media-item">
                <img src="{{ Storage::url($path) }}" alt="صورة" onclick="openLightbox(this.src)">
            </div>
            @endif
        @endforeach
    </div>
</div>
@endif

{{-- Lightbox --}}
<div id="lightbox" onclick="closeLightbox()">
    <button class="close-lb" onclick="closeLightbox()">✖</button>
    <img id="lightboxImg" src="">
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
                    <h5 class="modal-title fw-bold">💰 إتمام عملية البيع</h5>
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

<script>
function openSellModal(id, title, totalPrice, deposit, remaining) {
    const modal = new bootstrap.Modal(document.getElementById('sellModal'));
    document.getElementById('sellModalSubTitle').innerText = 'تأكيد بيع: ' + title + ' (السعر الكلي: ' + Number(totalPrice).toLocaleString() + ')';
    
    const depInfo = document.getElementById('depositInfo');
    if (deposit > 0) {
        depInfo.style.display = 'block';
        document.getElementById('modalDepositVal').innerText = Number(deposit).toLocaleString();
        document.getElementById('final_sale_price').value = remaining;
    } else {
        depInfo.style.display = 'none';
        document.getElementById('final_sale_price').value = totalPrice;
    }
    
    document.getElementById('sellForm').action = '/properties/' + id + '/sell';
    modal.show();
}

function openLightbox(src) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightbox').classList.add('open');
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
}
document.addEventListener('keydown', e => { if(e.key==='Escape') closeLightbox(); });
</script>
@endsection
