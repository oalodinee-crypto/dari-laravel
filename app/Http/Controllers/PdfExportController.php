<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

// تحكم تصدير PDF (عقود، فواتير، سندات)
class PdfExportController extends Controller
{
    /**
     * Export contract as printable PDF view
     */
    /**
     * تصدير العقد كملف PDF
     */
    public function exportContract($id)
    {
        try {
            $contract = Contract::with(['unit.building', 'tenant', 'owner'])->find($id);
            
            if (!$contract) {
                return back()->with('error', 'العقد غير موجود');
            }
            
            return view('pdf.contract', compact('contract'));
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحميل العقد');
        }
    }

    /**
     * Export invoice as printable PDF view
     */
    /**
     * تصدير الفاتورة كملف PDF
     */
    public function exportInvoice($id)
    {
        try {
            $invoice = Invoice::with(['unit.building', 'tenant', 'contract'])->find($id);
            
            if (!$invoice) {
                return back()->with('error', 'الفاتورة غير موجودة');
            }
            
            return view('pdf.invoice', compact('invoice'));
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحميل الفاتورة');
        }
    }

    /**
     * Export payment receipt as printable PDF view
     */
    /**
     * تصدير سند القبض كملف PDF
     */
    public function exportPayment($id)
    {
        try {
            $payment = Payment::with(['invoice.unit.building', 'tenant'])->find($id);
            
            if (!$payment) {
                return back()->with('error', 'سند القبض غير موجود');
            }
            
            return view('pdf.payment', compact('payment'));
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء تحميل سند القبض');
        }
    }
}
