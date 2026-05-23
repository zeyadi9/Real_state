<?php

namespace App\Imports;

use App\Models\Property;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PropertiesImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        // فحص إذا كان الصف فارغاً (نتأكد من وجود المنطقة أو اسم العميل على الأقل)
        if (empty($row[2]) && empty($row[15]) && empty($row[6])) {
            return null;
        }

        return new Property([
            'region'            => $row[2] ?? null,
            'finishing_status'  => $row[3] ?? null,
            'neighborhood'      => $row[4] ?? null,
            'address'           => $row[5] ?? null,
            'unit_type'         => $row[6] ?? null,
            'area_sqm'          => $row[7] ?? null,
            'rooms_count'       => $row[8] ?? null,
            'bathrooms_count'   => $row[9] ?? null,
            'project_name'      => $row[10] ?? null,
            'floor'             => $row[11] ?? null,
            'price_per_sqm'     => $row[12] ?? null,
            'total_price'       => $row[13] ?? null,
            'unit_details'      => $row[14] ?? null,
            'client_name'       => $row[15] ?? null,
            'client_phone'      => $row[16] ?? null,
            'status'            => $row[17] ?? 'مباشر',
            'required_action'   => $row[18] ?? null,
            'unit_purpose'      => $row[20] ?? null,
            'sale_status'       => 'متاح',
            'created_by_id'     => auth()->id(),
        ]);
    }
}
