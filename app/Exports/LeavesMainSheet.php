<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeavesMainSheet implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $leaves;
    protected $year;

    public function __construct($leaves, $year)
    {
        $this->leaves = $leaves;
        $this->year = $year;
    }

    public function collection()
    {
        return $this->leaves->map(function ($item, $index) {
            return [
                'N'             => $index + 1,
                'Employee Name' => $item->name,
                'Date'          => \Carbon\Carbon::parse($item->date)->format('d M Y'),
                'Day'           => $item->day,
                'Days Count'    => $item->days_count . ' days',
                'Reason'        => $item->reason,
                'Substitute'    => $item->substitute,
                'Status'        => ucfirst($item->status),
                'Refuse Reason' => $item->refuse_reason ?? '—',
            ];
        });
    }

    public function headings(): array
    {
        return ['N', 'Employee Name', 'Date', 'Day', 'Days Count', 'Reason', 'Substitute', 'Status', 'Refuse Reason'];
    }

    public function title(): string { return 'سجل الإجازات'; }

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
