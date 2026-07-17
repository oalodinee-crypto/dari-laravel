<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Unit;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

// تحكم التقارير (عرض وتوليد التقارير)
class ReportsController extends Controller
{
    // عرض صفحة التقارير الرئيسية
    public function index()
    {
        return view('reports.index');
    }

    // تصدير التقرير
    public function export(Request $request)
    {
        $type = $request->input('type');
        $format = $request->input('format');
        
        $data = $this->getReportData($type);
        $fileName = $data['name'] . '_' . date('Y-m-d');

        if ($format === 'csv') {
            return $this->exportCSV($data, $fileName);
        } elseif ($format === 'excel') {
            return Excel::download(new ReportExport($data), $fileName . '.xlsx');
        } elseif ($format === 'pdf') {
            return $this->exportPDF($data, $fileName);
        }

        return back()->with('error', 'صيغة غير مدعومة');
    }

    // جلب بيانات التقرير حسب النوع
    private function getReportData($type)
    {
        switch ($type) {
            case 'revenue':
                return [
                    'name' => 'تقرير الإيرادات',
                    'headers' => ['الشهر', 'الإيرادات', 'المصروفات', 'الصافي'],
                    'rows' => [
                        ['يناير', '220,000', '45,000', '175,000'],
                        ['فبراير', '245,000', '52,000', '193,000'],
                        ['مارس', '238,000', '48,000', '190,000'],
                        ['أبريل', '265,000', '55,000', '210,000'],
                        ['مايو', '285,000', '50,000', '235,000'],
                        ['يونيو', '290,000', '52,000', '238,000'],
                    ]
                ];
            case 'contracts':
                $contracts = Contract::with(['tenant', 'unit'])->latest()->take(20)->get();
                return [
                    'name' => 'تقرير العقود',
                    'headers' => ['الساكن', 'الوحدة', 'تاريخ البدء', 'تاريخ الانتهاء', 'الحالة'],
                    'rows' => $contracts->map(fn($c) => [
                        $c->tenant->name ?? '-',
                        $c->unit->unit_number ?? '-',
                        $c->start_date?->format('Y-m-d'),
                        $c->end_date?->format('Y-m-d'),
                        $c->status_label ?? 'نشط'
                    ])->toArray()
                ];
            case 'water':
                return [
                    'name' => 'تقرير فواتير الماء',
                    'headers' => ['الساكن', 'الوحدة', 'الاستهلاك', 'المبلغ', 'الحالة'],
                    'rows' => [
                        ['محمد الحميري', '101', '12 م³', '8,500 ر.ي', 'مدفوع'],
                        ['أحمد المقطري', '103', '18 م³', '12,000 ر.ي', 'غير مدفوع'],
                        ['خالد الشرعبي', '201', '14 م³', '9,500 ر.ي', 'مدفوع'],
                    ]
                ];
            case 'electricity':
                return [
                    'name' => 'تقرير فواتير الكهرباء',
                    'headers' => ['الساكن', 'الوحدة', 'الاستهلاك', 'المبلغ', 'الحالة'],
                    'rows' => [
                        ['محمد الحميري', '101', '320 كيلوواط', '15,000 ر.ي', 'غير مدفوع'],
                        ['أحمد المقطري', '103', '450 كيلوواط', '20,000 ر.ي', 'غير مدفوع'],
                        ['خالد الشرعبي', '201', '380 كيلوواط', '18,000 ر.ي', 'غير مدفوع'],
                    ]
                ];
            case 'arrears':
                $invoices = Invoice::where('status', 'overdue')->with(['tenant', 'unit'])->get();
                return [
                    'name' => 'تقرير المتأخرات',
                    'headers' => ['الساكن', 'الوحدة', 'المبنى', 'المتأخرات', 'الأشهر'],
                    'rows' => $invoices->map(fn($i) => [
                        $i->tenant->name ?? '-',
                        $i->unit->unit_number ?? '-',
                        $i->unit->building->name ?? '-',
                        number_format($i->total_amount) . ' ر.س',
                        $i->created_at?->diffInMonths(now()) ?? '1'
                    ])->toArray()
                ];
            case 'occupancy':
                $buildings = Building::withCount(['units', 'units as occupied_units_count' => fn($q) => $q->where('status', 'occupied')])->get();
                return [
                    'name' => 'تقرير الإشغال',
                    'headers' => ['المبنى', 'إجمالي الوحدات', 'مؤجرة', 'شاغرة', 'نسبة الإشغال'],
                    'rows' => $buildings->map(fn($b) => [
                        $b->name,
                        $b->units_count,
                        $b->occupied_units_count,
                        $b->units_count - $b->occupied_units_count,
                        $b->units_count > 0 ? round(($b->occupied_units_count / $b->units_count) * 100) . '%' : '0%'
                    ])->toArray()
                ];
            case 'maintenance':
                $requests = MaintenanceRequest::with('user')->latest()->take(20)->get();
                return [
                    'name' => 'تقرير الصيانة',
                    'headers' => ['رقم الطلب', 'الساكن', 'النوع', 'الحالة', 'التاريخ'],
                    'rows' => $requests->map(fn($r) => [
                        'M' . str_pad($r->id, 3, '0', STR_PAD_LEFT),
                        $r->user->name ?? '-',
                        $r->category ?? '-',
                        $r->status_label ?? '-',
                        $r->created_at?->format('Y-m-d')
                    ])->toArray()
                ];
            case 'summary':
                return [
                    'name' => 'ملخص شامل',
                    'headers' => ['البند', 'القيمة'],
                    'rows' => [
                        ['إجمالي المباني', Building::count()],
                        ['إجمالي الوحدات', Unit::count()],
                        ['الوحدات المؤجرة', Unit::where('status', 'occupied')->count()],
                        ['نسبة الإشغال', Unit::count() > 0 ? round((Unit::where('status', 'occupied')->count() / Unit::count()) * 100) . '%' : '0%'],
                        ['إيرادات الشهر', number_format(Payment::whereMonth('payment_date', now()->month)->sum('amount')) . ' ر.س'],
                        ['المتأخرات', number_format(Invoice::where('status', 'overdue')->sum('total_amount')) . ' ر.س'],
                    ]
                ];
            default:
                return ['name' => 'تقرير', 'headers' => [], 'rows' => []];
        }
    }

    // تصدير كملف CSV
    private function exportCSV($data, $fileName)
    {
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM
            fputcsv($file, $data['headers']);
            foreach ($data['rows'] as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '.csv"',
        ]);
    }

    // تصدير كملف PDF
    private function exportPDF($data, $fileName)
    {
        $pdf = Pdf::loadView('reports.pdf', ['data' => $data]);
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download($fileName . '.pdf');
    }
}
