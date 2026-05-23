<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyLog;
use App\Models\AuditLog;
use App\Exports\PropertiesExport;
use App\Imports\PropertiesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /* ─── Filters shared by index & sold ─── */
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('region'))           $query->where('region', 'like', '%'.$request->region.'%');
        if ($request->filled('neighborhood'))     $query->where('neighborhood', 'like', '%'.$request->neighborhood.'%');
        if ($request->filled('project_name'))     $query->where('project_name', 'like', '%'.$request->project_name.'%');
        if ($request->filled('unit_type'))        $query->where('unit_type', $request->unit_type);
        if ($request->filled('finishing_status')) $query->where('finishing_status', $request->finishing_status);
        if ($request->filled('status'))           $query->where('status', $request->status);
        if ($request->filled('unit_purpose'))     $query->where('unit_purpose', $request->unit_purpose);
        if ($request->filled('client_name'))      $query->where('client_name', 'like', '%'.$request->client_name.'%');
        if ($request->filled('client_phone'))     $query->where('client_phone', 'like', '%'.$request->client_phone.'%');
        
        if ($request->filled('address'))          $query->where('address', 'like', '%'.$request->address.'%');
        if ($request->filled('rooms_count'))      $query->where('rooms_count', 'like', '%'.$request->rooms_count.'%');
        if ($request->filled('bathrooms_count'))  $query->where('bathrooms_count', 'like', '%'.$request->bathrooms_count.'%');
        if ($request->filled('floor'))            $query->where('floor', 'like', '%'.$request->floor.'%');
        if ($request->filled('price_per_sqm'))    $query->where('price_per_sqm', 'like', '%'.$request->price_per_sqm.'%');
        if ($request->filled('unit_details'))     $query->where('unit_details', 'like', '%'.$request->unit_details.'%');
        if ($request->filled('required_action'))  $query->where('required_action', 'like', '%'.$request->required_action.'%');

        if ($request->filled('min_price'))        $query->where('total_price', '>=', $request->min_price);
        if ($request->filled('max_price'))        $query->where('total_price', '<=', $request->max_price);
        if ($request->filled('min_area'))         $query->where('area_sqm', '>=', $request->min_area);
        if ($request->filled('max_area'))         $query->where('area_sqm', '<=', $request->max_area);
        
        return $query;
    }

    public function index(Request $request)
    {
        $query = Property::with('latestLog')->where('sale_status', 'متاح');
        $query = $this->applyFilters($query, $request);
        $properties = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        return view('properties.index', compact('properties'));
    }

    public function sold(Request $request)
    {
        $query = Property::with('latestLog')->where('sale_status', 'مباع');
        $query = $this->applyFilters($query, $request);
        $properties = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();
        return view('properties.sold', compact('properties'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'region'           => 'nullable|string|max:255',
            'finishing_status' => 'nullable|string|max:255',
            'neighborhood'     => 'nullable|string|max:255',
            'address'          => 'nullable|string',
            'unit_type'        => 'nullable|string|max:255',
            'area_sqm'         => 'nullable|string|max:255',
            'rooms_count'      => 'nullable|string|max:255',
            'bathrooms_count'  => 'nullable|string|max:255',
            'project_name'     => 'nullable|string|max:255',
            'floor'            => 'nullable|string|max:50',
            'price_per_sqm'    => 'nullable|numeric|min:0',
            'total_price'      => 'nullable|numeric|min:0',
            'deposit'          => 'nullable|numeric|min:0',
            'unit_details'     => 'nullable|string',
            'client_name'      => 'nullable|string|max:255',
            'client_phone'     => 'nullable|string|max:30',
            'status'           => 'nullable|string|max:50',
            'required_action'  => 'nullable|string',
            'unit_purpose'     => 'nullable|string|max:255',
            'sale_status'      => 'nullable|string|max:50',
            'media.*'          => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:51200',
        ]);

        // Handle media uploads
        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('properties', 'public');
                $mediaPaths[] = $path;
            }
        }
        $data['media']      = $mediaPaths ?: null;
        $data['status']     = $data['status'] ?? 'مباشر';
        $data['sale_status'] = $data['sale_status'] ?? 'متاح';
        $data['created_by_id'] = Auth::id();

        $property = Property::create($data);

        AuditLog::log(Auth::user()->name, 'إضافة وحدة', 'العقارات', 'وحدة رقم: ' . $property->id);

        return redirect()->route('properties.index')->with('success', 'تم إضافة الوحدة بنجاح ✅');
    }

    public function show($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.show', compact('property'));
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $data = $request->validate([
            'region'           => 'nullable|string|max:255',
            'finishing_status' => 'nullable|string|max:255',
            'neighborhood'     => 'nullable|string|max:255',
            'address'          => 'nullable|string',
            'unit_type'        => 'nullable|string|max:255',
            'area_sqm'         => 'nullable|string|max:255',
            'rooms_count'      => 'nullable|string|max:255',
            'bathrooms_count'  => 'nullable|string|max:255',
            'project_name'     => 'nullable|string|max:255',
            'floor'            => 'nullable|string|max:50',
            'price_per_sqm'    => 'nullable|numeric|min:0',
            'total_price'      => 'nullable|numeric|min:0',
            'deposit'          => 'nullable|numeric|min:0',
            'unit_details'     => 'nullable|string',
            'client_name'      => 'nullable|string|max:255',
            'client_phone'     => 'nullable|string|max:30',
            'status'           => 'nullable|string|max:50',
            'required_action'  => 'nullable|string',
            'unit_purpose'     => 'nullable|string|max:255',
            'sale_status'      => 'nullable|string|max:50',
            'media.*'          => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:51200',
            'remove_media'     => 'nullable|array',
        ]);

        // Handle keeping existing media minus removed ones
        $existing = $property->media ?? [];
        if (!empty($data['remove_media'])) {
            foreach ($data['remove_media'] as $path) {
                Storage::disk('public')->delete($path);
                $existing = array_filter($existing, fn($m) => $m !== $path);
            }
        }

        // Add new uploads
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('properties', 'public');
                $existing[] = $path;
            }
        }

        unset($data['remove_media'], $data['media']);
        $data['media'] = array_values($existing) ?: null;

        $property->update($data);

        AuditLog::log(Auth::user()->name, 'تعديل وحدة', 'العقارات', 'وحدة رقم: ' . $property->id);

        return redirect()->route('properties.show', $id)->with('success', 'تم تحديث البيانات بنجاح ✅');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        if ($property->media) {
            foreach ($property->media as $path) {
                Storage::disk('public')->delete($path);
            }
        }
        
        AuditLog::log(Auth::user()->name, 'حذف وحدة', 'العقارات', 'وحدة رقم: ' . $id);

        $property->delete();
        return redirect()->route('properties.index')->with('success', 'تم حذف الوحدة بنجاح');
    }

    public function markAsSold(Request $request, $id)
    {
        $request->validate([
            'final_sale_price' => 'required|numeric|min:0',
        ]);

        $property = Property::findOrFail($id);
        $property->sale_status      = 'مباع';
        $property->final_sale_price = $request->final_sale_price;
        $property->sold_by_id       = Auth::id();
        $property->save();

        AuditLog::log(Auth::user()->name, 'إتمام بيع', 'العقارات', 'وحدة رقم: ' . $id . ' بسعر ' . $request->final_sale_price);

        return redirect()->back()->with('success', 'تم نقل الوحدة إلى المباع بسعر ' . number_format($request->final_sale_price) . ' EGP ✅');
    }

    public function markAsAvailable($id)
    {
        $property = Property::findOrFail($id);
        $property->sale_status = 'متاح';
        $property->save();

        AuditLog::log(Auth::user()->name, 'إعادة للمتاح', 'العقارات', 'وحدة رقم: ' . $id);

        return redirect()->back()->with('success', 'تم إعادة الوحدة إلى المتاح ✅');
    }

    public function addLog(Request $request, $id)
    {
        $request->validate([
            'note' => 'required|string',
        ]);

        PropertyLog::create([
            'property_id' => $id,
            'user_id'     => Auth::id(),
            'note'        => $request->note,
        ]);

        return redirect()->back()->with('success', 'تم إضافة الإجراء بنجاح ✅');
    }

    public function export()
    {
        return Excel::download(new PropertiesExport, 'units_export_' . date('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new PropertiesImport, $request->file('file'));

        AuditLog::log(Auth::user()->name, 'استيراد بيانات', 'العقارات', 'رفع ملف إكسيل');

        return redirect()->back()->with('success', 'تم استيراد البيانات من ملف الإكسيل بنجاح ✅');
    }
}
