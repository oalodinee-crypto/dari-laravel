<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>عقد إيجار - {{ $contract->contract_number }}</title>
    <style>
        * { font-family: 'Arial', sans-serif; }
        body { padding: 40px; direction: rtl; }
        .header { text-align: center; border-bottom: 3px solid #1e40af; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #1e40af; margin: 0; }
        .header p { color: #666; margin: 5px 0; }
        .section { margin-bottom: 25px; }
        .section-title { background: #1e40af; color: white; padding: 8px 15px; font-weight: bold; margin-bottom: 15px; }
        .row { display: flex; margin-bottom: 10px; }
        .label { width: 150px; font-weight: bold; color: #333; }
        .value { flex: 1; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: right; }
        th { background: #f5f5f5; }
        .signatures { display: flex; justify-content: space-between; margin-top: 50px; }
        .signature-box { width: 45%; text-align: center; }
        .signature-line { border-top: 1px solid #333; margin-top: 60px; padding-top: 10px; }
        .footer { text-align: center; margin-top: 40px; color: #888; font-size: 12px; border-top: 1px solid #ddd; padding-top: 15px; }
        @media print { body { padding: 20px; } }
    </style>
</head>
<body>
    <div class="header">
        <h1>نظام داري لإدارة العقارات</h1>
        <p>عقد إيجار رقم: {{ $contract->contract_number }}</p>
    </div>

    <div class="section">
        <div class="section-title">بيانات العقد</div>
        <div class="row"><span class="label">رقم العقد:</span><span class="value">{{ $contract->contract_number }}</span></div>
        <div class="row"><span class="label">تاريخ البدء:</span><span class="value">{{ $contract->start_date?->format('Y-m-d') }}</span></div>
        <div class="row"><span class="label">تاريخ الانتهاء:</span><span class="value">{{ $contract->end_date?->format('Y-m-d') }}</span></div>
        <div class="row"><span class="label">الإيجار الشهري:</span><span class="value">{{ number_format($contract->amount) }} ر.ي</span></div>
        <div class="row"><span class="label">الحالة:</span><span class="value">{{ $contract->status == 'active' ? 'نشط' : 'منتهي' }}</span></div>
    </div>

    <div class="section">
        <div class="section-title">بيانات الوحدة</div>
        <div class="row"><span class="label">المبنى:</span><span class="value">{{ $contract->unit->building->name ?? '-' }}</span></div>
        <div class="row"><span class="label">رقم الوحدة:</span><span class="value">{{ $contract->unit->unit_number ?? '-' }}</span></div>
        <div class="row"><span class="label">النوع:</span><span class="value">{{ $contract->unit->type ?? '-' }}</span></div>
    </div>

    <div class="section">
        <div class="section-title">أطراف العقد</div>
        <table>
            <tr><th>الطرف</th><th>الاسم</th><th>الهاتف</th><th>البريد</th></tr>
            <tr>
                <td>المؤجر</td>
                <td>{{ $contract->owner->name ?? '-' }}</td>
                <td>{{ $contract->owner->phone ?? '-' }}</td>
                <td>{{ $contract->owner->email ?? '-' }}</td>
            </tr>
            <tr>
                <td>المستأجر</td>
                <td>{{ $contract->tenant->name ?? '-' }}</td>
                <td>{{ $contract->tenant->phone ?? '-' }}</td>
                <td>{{ $contract->tenant->email ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">توقيع المؤجر</div>
        </div>
        <div class="signature-box">
            <div class="signature-line">توقيع المستأجر</div>
        </div>
    </div>

    <div class="footer">
        <p>تم إنشاء هذا العقد بواسطة نظام داري لإدارة العقارات</p>
        <p>تاريخ الطباعة: {{ now()->format('Y-m-d H:i') }}</p>
    </div>
</body>
</html>
