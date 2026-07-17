<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سند قبض - {{ $payment->payment_number ?? 'N/A' }}</title>
    <style>
        * { font-family: 'Arial', sans-serif; }
        body { padding: 40px; direction: rtl; }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #2563eb; padding-bottom: 20px; margin-bottom: 30px; }
        .logo h1 { color: #2563eb; margin: 0; }
        .receipt-info { text-align: left; }
        .receipt-number { font-size: 24px; font-weight: bold; color: #2563eb; }
        .success-badge { background: #dcfce7; color: #166534; padding: 10px 25px; border-radius: 25px; font-size: 18px; display: inline-block; margin: 20px 0; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .info-box { background: #f9f9f9; padding: 15px; border-radius: 8px; }
        .info-box h4 { margin: 0 0 10px 0; color: #2563eb; }
        .info-box p { margin: 5px 0; color: #555; }
        .amount-box { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; padding: 30px; border-radius: 15px; text-align: center; margin: 30px 0; }
        .amount-box .label { font-size: 14px; opacity: 0.9; }
        .amount-box .amount { font-size: 36px; font-weight: bold; margin: 10px 0; }
        .details { background: #f8fafc; padding: 20px; border-radius: 10px; }
        .details-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e2e8f0; }
        .details-row:last-child { border-bottom: none; }
        .footer { text-align: center; margin-top: 40px; color: #888; font-size: 12px; border-top: 1px solid #ddd; padding-top: 15px; }
        .signature-area { display: flex; justify-content: space-between; margin-top: 50px; }
        .signature-box { width: 45%; text-align: center; }
        .signature-line { border-top: 1px solid #333; margin-top: 60px; padding-top: 10px; }
        @media print { body { padding: 20px; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h1>نظام داري</h1>
            <p>لإدارة العقارات</p>
        </div>
        <div class="receipt-info">
            <div class="receipt-number">سند قبض #{{ $payment->payment_number ?? 'N/A' }}</div>
            <p>التاريخ: {{ $payment->payment_date?->format('Y-m-d') ?? now()->format('Y-m-d') }}</p>
        </div>
    </div>

    <div style="text-align: center;">
        <span class="success-badge">✓ تم الدفع بنجاح</span>
    </div>

    <div class="info-grid">
        <div class="info-box">
            <h4>بيانات الدافع</h4>
            <p><strong>الاسم:</strong> {{ $payment->tenant->name ?? '-' }}</p>
            <p><strong>الهاتف:</strong> {{ $payment->tenant->phone ?? '-' }}</p>
            <p><strong>البريد:</strong> {{ $payment->tenant->email ?? '-' }}</p>
        </div>
        <div class="info-box">
            <h4>بيانات الوحدة</h4>
            <p><strong>المبنى:</strong> {{ $payment->invoice->unit->building->name ?? '-' }}</p>
            <p><strong>الوحدة:</strong> {{ $payment->invoice->unit->unit_number ?? '-' }}</p>
            <p><strong>رقم الفاتورة:</strong> {{ $payment->invoice->invoice_number ?? '-' }}</p>
        </div>
    </div>

    <div class="amount-box">
        <div class="label">المبلغ المدفوع</div>
        <div class="amount">{{ number_format($payment->amount ?? 0) }} ر.ي</div>
        <div class="label">{{ $payment->amount_words ?? 'فقط ' . number_format($payment->amount ?? 0) . ' ريال يمني لا غير' }}</div>
    </div>

    <div class="details">
        <div class="details-row">
            <span>طريقة الدفع:</span>
            <span>
                @php
                    $methods = ['cash' => 'نقدي', 'bank_transfer' => 'تحويل بنكي', 'check' => 'شيك', 'wallet' => 'محفظة إلكترونية'];
                @endphp
                {{ $methods[$payment->payment_method] ?? $payment->payment_method ?? '-' }}
            </span>
        </div>
        <div class="details-row">
            <span>تاريخ الدفع:</span>
            <span>{{ $payment->payment_date?->format('Y-m-d H:i') ?? '-' }}</span>
        </div>
        <div class="details-row">
            <span>رقم المرجع:</span>
            <span>{{ $payment->reference_number ?? $payment->payment_number ?? '-' }}</span>
        </div>
        @if($payment->notes)
        <div class="details-row">
            <span>ملاحظات:</span>
            <span>{{ $payment->notes }}</span>
        </div>
        @endif
    </div>

    <div class="signature-area">
        <div class="signature-box">
            <div class="signature-line">توقيع المستلم</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">توقيع الدافع</div>
        </div>
    </div>

    <div class="footer">
        <p>هذا السند دليل على استلام المبلغ المذكور أعلاه</p>
        <p>نظام داري لإدارة العقارات - تاريخ الطباعة: {{ now()->format('Y-m-d H:i') }}</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="background: #2563eb; color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px;">
            طباعة السند
        </button>
    </div>
</body>
</html>
