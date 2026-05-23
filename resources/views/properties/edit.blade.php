@extends('layout')
@section('title', 'تعديل الوحدة')

@section('styles')
<style>
.form-card { background:#fff; border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,.08); padding:2rem; }
.section-title { font-size:1rem; font-weight:800; color:#0f172a; margin-bottom:1rem; padding-bottom:.5rem; border-bottom:2px solid #e2e8f0; display:flex; align-items:center; gap:.4rem; }
.form-label { font-weight:600; font-size:.85rem; color:#374151; }
.upload-area { border:2px dashed #cbd5e1; border-radius:12px; padding:2rem; text-align:center; cursor:pointer; transition:all .2s; }
.upload-area:hover { border-color:#2563eb; background:#eff6ff; }
.preview-grid { display:flex; flex-wrap:wrap; gap:.75rem; margin-top:1rem; }
.media-thumb { width:110px; border-radius:8px; overflow:hidden; position:relative; border:2px solid #e2e8f0; }
.media-thumb img, .media-thumb video { width:100%; height:85px; object-fit:cover; display:block; }
.media-thumb .remove-btn { position:absolute; top:3px; left:3px; background:rgba(220,38,38,.85); color:#fff; border:none; border-radius:50%; width:22px; height:22px; font-size:12px; cursor:pointer; display:flex; align-items:center; justify-content:center; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 style="font-size:1.4rem;font-weight:800;color:#0f172a;margin:0">✏️ تعديل الوحدة #{{ $property->id }}</h1>
    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-outline-secondary btn-sm">← رجوع</a>
</div>

@if($errors->any())
<div class="alert alert-danger mb-3">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- الموقع --}}
<div class="form-card mb-4">
    <div class="section-title">📍 الموقع</div>
    <div class="row g-3">
        <div class="col-12 col-md-4">
            <label class="form-label">المنطقة</label>
            <input type="text" name="region" class="form-control" value="{{ old('region', $property->region) }}">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">الحي</label>
            <input type="text" name="neighborhood" class="form-control" value="{{ old('neighborhood', $property->neighborhood) }}">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">اسم المشروع</label>
            <input type="text" name="project_name" class="form-control" value="{{ old('project_name', $property->project_name) }}">
        </div>
        <div class="col-12">
            <label class="form-label">العنوان بالتفصيل</label>
            <textarea name="address" class="form-control" rows="2">{{ old('address', $property->address) }}</textarea>
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
                <option value="{{ $t }}" {{ old('unit_type',$property->unit_type)==$t?'selected':'' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">حالة التشطيب</label>
            <select name="finishing_status" class="form-select">
                <option value="">اختر...</option>
                @foreach(['3/4 تشطيب', 'ارض', 'تشطيب الترا سوبرلوكس', 'تشطيب سوبر لوكس', 'تشطيب لوكس', 'تشطيب وعضم', 'عضم', 'فيه تشطيب وفيه عضم', 'متشطبه تشطيب قدم', 'نصف تشطيب'] as $f)
                <option value="{{ $f }}" {{ old('finishing_status',$property->finishing_status)==$f?'selected':'' }}>{{ $f }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">المساحة</label>
            <input type="text" name="area_sqm" class="form-control" value="{{ old('area_sqm', $property->area_sqm) }}">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">الطابق</label>
            <input type="text" name="floor" class="form-control" value="{{ old('floor', $property->floor) }}">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">عدد الغرف</label>
            <input type="text" name="rooms_count" class="form-control" value="{{ old('rooms_count', $property->rooms_count) }}">
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label">عدد الحمامات</label>
            <input type="text" name="bathrooms_count" class="form-control" value="{{ old('bathrooms_count', $property->bathrooms_count) }}">
        </div>
        <div class="col-12 col-md-6">
            <label class="form-label">الهدف من الوحدة</label>
            <select name="unit_purpose" class="form-select">
                <option value="">اختر...</option>
                @foreach(['سكن','إيجار','استثمار','تجاري'] as $p)
                <option value="{{ $p }}" {{ old('unit_purpose',$property->unit_purpose)==$p?'selected':'' }}>{{ $p }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">تفاصيل الوحدة والموقع</label>
            <textarea name="unit_details" class="form-control" rows="3">{{ old('unit_details', $property->unit_details) }}</textarea>
        </div>
    </div>
</div>

{{-- التسعير --}}
<div class="form-card mb-4">
    <div class="section-title">💰 التسعير</div>
    <div class="row g-3">
        <div class="col-12 col-md-3">
            <label class="form-label">سعر المتر (EGP)</label>
            <input type="number" name="price_per_sqm" id="price_per_sqm" class="form-control" value="{{ old('price_per_sqm', $property->price_per_sqm) }}" step="0.01" min="0" oninput="calcRemaining()">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label">إجمالي سعر الوحدة (EGP)</label>
            <input type="number" name="total_price" id="total_price" class="form-control" value="{{ old('total_price', $property->total_price) }}" step="0.01" min="0" oninput="calcRemaining()">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label">المقدم (EGP)</label>
            <input type="number" name="deposit" id="deposit" class="form-control" value="{{ old('deposit', $property->deposit) }}" step="0.01" min="0" oninput="calcRemaining()">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label">المتبقي (EGP)</label>
            <input type="number" id="remaining_display" class="form-control bg-light" value="{{ $property->remaining }}" readonly>
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
            <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $property->client_name) }}">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">رقم هاتف العميل</label>
            <input type="text" name="client_phone" class="form-control" value="{{ old('client_phone', $property->client_phone) }}">
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">الحالة</label>
            <select name="status" class="form-select">
                <option value="مباشر" {{ old('status',$property->status)=='مباشر'?'selected':'' }}>مباشر</option>
                <option value="وسيط" {{ old('status',$property->status)=='وسيط'?'selected':'' }}>وسيط</option>
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label">حالة البيع</label>
            <select name="sale_status" class="form-select">
                <option value="متاح" {{ old('sale_status',$property->sale_status)=='متاح'?'selected':'' }}>متاح</option>
                <option value="مباع" {{ old('sale_status',$property->sale_status)=='مباع'?'selected':'' }}>مباع</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">الإجراء المطلوب</label>
            <textarea name="required_action" class="form-control" rows="2">{{ old('required_action', $property->required_action) }}</textarea>
        </div>
    </div>
</div>

{{-- الصور والفيديو --}}
<div class="form-card mb-4">
    <div class="section-title">📸 صور وفيديو</div>
    
    @if($property->media && count($property->media))
    <p class="text-muted fw-semibold mb-2" style="font-size:.85rem">الملفات الحالية — اضغط ✖ لحذف</p>
    <div class="preview-grid" id="existingMedia">
        @foreach($property->media as $path)
        <div class="media-thumb" id="thumb-{{ $loop->index }}">
            @if(Str::endsWith($path, ['mp4','mov','avi']))
            <video src="{{ Storage::url($path) }}" muted></video>
            @else
            <img src="{{ Storage::url($path) }}" alt="media">
            @endif
            <button type="button" class="remove-btn" onclick="removeMedia('{{ $path }}', 'thumb-{{ $loop->index }}')">✖</button>
        </div>
        @endforeach
    </div>
    <div id="removeInputs"></div>
    @endif

    <div class="upload-area mt-3" onclick="document.getElementById('mediaInput').click()">
        <div style="font-size:2rem">📁</div>
        <p class="mb-1 fw-semibold">اضغط لإضافة صور أو فيديوهات جديدة</p>
        <small class="text-muted">JPG, PNG, GIF, WEBP, MP4, MOV — حد أقصى 50MB</small>
        <input type="file" id="mediaInput" name="media[]" multiple accept="image/*,video/*" class="d-none" onchange="previewFiles(this)">
    </div>
    <div class="preview-grid" id="previewGrid"></div>
</div>

<div class="d-flex gap-3 justify-content-end">
    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-outline-secondary px-4">إلغاء</a>
    <button type="submit" class="btn btn-primary px-5 fw-bold">💾 حفظ التعديلات</button>
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

function removeMedia(path, thumbId) {
    document.getElementById(thumbId).remove();
    const container = document.getElementById('removeInputs');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'remove_media[]';
    input.value = path;
    container.appendChild(input);
}

function previewFiles(input) {
    const grid = document.getElementById('previewGrid');
    grid.innerHTML = '';
    Array.from(input.files).forEach(file => {
        const item = document.createElement('div');
        item.className = 'media-thumb';
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
