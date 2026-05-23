<?php

namespace App\Exports;

use App\Models\Property;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PropertiesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Property::where('sale_status', 'متاح')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'المنطقة',
            'الحي',
            'نوع الوحدة',
            'المساحة',
            'إجمالي السعر',
            'المقدم',
            'المتبقي',
            'اسم العميل',
            'الحالة',
            'الهدف',
            'آخر إجراء',
        ];
    }

    public function map($p): array
    {
        return [
            $p->id,
            $p->region,
            $p->neighborhood,
            $p->unit_type,
            $p->area_sqm,
            $p->total_price,
            $p->deposit,
            $p->remaining,
            $p->client_name,
            $p->status,
            $p->unit_purpose,
            $p->latestLog ? $p->latestLog->note : 'لا يوجد',
        ];
    }
}
