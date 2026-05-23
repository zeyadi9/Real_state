@extends('layout')
@section('title', 'إضافة وحدة جديدة')

@section('styles')
<style>
.form-card { background:#fff; border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,.08); padding:2rem; }
.section-title { font-size:1rem; font-weight:800; color:#0f172a; margin-bottom:1rem; padding-bottom:.5rem; border-bottom:2px solid #e2e8f0; display:flex; align-items:center; gap:.4rem; }
.form-label { font-weight:600; font-size:.85rem; color:#374151; }
.upload-area { border:2px dashed #cbd5e1; border-radius:12px; padding:2rem; text-align:center; cursor:pointer; transition:all .2s; }
.upload-area:hover { border-color:#2563eb; background:#eff6ff; }
.preview-grid { display:flex; flex-wrap:wrap; gap:.75rem; margin-top:1rem; }
.preview-item { width:100px; height:100px; border-radius:8px; overflow:hidden; position:relative; border:2px solid #e2e8f0; }
.preview-item img { width:100%; height:100%; object-fit:cover; }
.preview-item video { width:100%; height:100%; object-fit:cover; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 style="font-size:1.4rem;font-weight:800;color:#0f172a;margin:0">➕ إضافة وحدة جديدة</h1>
    <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary btn-sm">← رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger mb-3">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- الموقع --}}
<div class="form-card mb-4">
    <div class="section-title">📍 الموقع</div>
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <label class="form-label">المنطقة</label>
            <input type="text" name="region" class="form-control" value="{{ old('region') }}">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">الحي</label>
            <input type="text" name="neighborhood" class="form-control" value="{{ old('neighborhood') }}">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">اسم المشروع</label>
            <input type="text" name="project_name" class="form-control" value="{{ old('project_name') }}">
        </div>
        <div class="col-12">
            <label class="form-label">العنوان بالتفصيل</label>
            <textarea name="address" class="form-control" rows="2" placeholder="الشارع، رقم العمارة، تفاصيل الوصول...">{{ old('address') }}</textarea>
        </div>
    </div>
</div>

{{-- تفاصيل الوحدة --}}
<div class="form-card mb-4">
    <div class="section-title">🏠 تفاصيل الوحدة</div>
    <div class="row g-3">
        <div class="col-6 col-md-3">
            <label class="form-label">نوع الوحدة</label>
            <select name="unit_type" class="form-select">
                <option value="">اختر...</option>
                @foreach(['منزل' , 'شقة' , 'فيلا' , 'دوبلكس' , 'برج' , 'محل' , 'مكتب' , 'أرض' , 'مخزن', 'عماره' ] as $t)
                <option value="{{ $t }}" {{ old('unit_type')==$t?'selected':'' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">حالة التشطيب</label>
            <select name="finishing_status" class="form-select">
                <option value="">اختر...</option>
                @foreach(['3/4 تشطيب', 'ارض', 'تشطيب الترا سوبرلوكس', 'تشطيب سوبر لوكس', 'تشطيب لوكس', 'تشطيب وعضم', 'عضم', 'فيه تشطيب وفيه عضم', 'متشطبه تشطيب قدم', 'نصف تشطيب'] as $f)
                <option value="{{ $f }}" {{ old('finishing_status')==$f?'selected':'' }}>{{ $f }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">المساحة</label>
            <input type="text" name="area_sqm" class="form-control" value="{{ old('area_sqm') }}">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">الطابق</label>
            <input type="text" name="floor" class="form-control" value="{{ old('floor') }}">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">عدد الغرف</label>
            <input type="text" name="rooms_count" class="form-control" value="{{ old('rooms_count') }}">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">عدد الحمامات</label>
            <input type="text" name="bathrooms_count" class="form-control" value="{{ old('bathrooms_count') }}">
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">الهدف من الوحدة</label>
            <select name="unit_purpose" class="form-select">
                <option value="">اختر...</option>
                @foreach(['بيع','إيجار','استثمار','تجاري'] as $p)
                <option value="{{ $p }}" {{ old('unit_purpose')==$p?'selected':'' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">تفاصيل الوحدة والموقع</label>
            <textarea name="unit_details" class="form-control" rows="3" placeholder="وصف تفصيلي للوحدة، المميزات، الإطلالة...">{{ old('unit_details') }}</textarea>
        </div>
    </div>
</div>

{{-- التسعير --}}
<div class="form-card mb-4">
    <div class="section-title">💰 التسعير</div>
    <div class="row g-3">
        <div class="col-12 col-md-3">
            <label class="form-label">سعر المتر (EGP)</label>
            <input type="number" name="price_per_sqm" id="price_per_sqm" class="form-control" value="{{ old('price_per_sqm') }}" placeholder="0" step="0.01" min="0" oninput="calcRemaining()">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label">إجمالي سعر الوحدة (EGP)</label>
            <input type="number" name="total_price" id="total_price" class="form-control" value="{{ old('total_price') }}" placeholder="0" step="0.01" min="0" oninput="calcRemaining()">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label">المقدم (EGP)</label>
            <input type="number" name="deposit" id="deposit" class="form-control" value="{{ old('deposit') }}" placeholder="0" step="0.01" min="0" oninput="calcRemaining()">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label">المتبقي (EGP)</label>
            <input type="number" id="remaining_display" class="form-control bg-light" placeholder="—" readonly>
        </div>
        <div class="col-12 d-flex gap-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="calcTotal()">🧮 احسب الإجمالي من المساحة</button>
        </div>
    </div>
</div>

{{-- بيانات العميل --}}
<div class="form-card mb-4">
    <div class="section-title">👤 بيانات العميل</div>
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <label class="form-label">اسم العميل</label>
            <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}" placeholder="الاسم الكامل">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">رقم هاتف العميل</label>
            <input type="text" name="client_phone" class="form-control" value="{{ old('client_phone') }}" placeholder="01xxxxxxxxx">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">الحالة</label>
            <select name="status" class="form-select">
                <option value="مباشر" {{ old('status','مباشر')=='مباشر'?'selected':'' }}>مباشر</option>
                <option value="وسيط" {{ old('status')=='وسيط'?'selected':'' }}>وسيط</option>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">حالة البيع</label>
            <select name="sale_status" class="form-select">
                <option value="متاح" {{ old('sale_status','متاح')=='متاح'?'selected':'' }}>متاح</option>
                <option value="مباع" {{ old('sale_status')=='مباع'?'selected':'' }}>مباع</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">الإجراء المطلوب</label>
            <textarea name="required_action" class="form-control" rows="2" placeholder="مثال: متابعة العميل، تحديد موعد معاينة...">{{ old('required_action') }}</textarea>
        </div>
    </div>
</div>

{{-- الصور والفيديو --}}
<div class="form-card mb-4">
    <div class="section-title">📸 صور وفيديو</div>
    <div class="upload-area" onclick="document.getElementById('mediaInput').click()">
        <div style="font-size:2rem">📁</div>
        <p class="mb-1 fw-semibold">اضغط لرفع صور أو فيديوهات</p>
        <small class="text-muted">JPG, PNG, GIF, WEBP, MP4, MOV — حد أقصى 50MB لكل ملف</small>
        <input type="file" id="mediaInput" name="media[]" multiple accept="image/*,video/*" class="d-none" onchange="previewFiles(this)">
    </div>
    <div class="preview-grid" id="previewGrid"></div>
</div>

<div class="d-flex gap-3 justify-content-end">
    <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
    <button type="submit" class="btn btn-primary px-5 fw-bold">💾 حفظ الوحدة</button>
</div>

</form>

<script>
function calcTotal() {
    const area  = parseFloat(document.querySelector('[name=area_sqm]').value) || 0;
    const price = parseFloat(document.getElementById('price_per_sqm').value) || 0;
    if (area && price) {
        document.getElementById('total_price').value = (area * price).toFixed(2);
        calcRemaining();
    }
}

function calcRemaining() {
    const total   = parseFloat(document.getElementById('total_price').value) || 0;
    const deposit = parseFloat(document.getElementById('deposit').value) || 0;
    const rem     = document.getElementById('remaining_display');
    if (total > 0) {
        rem.value = (total - deposit).toFixed(2);
        rem.style.color = (total - deposit) < 0 ? '#dc2626' : '#16a34a';
    } else {
        rem.value = '';
    }
}

function previewFiles(input) {
    const grid = document.getElementById('previewGrid');
    grid.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const item = document.createElement('div');
        item.className = 'preview-item';
        const url = URL.createObjectURL(file);
        if (file.type.startsWith('video/')) {
            item.innerHTML = `<video src="${url}" muted></video>`;
        } else {
            item.innerHTML = `<img src="${url}" alt="preview">`;
        }
        grid.appendChild(item);
    });
}
</script>
@endsection
