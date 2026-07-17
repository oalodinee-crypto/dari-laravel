<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة - {{ $invoice->invoice_number }}</title>
    <style>
        * { font-family: 'Arial', sans-serif; }
        body { padding: 40px; direction: rtl; }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #059669; padding-bottom: 20px; margin-bottom: 30px; }
        .logo h1 { color: #059669; margin: 0; }
        .invoice-info { text-align: left; }
        .invoice-number { font-size: 24px; font-weight: bold; color: #059669; }
        .section { margin-bottom: 25px; }
        .section-title { font-weight: bold; color: #333; margin-bottom: 10px; font-size: 16px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .info-box { background: #f9f9f9; padding: 15px; border-radius: 8px; }
        .info-box h4 { margin: 0 0 10px 0; color: #059669; }
        .info-box p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #059669; color: white; padding: 12px; text-align: right; }
        td { border: 1px solid #ddd; padding: 12px; text-align: right; }
        .total-row { background: #f0fdf4; font-weight: bold; }
        .total-row td { font-size: 18px; color: #059669; }
        .status { display: inline-block; padding: 5px 15px; border-radius: 20px; font-size: 14px; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
        .footer { text-align: center; margin-top: 40px; color: #888; font-size: 12px; border-top: 1px solid #ddd; padding-top: 15px; }
        @media print { body { padding: 20px; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h1>نظام داري</h1>
            <p>لإدارة العقارات</p>
        </div>
        <div class="invoice-info">
            <div class="invoice-number">فاتورة #{{ $invoice->invoice_number }}</div>
            <p>التاريخ: {{ $invoice->created_at?->format('Y-m-d') }}</p>
            <p>تاريخ الاستحقاق: {{ $invoice->due_date?->format('Y-m-d') }}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-box">
            <h4>بيانات المستأجر</h4>
            <p><strong>الاسم:</strong> {{ $invoice->tenant->name ?? '-' }}</p>
            <p><strong>الهاتف:</strong> {{ $invoice->tenant->phone ?? '-' }}</p>
            <p><strong>البريد:</strong> {{ $invoice->tenant->email ?? '-' }}</p>
        </div>
        <div class="info-box">
            <h4>بيانات الوحدة</h4>
            <p><strong>المبنى:</strong> {{ $invoice->unit->building->name ?? '-' }}</p>
            <p><strong>الوحدة:</strong> {{ $invoice->unit->unit_number ?? '-' }}</p>
            <p><strong>العنوان:</strong> {{ $invoice->unit->building->address ?? '-' }}</p>
        </div>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr><th>البند</th><th>الوصف</th><th>المبلغ</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>إيجار شهري</td>
                    <td>إيجار شهر {{ $invoice->created_at?->format('F Y') }}</td>
                    <td>{{ number_format($invoice->total_amount) }} ر.ي</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">الإجمالي</td>
                    <td>{{ number_format($invoice->total_amount) }} ر.ي</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section" style="text-align: center;">
        <p>حالة الفاتورة: 
            @if($invoice->status == 'paid')
                <span class="status status-paid">مدفوعة</span>
            @elseif($invoice->status == 'overdue')
                <span class="status status-overdue">متأخرة</span>
            @else
                <span class="status status-pending">معلقة</span>
            @endif
        </p>
    </div>

    <div class="footer">
        <p>شكراً لتعاملكم معنا - نظام داري لإدارة العقارات</p>
        <p>تاريخ الطباعة: {{ now()->format('Y-m-d H:i') }}</p>
    </div>
</body>
</html>
