<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// تحكم البوت الذكي (مساعد داري)
class ChatbotController extends Controller
{
    private $apiKey;
    private $systemPrompt;

    // تهيئة البوت وتحديد التعليمات الأساسية (System Prompt)
    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        
        $this->systemPrompt = "أنت مساعد داري الذكي، مساعد افتراضي لنظام إدارة العقارات السكنية.

معلومات عنك:
- اسمك: مساعد داري
- تعمل في نظام داري لإدارة المباني السكنية
- تساعد السكان في استفساراتهم

معلومات التواصل:
- هاتف الإدارة: 773157823
- البريد: Waleedalansi2023@gmail.com
- أوقات العمل: 8 صباحاً - 5 مساءً

الخدمات المتوفرة للسكان:
1. دفع الإيجار والفواتير (صفحة فواتيري)
2. طلبات الصيانة (صفحة طلبات الصيانة)
3. تقديم الشكاوى والاقتراحات (صفحة الشكاوى)
4. معلومات العقد والوحدة (صفحة وحدتي)
5. التواصل مع المالك (صفحة الرسائل)

قواعد الرد:
- رد بالعربية دائماً
- كن ودوداً ومختصراً
- استخدم الإيموجي باعتدال
- وجه المستخدم للصفحة المناسبة
- للطوارئ: وجه للاتصال المباشر
- إذا لم تعرف الإجابة، اقترح التواصل مع الإدارة";
    }

    // معالجة المحادثة مع المستخدم
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->input('message');
        $user = auth()->user();
        
        // إضافة سياق المستخدم
        $context = "معلومات الساكن الحالي:\n";
        $context .= "- الاسم: {$user->name}\n";
        
        // جلب معلومات الوحدة إن وجدت
        $contract = $user->contracts()->with('unit.building')->first();
        if ($contract && $contract->unit) {
            $context .= "- الوحدة: {$contract->unit->unit_number}\n";
            $context .= "- المبنى: {$contract->unit->building->name}\n";
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$this->apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $this->systemPrompt . "\n\n" . $context . "\n\nرسالة المستخدم: " . $userMessage]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 500,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'عذراً، حدث خطأ. حاول مرة أخرى.';
                
                return response()->json([
                    'success' => true,
                    'reply' => $reply
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'reply' => 'عذراً، الخدمة غير متاحة حالياً. تواصل مع الإدارة مباشرة على 773157823'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'reply' => 'عذراً، حدث خطأ. يرجى المحاولة لاحقاً أو التواصل مع الإدارة.'
            ]);
        }
    }
}
