<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Unit;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

// تحكم تصدير التقارير (Excel / CSV)
class ReportExportController extends Controller
{
    // تصدير تقرير المباني
    public function exportBuildings(Request $request)
    {
        $rows = [];
        $headers = ['الاسم', 'العنوان', 'عدد الوحدات', 'المؤجرة', 'الشاغرة', 'تاريخ الإنشاء'];
        
        $buildings = Building::with('units')->get();
        foreach ($buildings as $b) {
            $occupied = $b->units->where('status', 'occupied')->count();
            $available = $b->units->where('status', 'available')->count();
            $rows[] = [
                $b->name,
                $b->address,
                $b->units->count(),
                $occupied,
                $available,
                $b->created_at->format('Y-m-d')
            ];
        }

        return $this->processExport($request, 'تقرير المباني', $headers, $rows, 'buildings_report');
    }

    // تصدير تقرير الوحدات
    public function exportUnits(Request $request)
    {
        $rows = [];
        $headers = ['رقم الوحدة', 'المبنى', 'النوع', 'الحالة', 'الإيجار الشهري'];
        
        $units = Unit::with('building')->get();
        foreach ($units as $u) {
            $rows[] = [
                $u->unit_number,
                $u->building->name ?? '-',
                $u->type,
                $u->status,
                $u->amount
            ];
        }

        return $this->processExport($request, 'تقرير الوحدات', $headers, $rows, 'units_report');
    }

    // تصدير تقرير العقود
    public function exportContracts(Request $request)
    {
        $rows = [];
        $headers = ['رقم العقد', 'المستأجر', 'الوحدة', 'المبنى', 'تاريخ البدء', 'تاريخ الانتهاء', 'الإيجار', 'الحالة'];
        
        $contracts = Contract::with(['unit.building', 'tenant'])->get();
        foreach ($contracts as $c) {
            $rows[] = [
                $c->contract_number,
                $c->tenant->name ?? '-',
                $c->unit->unit_number ?? '-',
                $c->unit->building->name ?? '-',
                $c->start_date,
                $c->end_date,
                $c->amount,
                $c->status
            ];
        }

        return $this->processExport($request, 'تقرير العقود', $headers, $rows, 'contracts_report');
    }

    // تصدير تقرير الفواتير
    public function exportInvoices(Request $request)
    {
        $rows = [];
        $headers = ['رقم السند', 'المستأجر', 'الوحدة', 'المبلغ', 'تاريخ الاستحقاق', 'الحالة'];
        
        $invoices = Invoice::with(['unit', 'tenant'])->get();
        foreach ($invoices as $i) {
            $rows[] = [
                $i->invoice_number,
                $i->tenant->name ?? '-',
                $i->unit->unit_number ?? '-',
                $i->total_amount,
                $i->due_date,
                $i->status
            ];
        }

        return $this->processExport($request, 'تقرير الفواتير', $headers, $rows, 'invoices_report');
    }

    // تصدير تقرير المدفوعات
    public function exportPayments(Request $request)
    {
        $rows = [];
        $headers = ['رقم الإيصال', 'المستأجر', 'المبلغ', 'طريقة الدفع', 'تاريخ الدفع', 'الحالة'];
        
        $payments = Payment::with(['tenant', 'invoice'])->get();
        foreach ($payments as $p) {
            $rows[] = [
                $p->receipt_number,
                $p->tenant->name ?? '-',
                $p->amount,
                $p->payment_method,
                $p->payment_date,
                $p->status
            ];
        }

        return $this->processExport($request, 'تقرير المدفوعات', $headers, $rows, 'payments_report');
    }

    // تصدير الملخص المالي
    public function exportFinancialSummary(Request $request)
    {
        $headers = ['البند', 'القيمة'];
        $rows = [
            ['إجمالي الإيرادات', Payment::where('status', 'completed')->sum('amount')],
            ['فواتير معلقة', Invoice::where('status', 'pending')->sum('total_amount')],
            ['فواتير متأخرة', Invoice::where('status', 'overdue')->sum('total_amount')],
            ['عقود نشطة', Contract::where('status', 'active')->count()],
        ];

        return $this->processExport($request, 'الملخص المالي', $headers, $rows, 'financial_summary');
    }

    // تصدير تقرير المستخدمين
    public function exportUsers(Request $request)
    {
        $rows = [];
        $headers = ['الاسم', 'البريد الإلكتروني', 'الهاتف', 'الدور', 'تاريخ التسجيل'];
        
        $users = User::all();
        foreach ($users as $u) {
            $role = $u->roles->first()->name ?? '-';
            $rows[] = [
                $u->name,
                $u->email,
                $u->phone,
                $role,
                $u->created_at->format('Y-m-d')
            ];
        }

        return $this->processExport($request, 'تقرير المستخدمين', $headers, $rows, 'users_report');
    }

    // معالجة التصدير (تحديد الصيغة: CSV أو PDF)
    private function processExport(Request $request, $title, $headers, $rows, $filename)
    {
        $format = $request->input('format', 'csv');

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf_template', [
                'title' => $title,
                'headers' => $headers,
                'rows' => $rows
            ]);
            // Support Arabic in PDF using standard fonts if configured, 
            // otherwise 'DejaVu Sans' in template should handle it.
            return $pdf->download($filename . '.pdf');
        }

        // Default to CSV
        $content = implode(',', $headers) . "\n";
        foreach ($rows as $row) {
            $content .= implode(',', array_map(fn($item) => '"' . str_replace('"', '""', $item) . '"', $row)) . "\n";
        }

        return $this->downloadCsv($content, $filename . '.csv');
    }

    private function downloadCsv($content, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        
        // Add BOM for Excel UTF-8 compatibility
        $content = "\xEF\xBB\xBF" . $content;
        
        return Response::make($content, 200, $headers);
    }
}
