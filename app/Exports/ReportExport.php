<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// تصدير البيانات إلى Excel وتنسيقها
class ReportExport implements FromArray, WithHeadings, WithStyles
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * البيانات المراد تصديرها
     */
    public function array(): array
    {
        return $this->data['rows'];
    }

    /**
     * عناوين الأعمدة
     */
    public function headings(): array
    {
        return $this->data['headers'];
    }

    /**
     * تنسيق الخلايا (Styles)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '3D4F5F']], 'font' => ['color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}
