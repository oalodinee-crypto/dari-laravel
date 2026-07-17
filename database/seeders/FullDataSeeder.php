<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Unit;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\Complaint;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FullDataSeeder extends Seeder
{
    public function run(): void
    {
        $residents = User::role('Resident')->get();
        $units = Unit::where('status', 'occupied')->orWhere('status', 'available')->take(10)->get();
        
        // إنشاء عقود إيجار للسكان وتحديث حالة الوحدات
        // Create Contracts
        $contracts = [];
        foreach ($residents as $index => $resident) {
            if (isset($units[$index])) {
                $unit = $units[$index];
                $unit->update(['status' => 'occupied']);
                
                $contract = Contract::create([
                    'contract_number' => 'CON-' . date('Y') . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'unit_id' => $unit->id,
                    'tenant_id' => $resident->id,
                    'created_by' => User::role('Manager')->first()->id ?? 1,
                    'start_date' => Carbon::now()->subMonths(rand(1, 6)),
                    'end_date' => Carbon::now()->addMonths(rand(6, 12)),
                    'amount' => $unit->rent_amount ?? rand(50000, 100000),
                    'security_deposit' => 100000,
                    'payment_frequency' => 'monthly',
                    'type' => 'rent',
                    'status' => 'active',
                    'terms' => 'شروط العقد القياسية',
                ]);
                $contracts[] = $contract;
            }
        }

        // إنشاء فواتير (بعضها مدفوع وبعضها متأخر)
        // Create Invoices
        $invoiceStatuses = ['pending', 'paid', 'overdue', 'paid', 'pending'];
        foreach ($contracts as $index => $contract) {
            for ($i = 1; $i <= 3; $i++) {
                $status = $invoiceStatuses[array_rand($invoiceStatuses)];
                $invoice = Invoice::create([
                    'invoice_number' => 'INV-' . date('Y') . '-' . str_pad(($index * 3) + $i, 4, '0', STR_PAD_LEFT),
                    'contract_id' => $contract->id,
                    'tenant_id' => $contract->tenant_id,
                    'unit_id' => $contract->unit_id,
                    'created_by' => User::role('Manager')->first()->id ?? 1,
                    'amount' => $contract->amount,
                    'total_amount' => $contract->amount,
                    'type' => 'rent',
                    'issue_date' => Carbon::now()->subMonths(3 - $i),
                    'due_date' => Carbon::now()->subMonths(3 - $i)->addDays(15),
                    'status' => $status,
                    'description' => 'فاتورة إيجار شهر ' . Carbon::now()->subMonths(3 - $i)->translatedFormat('F Y'),
                ]);

                // إنشاء سندات دفع للفواتير المدفوعة
                // Create Payments for paid invoices
                if ($status === 'paid') {
                    Payment::create([
                        'payment_number' => 'PAY-' . date('Y') . '-' . str_pad(rand(100, 999), 4, '0', STR_PAD_LEFT),
                        'invoice_id' => $invoice->id,
                        'tenant_id' => $contract->tenant_id,
                        'amount' => $invoice->amount,
                        'payment_date' => $invoice->due_date->subDays(rand(1, 5)),
                        'method' => ['cash', 'bank_transfer', 'check'][array_rand(['cash', 'bank_transfer', 'check'])],
                        'status' => 'completed',
                        'notes' => 'تم السداد بنجاح',
                    ]);
                }
            }
        }

        // إنشاء طلبات صيانة عشوائية
        // Create Maintenance Requests
        $maintenanceTypes = ['plumbing', 'electrical', 'ac', 'general'];
        $maintenanceTitles = [
            'تسريب مياه في الحمام',
            'عطل في المكيف',
            'مشكلة في الكهرباء',
            'إصلاح باب المدخل',
            'صيانة السخان',
            'تسريب في المطبخ',
        ];
        $priorities = ['low', 'medium', 'high'];
        $statuses = ['pending', 'in_progress', 'completed', 'pending'];

        foreach ($residents as $resident) {
            $contract = Contract::where('tenant_id', $resident->id)->first();
            if ($contract) {
                MaintenanceRequest::create([
                    'title' => $maintenanceTitles[array_rand($maintenanceTitles)],
                    'description' => 'يرجى إصلاح المشكلة في أقرب وقت ممكن',
                    'priority' => $priorities[array_rand($priorities)],
                    'status' => $statuses[array_rand($statuses)],
                    'user_id' => $resident->id,
                    'property_id' => 1,
                    'unit_id' => $contract->unit_id,
                ]);
            }
        }

        // إنشاء شكاوى ومقترحات
        // Create Complaints
        $complaintTypes = ['complaint', 'suggestion'];
        $complaintTitles = [
            'شكوى ضوضاء من الجيران',
            'تأخر في الصيانة',
            'مشكلة مع الجار',
            'اقتراح تحسين الخدمات',
            'شكوى النظافة العامة',
        ];

        foreach ($residents->take(3) as $resident) {
            $contract = Contract::where('tenant_id', $resident->id)->first();
            if ($contract) {
                Complaint::create([
                    'title' => $complaintTitles[array_rand($complaintTitles)],
                    'description' => 'نرجو النظر في هذا الموضوع والتعامل معه',
                    'type' => $complaintTypes[array_rand($complaintTypes)],
                    'status' => ['pending', 'in_progress', 'resolved'][array_rand(['pending', 'in_progress', 'resolved'])],
                    'user_id' => $resident->id,
                    'priority' => $priorities[array_rand($priorities)],
                ]);
            }
        }
    }
}
