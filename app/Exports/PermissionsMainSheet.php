<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PermissionsMainSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $permissions;
    protected $periodStart;
    protected $periodEnd;

    public function __construct($permissions, $periodStart, $periodEnd)
    {
        $this->permissions = $permissions;
        $this->periodStart = $periodStart;
        $this->periodEnd = $periodEnd;
    }

    public function collection()
    {
        return $this->permissions->map(function ($item, $index) {
            return [
                'N'             => $index + 1,
                'Employee Name' => $item->name,
                'Date'          => \Carbon\Carbon::parse($item->date)->format('d M Y'),
                'Day'           => $item->day,
                'Type'          => $item->permission_type ?? 'Default',
                'Reason'        => $item->reason,
                'From'          => $item->from,
                'To'            => $item->to,
                'Status'        => ucfirst($item->status),
                'Refuse Reason' => $item->refuse_reason ?? '—',
            ];
        });
    }

    public function headings(): array
    {
        return ['N', 'Employee Name', 'Date', 'Day', 'Type', 'Reason', 'From', 'To', 'Status', 'Refuse Reason'];
    }

    public function title(): string { return 'سجل الأذونات'; }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD']
                ]
            ],
        ];
    }
}
