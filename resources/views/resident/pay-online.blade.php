@extends('layouts.app')

@section('title', 'الدفع الإلكتروني')
@section('page-title', 'الدفع عبر المحافظ الإلكترونية')

@section('content')
<div class="container-fluid">
    
    <!-- قسم المحافظ الإلكترونية - تمرير أفقي -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3"><i class="bi bi-wallet2 me-2"></i>اختر المحفظة الإلكترونية</h5>
            <div class="wallets-scroll-container">
                <div class="wallets-scroll d-flex flex-nowrap gap-3 pb-2">
                    
                    <!-- جيب Jaib -->
                    <div class="wallet-card-item" onclick="selectWallet(this, 'jaib')">
                        <div class="wallet-logo" style="background: linear-gradient(135deg, #00A651 0%, #008C44 100%);">
                            <span class="text-white fw-bold fs-5">جيب</span>
                        </div>
                        <h6 class="mb-0 mt-2">جيب</h6>
                        <small class="text-muted">Jaib</small>
                    </div>

                    <!-- جوالي Jawali -->
                    <div class="wallet-card-item" onclick="selectWallet(this, 'jawali')">
                        <div class="wallet-logo" style="background: linear-gradient(135deg, #E31E24 0%, #B71C1C 100%);">
                            <span class="text-white fw-bold fs-6">جوالي</span>
                        </div>
                        <h6 class="mb-0 mt-2">جوالي</h6>
                        <small class="text-muted">Jawali</small>
                    </div>

                    <!-- ون كاش One Cash -->
                    <div class="wallet-card-item" onclick="selectWallet(this, 'onecash')">
                        <div class="wallet-logo" style="background: linear-gradient(135deg, #FF6B00 0%, #E65100 100%);">
                            <span class="text-white fw-bold fs-6">1Cash</span>
                        </div>
                        <h6 class="mb-0 mt-2">ون كاش</h6>
                        <small class="text-muted">One Cash</small>
                    </div>

                    <!-- موبايل مني Mobile Money -->
                    <div class="wallet-card-item" onclick="selectWallet(this, 'mobilemoney')">
                        <div class="wallet-logo" style="background: linear-gradient(135deg, #1976D2 0%, #0D47A1 100%);">
                            <span class="text-white fw-bold" style="font-size: 9px;">Mobile<br>Money</span>
                        </div>
                        <h6 class="mb-0 mt-2">موبايل مني</h6>
                        <small class="text-muted">Mobile Money</small>
                    </div>

                    <!-- يمن والت Yemen Wallet -->
                    <div class="wallet-card-item" onclick="selectWallet(this, 'yemenwallet')">
                        <div class="wallet-logo" style="background: linear-gradient(135deg, #7B1FA2 0%, #4A148C 100%);">
                            <span class="text-white fw-bold" style="font-size: 9px;">Yemen<br>Wallet</span>
                        </div>
                        <h6 class="mb-0 mt-2">يمن والت</h6>
                        <small class="text-muted">Yemen Wallet</small>
                    </div>

                    <!-- كاش نقدي -->
                    <div class="wallet-card-item" onclick="selectWallet(this, 'cash')">
                        <div class="wallet-logo" style="background: linear-gradient(135deg, #607D8B 0%, #455A64 100%);">
                            <i class="bi bi-cash text-white fs-4"></i>
                        </div>
                        <h6 class="mb-0 mt-2">نقدي</h6>
                        <small class="text-muted">Cash</small>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- قسم أنواع الفواتير -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="mb-3"><i class="bi bi-receipt me-2"></i>اختر نوع الفاتورة</h5>
        </div>
        
        <!-- الإيجار -->
        <div class="col-6 col-md-4 col-lg-2 mb-3">
            <div class="card payment-type-card h-100" onclick="selectPaymentType(this, 'rent')">
                <div class="card-body text-center p-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-block mb-2">
                        <i class="bi bi-house-door fs-3 text-primary"></i>
                    </div>
                    <h6 class="mb-1">الإيجار</h6>
                    <p class="text-muted small mb-0">إيجار الوحدة</p>
                </div>
            </div>
        </div>
        
        <!-- الكهرباء -->
        <div class="col-6 col-md-4 col-lg-2 mb-3">
            <div class="card payment-type-card h-100" onclick="selectPaymentType(this, 'electricity')">
                <div class="card-body text-center p-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 d-inline-block mb-2">
                        <i class="bi bi-lightning-charge fs-3 text-warning"></i>
                    </div>
                    <h6 class="mb-1">الكهرباء</h6>
                    <p class="text-muted small mb-0">فاتورة الكهرباء</p>
                </div>
            </div>
        </div>
        
        <!-- الماء -->
        <div class="col-6 col-md-4 col-lg-2 mb-3">
            <div class="card payment-type-card h-100" onclick="selectPaymentType(this, 'water')">
                <div class="card-body text-center p-3">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 d-inline-block mb-2">
                        <i class="bi bi-droplet fs-3 text-info"></i>
                    </div>
                    <h6 class="mb-1">الماء</h6>
                    <p class="text-muted small mb-0">فاتورة المياه</p>
                </div>
            </div>
        </div>
        
        <!-- الصيانة -->
        <div class="col-6 col-md-4 col-lg-2 mb-3">
            <div class="card payment-type-card h-100" onclick="selectPaymentType(this, 'maintenance')">
                <div class="card-body text-center p-3">
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 d-inline-block mb-2">
                        <i class="bi bi-tools fs-3 text-danger"></i>
                    </div>
                    <h6 class="mb-1">الصيانة</h6>
                    <p class="text-muted small mb-0">رسوم الصيانة</p>
                </div>
            </div>
        </div>
        
        <!-- صيانة الوحدة (بدلاً من الغاز) -->
        <div class="col-6 col-md-4 col-lg-2 mb-3">
            <div class="card payment-type-card h-100" onclick="selectPaymentType(this, 'unit_maintenance')">
                <div class="card-body text-center p-3">
                    <div class="rounded-circle bg-secondary bg-opacity-10 p-3 d-inline-block mb-2">
                        <i class="bi bi-wrench-adjustable fs-3 text-secondary"></i>
                    </div>
                    <h6 class="mb-1">صيانة الوحدة</h6>
                    <p class="text-muted small mb-0">إصلاحات الوحدة</p>
                </div>
            </div>
        </div>
        
        <!-- أخرى -->
        <div class="col-6 col-md-4 col-lg-2 mb-3">
            <div class="card payment-type-card h-100" onclick="selectPaymentType(this, 'other')">
                <div class="card-body text-center p-3">
                    <div class="rounded-circle bg-dark bg-opacity-10 p-3 d-inline-block mb-2">
                        <i class="bi bi-three-dots fs-3 text-dark"></i>
                    </div>
                    <h6 class="mb-1">أخرى</h6>
                    <p class="text-muted small mb-0">دفعات أخرى</p>
                </div>
            </div>
        </div>
    </div>

    <!-- الفواتير المستحقة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-file-text me-2"></i>الفواتير المستحقة</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 50px;">اختر</th>
                                    <th>رقم الفاتورة</th>
                                    <th>النوع</th>
                                    <th>الوصف</th>
                                    <th>المبلغ</th>
                                    <th>تاريخ الاستحقاق</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody id="billsTableBody">
                                <tr>
                                    <td><input type="checkbox" class="form-check-input bill-checkbox" value="50000" data-bill="INV-001"></td>
                                    <td>INV-2025-001</td>
                                    <td><span class="badge bg-primary">إيجار</span></td>
                                    <td>إيجار شهر يناير 2025</td>
                                    <td class="fw-bold">50,000 ر.ي</td>
                                    <td>2025-01-15</td>
                                    <td><span class="badge bg-danger">متأخر</span></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input bill-checkbox" value="5000" data-bill="INV-002"></td>
                                    <td>INV-2025-002</td>
                                    <td><span class="badge bg-warning text-dark">كهرباء</span></td>
                                    <td>استهلاك ديسمبر 2024</td>
                                    <td class="fw-bold">5,000 ر.ي</td>
                                    <td>2025-01-10</td>
                                    <td><span class="badge bg-warning text-dark">قريب</span></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" class="form-check-input bill-checkbox" value="2000" data-bill="INV-003"></td>
                                    <td>INV-2025-003</td>
                                    <td><span class="badge bg-info">ماء</span></td>
                                    <td>استهلاك ديسمبر 2024</td>
                                    <td class="fw-bold">2,000 ر.ي</td>
                                    <td>2025-01-12</td>
                                    <td><span class="badge bg-success">جديد</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label class="form-label mb-0">العملة:</label>
                            <select class="form-select form-select-sm d-inline-block w-auto ms-2" id="currencySelect" onchange="updateCurrency()">
                                <option value="YER" selected>ر.ي (ريال يمني)</option>
                                <option value="SAR">ر.س (ريال سعودي)</option>
                                <option value="USD">$ (دولار)</option>
                            </select>
                        </div>
                        <div class="col-md-8 text-end">
                            <span class="fs-5">المجموع المحدد: </span>
                            <span class="fs-4 fw-bold text-success" id="totalSelected">0 ر.ي</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نموذج الدفع -->
    <div class="row" id="paymentFormSection" style="display: none;">
        <div class="col-lg-6 mb-4">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-credit-card me-2"></i>تأكيد الدفع</h6>
                </div>
                <div class="card-body">
                    <form id="paymentForm">
                        <div class="mb-3">
                            <label class="form-label">المحفظة المختارة</label>
                            <input type="text" class="form-control" id="selectedWalletName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف / المحفظة</label>
                            <input type="tel" class="form-control" id="walletPhone" placeholder="مثال: 771234567" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">المبلغ</label>
                            <input type="text" class="form-control fw-bold text-success" id="paymentAmount" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ملاحظات (اختياري)</label>
                            <textarea class="form-control" id="paymentNotes" rows="2" placeholder="أي ملاحظات إضافية..."></textarea>
                        </div>
                        <div class="alert alert-info small">
                            <i class="bi bi-info-circle me-2"></i>
                            سيتم إرسال طلب الدفع إلى محفظتك. يرجى تأكيد العملية من تطبيق المحفظة.
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-lg">
                            <i class="bi bi-check-circle me-2"></i>تأكيد الدفع
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-list-check me-2"></i>ملخص الطلب</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>نوع الفاتورة:</span>
                        <span class="fw-bold" id="summaryType">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>عدد الفواتير:</span>
                        <span class="fw-bold" id="summaryCount">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>المحفظة:</span>
                        <span class="fw-bold" id="summaryWallet">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>العملة:</span>
                        <span class="fw-bold" id="summaryCurrency">ريال يمني</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fs-5">الإجمالي:</span>
                        <span class="fs-4 fw-bold text-success" id="summaryTotal">0 ر.ي</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body p-5">
                <div class="rounded-circle bg-success bg-opacity-10 p-4 d-inline-block mb-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h4 class="mb-3">تم إرسال طلب الدفع</h4>
                <p class="text-muted mb-4">سيتم إشعارك عند اكتمال العملية. يرجى تأكيد الدفع من تطبيق المحفظة.</p>
                <button class="btn btn-success" data-bs-dismiss="modal">حسناً</button>
            </div>
        </div>
    </div>
</div>

<style>
/* تنسيق المحافظ مع التمرير الأفقي */
.wallets-scroll-container {
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: #ccc #f5f5f5;
}

.wallets-scroll-container::-webkit-scrollbar {
    height: 6px;
}

.wallets-scroll-container::-webkit-scrollbar-track {
    background: #f5f5f5;
    border-radius: 3px;
}

.wallets-scroll-container::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

.wallet-card-item {
    flex: 0 0 auto;
    min-width: 120px;
    background: #fff;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 15px 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.wallet-card-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-color: #dee2e6;
}

.wallet-card-item.selected {
    border-color: #198754;
    background: linear-gradient(135deg, rgba(25,135,84,0.05) 0%, rgba(25,135,84,0.1) 100%);
    box-shadow: 0 4px 15px rgba(25,135,84,0.2);
}

.wallet-card-item.selected::after {
    content: '\2713';
    position: absolute;
    top: 5px;
    left: 5px;
    background: #198754;
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.wallet-card-item {
    position: relative;
}

.wallet-logo {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

/* تنسيق بطاقات أنواع الفواتير */
.payment-type-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.payment-type-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.payment-type-card.selected {
    border-color: #198754;
    background: rgba(25, 135, 84, 0.05);
}

.payment-type-card.selected::before {
    content: '\2713';
    position: absolute;
    top: 10px;
    left: 10px;
    background: #198754;
    color: white;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.payment-type-card {
    position: relative;
}
</style>

<script>
let selectedType = null;
let selectedWallet = null;
let totalAmountYER = 0;
let currentCurrency = 'YER';

// أسعار الصرف (تقريبية)
const exchangeRates = {
    'YER': 1,
    'SAR': 0.0067,  // 1 YER = 0.0067 SAR
    'USD': 0.0018   // 1 YER = 0.0018 USD
};

const currencySymbols = {
    'YER': 'ر.ي',
    'SAR': 'ر.س',
    'USD': '$'
};

const currencyNames = {
    'YER': 'ريال يمني',
    'SAR': 'ريال سعودي',
    'USD': 'دولار أمريكي'
};

const walletNames = {
    'jaib': 'جيب',
    'jawali': 'جوالي',
    'onecash': 'ون كاش',
    'mobilemoney': 'موبايل مني',
    'yemenwallet': 'يمن والت',
    'cash': 'نقدي'
};

const typeNames = {
    'rent': 'إيجار',
    'electricity': 'كهرباء',
    'water': 'ماء',
    'maintenance': 'صيانة',
    'unit_maintenance': 'صيانة الوحدة',
    'other': 'أخرى'
};

function selectPaymentType(element, type) {
    document.querySelectorAll('.payment-type-card').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');
    selectedType = type;
    document.getElementById('summaryType').textContent = typeNames[type];
    checkShowPaymentForm();
}

function selectWallet(element, wallet) {
    document.querySelectorAll('.wallet-card-item').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');
    selectedWallet = wallet;
    
    document.getElementById('selectedWalletName').value = walletNames[wallet];
    document.getElementById('summaryWallet').textContent = walletNames[wallet];
    checkShowPaymentForm();
}

function checkShowPaymentForm() {
    if (selectedWallet && totalAmountYER > 0) {
        document.getElementById('paymentFormSection').style.display = 'flex';
    }
}

function updateCurrency() {
    currentCurrency = document.getElementById('currencySelect').value;
    document.getElementById('summaryCurrency').textContent = currencyNames[currentCurrency];
    updateTotal();
}

function updateTotal() {
    let total = 0;
    let count = 0;
    document.querySelectorAll('.bill-checkbox:checked').forEach(cb => {
        total += parseInt(cb.value);
        count++;
    });
    totalAmountYER = total;
    
    // تحويل العملة
    let convertedAmount = total * exchangeRates[currentCurrency];
    let formattedAmount = convertedAmount.toLocaleString('en-US', {maximumFractionDigits: 2}) + ' ' + currencySymbols[currentCurrency];
    
    document.getElementById('totalSelected').textContent = formattedAmount;
    document.getElementById('paymentAmount').value = formattedAmount;
    document.getElementById('summaryTotal').textContent = formattedAmount;
    document.getElementById('summaryCount').textContent = count;
    
    checkShowPaymentForm();
}

// Event listeners
document.querySelectorAll('.bill-checkbox').forEach(cb => {
    cb.addEventListener('change', updateTotal);
});

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    new bootstrap.Modal(document.getElementById('successModal')).show();
});

// تحديث المجموع عند التحميل
updateTotal();
</script>
@endsection
