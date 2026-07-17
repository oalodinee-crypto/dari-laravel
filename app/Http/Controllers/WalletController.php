<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// تحكم المحفظة الإلكترونية
class WalletController extends Controller
{
    // عرض رصيد المحفظة وسجل العمليات
    public function index()
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0, 'status' => 'active']
        );

        $transactions = $wallet->transactions()->latest()->paginate(10);
        
        return view('wallets.index', compact('wallet', 'transactions'));
    }

    // إيداع رصيد
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            $wallet = Wallet::firstOrCreate(
                ['user_id' => auth()->id()],
                ['balance' => 0, 'status' => 'active']
            );
            
            $balanceBefore = $wallet->balance;
            $balanceAfter = $balanceBefore + $request->amount;
            
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'user_id' => auth()->id(),
                'type' => 'credit',
                'amount' => $request->amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'إيداع رصيد عبر البطاقة',
            ]);

            $wallet->update(['balance' => $balanceAfter]);

            DB::commit();
            return back()->with('success', 'تم إيداع المبلغ بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Wallet deposit error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء عملية الإيداع: ' . $e->getMessage());
        }
    }

    // سحب رصيد
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
        ]);

        try {
            $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();

            if ($wallet->balance < $request->amount) {
                return back()->with('error', 'رصيد المحفظة غير كافٍ');
            }

            DB::beginTransaction();

            $balanceBefore = $wallet->balance;
            $balanceAfter = $balanceBefore - $request->amount;

            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'user_id' => auth()->id(),
                'type' => 'debit',
                'amount' => $request->amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => 'طلب سحب رصيد',
            ]);

            $wallet->update(['balance' => $balanceAfter]);

            DB::commit();
            return back()->with('success', 'تم خصم المبلغ وجاري معالجة طلب السحب');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Wallet withdraw error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء عملية السحب: ' . $e->getMessage());
        }
    }
}