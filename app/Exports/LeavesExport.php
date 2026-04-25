<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LeavesExport implements WithMultipleSheets
{
    protected $leaves;
    protected $year;

    public function __construct($leaves, $year)
    {
        $this->leaves = $leaves;
        $this->year = $year;
    }

    public function sheets(): array
    {
        return [
            new LeavesMainSheet($this->leaves, $this->year),
            new LeavesAnnualSheet($this->leaves, $this->year),
        ];
    }
}
