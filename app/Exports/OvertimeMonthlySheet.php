<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OvertimeMonthlySheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $monthlyTotals;
    protected $periodStart;
    protected $periodEnd;

    public function __construct($monthlyTotals, $periodStart, $periodEnd)
    {
        $this->monthlyTotals = $monthlyTotals;
        $this->periodStart = $periodStart;
        $this->periodEnd = $periodEnd;
    }

    public function collection()
    {
        return $this->monthlyTotals->map(function ($record) {
            return [
                'Employee Name'   => $record->name ?? 'غير محدد',
                'Total Hours'     => round($record->total, 2) . ' hrs',
                'Period'          => $this->periodStart->format('d M Y') . ' → ' . $this->periodEnd->format('d M Y'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Employee Name', 'Total Hours This Cycle', 'Period'];
    }

    public function title(): string
    {
        return 'إجمالي الإضافي';
    }

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
