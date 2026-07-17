<!-- Chatbot Widget -->
<div id="chatbot-container">
    <!-- Toggle Button -->
    <button id="chatbot-toggle" onclick="toggleChat()">
        <i class="bi bi-chat-dots-fill"></i>
    </button>
    
    <!-- Chat Window -->
    <div id="chatbot-window" class="d-none">
        <div class="chat-header">
            <div class="d-flex align-items-center gap-2">
                <div class="chat-avatar"><i class="bi bi-robot"></i></div>
                <div>
                    <strong>مساعد داري</strong>
                    <small class="d-block text-success">متصل الآن</small>
                </div>
            </div>
            <button class="btn-close btn-close-white" onclick="toggleChat()"></button>
        </div>
        
        <div id="chat-messages">
            <div class="bot-message">
                <p>مرحباً! أنا مساعد داري الذكي 🏠</p>
                <p>كيف يمكنني مساعدتك اليوم؟</p>
            </div>
            <div class="quick-replies">
                <button onclick="sendQuick('كيف أدفع الإيجار؟')">💳 دفع الإيجار</button>
                <button onclick="sendQuick('أريد طلب صيانة')">🔧 طلب صيانة</button>
                <button onclick="sendQuick('متى ينتهي عقدي؟')">📄 معلومات العقد</button>
                <button onclick="sendQuick('تواصل مع الإدارة')">📞 تواصل</button>
            </div>
        </div>
        
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="اكتب رسالتك..." onkeypress="if(event.key==='Enter')sendMessage()">
            <button onclick="sendMessage()"><i class="bi bi-send-fill"></i></button>
        </div>
    </div>
</div>

<style>
#chatbot-container { position: fixed; bottom: 20px; left: 20px; z-index: 9999; font-family: 'Segoe UI', Tahoma, sans-serif; }
#chatbot-toggle { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #1d4ed8); border: none; color: white; font-size: 24px; cursor: pointer; box-shadow: 0 4px 15px rgba(59,130,246,0.4); transition: transform 0.3s; }
#chatbot-toggle:hover { transform: scale(1.1); }
#chatbot-window { position: absolute; bottom: 70px; left: 0; width: 350px; height: 500px; background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); display: flex; flex-direction: column; overflow: hidden; }
.chat-header { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center; }
.chat-avatar { width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; }
#chat-messages { flex: 1; overflow-y: auto; padding: 15px; background: #f8fafc; }
.bot-message, .user-message { max-width: 85%; margin-bottom: 12px; padding: 12px 15px; border-radius: 16px; }
.bot-message { background: white; border: 1px solid #e2e8f0; border-radius: 16px 16px 16px 4px; }
.bot-message p { margin: 0 0 5px 0; }
.bot-message p:last-child { margin: 0; }
.user-message { background: #3b82f6; color: white; margin-left: auto; border-radius: 16px 16px 4px 16px; }
.quick-replies { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
.quick-replies button { background: #e0f2fe; border: none; padding: 8px 12px; border-radius: 20px; font-size: 13px; cursor: pointer; transition: background 0.2s; }
.quick-replies button:hover { background: #bae6fd; }
.chat-input { display: flex; padding: 10px; background: white; border-top: 1px solid #e2e8f0; }
.chat-input input { flex: 1; border: 1px solid #e2e8f0; border-radius: 25px; padding: 10px 15px; outline: none; }
.chat-input input:focus { border-color: #3b82f6; }
.chat-input button { width: 45px; height: 45px; border: none; background: #3b82f6; color: white; border-radius: 50%; margin-right: 10px; cursor: pointer; }
.typing { display: flex; gap: 4px; padding: 15px; }
.typing span { width: 8px; height: 8px; background: #94a3b8; border-radius: 50%; animation: bounce 1.4s infinite; }
.typing span:nth-child(2) { animation-delay: 0.2s; }
.typing span:nth-child(3) { animation-delay: 0.4s; }
@keyframes bounce { 0%, 60%, 100% { transform: translateY(0); } 30% { transform: translateY(-8px); } }
.action-buttons { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
.action-btn { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 8px 15px; border-radius: 20px; font-size: 13px; text-decoration: none; transition: all 0.2s; }
.action-btn:hover { transform: scale(1.05); color: white; box-shadow: 0 4px 12px rgba(59,130,246,0.4); }
</style>

<script>
// بيانات المستخدم الحالي
const userData = {
    name: '{{ auth()->user()->name ?? "الساكن" }}',
    unit: '{{ auth()->user()->contracts->first()->unit->unit_number ?? "غير محدد" }}',
    building: '{{ auth()->user()->contracts->first()->unit->building->name ?? "غير محدد" }}'
};

// قاعدة المعرفة المحسنة
const knowledgeBase = {
    // الفواتير والدفع
    payment: {
        patterns: ['الإيجار', 'دفع', 'فاتورة', 'سداد', 'مبلغ', 'متأخر', 'كم', 'المستحق', 'موعد الدفع', 'تأخير'],
        response: `💳 مرحباً ${userData.name}!\n\nلدفع الإيجار:\n1. اذهب إلى "فواتيري" من القائمة\n2. اختر الفاتورة المستحقة\n3. اضغط "دفع الآن"\n\n💡 نصيحة: يمكنك الدفع إلكترونياً أو تحويل بنكي\n\nهل تريد الانتقال لصفحة الفواتير الآن؟`,
        actions: [{text: '📄 فواتيري', url: '/resident/my-invoices'}, {text: '💰 الدفع الإلكتروني', url: '/resident/pay-online'}]
    },
    
    // الصيانة
    maintenance: {
        patterns: ['صيانة', 'إصلاح', 'عطل', 'خراب', 'تسريب', 'تكييف', 'مكيف', 'باب', 'نافذة', 'سباكة', 'كهربائي', 'مشكلة', 'لا يعمل', 'معطل'],
        response: `🔧 لطلب صيانة:\n\n1. اضغط على "طلبات الصيانة"\n2. اضغط "طلب جديد"\n3. اختر نوع المشكلة\n4. صف المشكلة بالتفصيل\n5. يمكنك إرفاق صور\n\n⏰ سيتم الرد خلال 24 ساعة\n🚨 للحالات العاجلة: اتصل مباشرة`,
        actions: [{text: '🔧 طلب صيانة', url: '/resident/my-maintenance'}, {text: '📞 اتصال طوارئ', url: 'tel:773157823'}]
    },
    
    // المياه
    water: {
        patterns: ['ماء', 'مياه', 'خزان', 'فاتورة الماء', 'انقطاع الماء', 'تسريب ماء'],
        response: '💧 بخصوص المياه:\n\n• فاتورة الماء: موجودة في "فواتيري"\n• انقطاع المياه: تحقق من الإعلانات أولاً\n• تسريب: اطلب صيانة فوراً\n• الخزان: يتم تعبئته أسبوعياً',
        actions: [{text: '🔧 طلب صيانة', url: '/resident/my-maintenance'}]
    },
    
    // الكهرباء
    electricity: {
        patterns: ['كهرباء', 'كهربا', 'فاتورة الكهرباء', 'انقطاع الكهرباء', 'عداد', 'قاطع'],
        response: '⚡ بخصوص الكهرباء:\n\n• فاتورة الكهرباء: في "فواتيري"\n• انقطاع: تحقق من القاطع الرئيسي أولاً\n• إذا استمرت المشكلة: اطلب صيانة\n• للطوارئ: اتصل فوراً',
        actions: [{text: '🔧 طلب صيانة', url: '/resident/my-maintenance'}, {text: '📞 طوارئ', url: 'tel:773157823'}]
    },
    
    // التواصل
    contact: {
        patterns: ['تواصل', 'اتصال', 'هاتف', 'إدارة', 'رقم', 'واتساب', 'رسالة', 'كلم', 'المالك'],
        response: '📞 طرق التواصل:\n\n• هاتف: 773157823\n• واتساب: 773157823\n• البريد: Waleedalansi2023@gmail.com\n• الرسائل: من خلال النظام\n\n⏰ أوقات العمل: 8ص - 5م\n🚨 الطوارئ: متاح 24 ساعة',
        actions: [{text: '✉️ إرسال رسالة', url: '/messages/create'}, {text: '📞 اتصال', url: 'tel:773157823'}]
    },
    
    // العقد
    contract: {
        patterns: ['عقد', 'انتهاء', 'تجديد', 'مدة', 'إخلاء', 'فسخ', 'شروط'],
        response: `📄 معلومات العقد:\n\n• تفاصيل عقدك في صفحة "وحدتي"\n• للتجديد: تواصل قبل الانتهاء بشهر\n• للإخلاء: أبلغ قبل شهرين\n• تعديل العقد: يتطلب موافقة الطرفين`,
        actions: [{text: '🏠 وحدتي', url: '/resident/my-unit'}, {text: '✉️ تواصل مع المالك', url: '/messages/create'}]
    },
    
    // الشكاوى
    complaints: {
        patterns: ['شكوى', 'إزعاج', 'ضوضاء', 'جيران', 'مشكلة جار', 'اقتراح', 'رأي'],
        response: '📝 لتقديم شكوى أو اقتراح:\n\n1. اذهب إلى "الشكاوى"\n2. اختر النوع (شكوى/اقتراح)\n3. اكتب التفاصيل\n4. اضغط إرسال\n\n✅ سيتم المتابعة خلال 48 ساعة',
        actions: [{text: '📝 تقديم شكوى', url: '/resident/my-complaints'}]
    },
    
    // المواقف
    parking: {
        patterns: ['موقف', 'سيارة', 'باركنج', 'جراج', 'ركن'],
        response: '🚗 المواقف:\n\n• كل وحدة لها موقف مخصص\n• رقم موقفك موجود في "وحدتي"\n• لا تركن في موقف غيرك\n• مشكلة في الموقف: قدم شكوى',
        actions: [{text: '🏠 وحدتي', url: '/resident/my-unit'}]
    },
    
    // الزوار
    visitors: {
        patterns: ['زيارة', 'ضيف', 'زائر', 'صديق', 'أهل', 'عائلة'],
        response: '👥 الزوار:\n\n• أبلغ الحارس مسبقاً\n• أوقات الزيارة: 8ص - 10م\n• الزوار يستخدمون مواقف الزوار\n• المبيت يحتاج إذن مسبق',
        actions: []
    },
    
    // الأمن
    security: {
        patterns: ['أمن', 'حارس', 'سرقة', 'طوارئ', 'حريق', 'إنذار', 'خطر'],
        response: '🚨 الأمن والطوارئ:\n\n• الحارس متواجد 24 ساعة\n• طوارئ: 773157823\n• حريق: اضغط إنذار الحريق + اتصل\n• سرقة: أبلغ فوراً + لا تلمس شيء',
        actions: [{text: '📞 طوارئ', url: 'tel:773157823'}]
    },
    
    // المصعد
    elevator: {
        patterns: ['مصعد', 'اسانسير', 'عالق', 'ليفت'],
        response: '🛗 المصعد:\n\n• عطل عادي: اطلب صيانة\n• عالق داخله: اضغط زر الطوارئ\n• اتصل: 773157823\n• لا تحاول فتح الباب بنفسك',
        actions: [{text: '🔧 طلب صيانة', url: '/resident/my-maintenance'}, {text: '📞 طوارئ', url: 'tel:773157823'}]
    },
    
    // النظافة
    cleaning: {
        patterns: ['نظافة', 'قمامة', 'زبالة', 'تنظيف', 'نفايات', 'روائح'],
        response: '🧹 النظافة:\n\n• تنظيف المناطق المشتركة: يومياً\n• القمامة: ضعها في الحاويات المخصصة\n• موعد جمع النفايات: يومياً 7م\n• شكوى نظافة: قدم شكوى',
        actions: [{text: '📝 شكوى', url: '/resident/my-complaints'}]
    },
    
    // الإنترنت
    internet: {
        patterns: ['انترنت', 'نت', 'واي فاي', 'wifi', 'شبكة'],
        response: '📶 الإنترنت:\n\n• كل وحدة تتعاقد مع مزود الخدمة مباشرة\n• التوصيل متاح من الشركة\n• للمساعدة في التركيب: تواصل مع الإدارة',
        actions: [{text: '✉️ تواصل', url: '/messages/create'}]
    },
    
    // الإعلانات
    announcements: {
        patterns: ['إعلان', 'إعلانات', 'جديد', 'أخبار', 'تنبيه'],
        response: '📢 الإعلانات:\n\nيمكنك متابعة جميع إعلانات المبنى من صفحة "الإعلانات"\n\n• إعلانات الصيانة\n• التنبيهات المهمة\n• الأحداث والمناسبات',
        actions: [{text: '📢 الإعلانات', url: '/announcements'}]
    },
    
    // التحيات
    greetings: {
        patterns: ['مرحبا', 'السلام', 'أهلا', 'هاي', 'صباح', 'مساء', 'هلا'],
        response: `👋 أهلاً وسهلاً ${userData.name}!\n\nأنا مساعد داري الذكي 🏠\nكيف يمكنني مساعدتك اليوم؟\n\nيمكنك سؤالي عن:\n• الفواتير والدفع\n• طلبات الصيانة\n• العقد والوحدة\n• أي شيء آخر!`,
        actions: []
    },
    
    // الشكر
    thanks: {
        patterns: ['شكرا', 'ممتاز', 'تمام', 'حلو', 'رائع', 'مشكور'],
        response: '🙏 عفواً! سعيد بمساعدتك.\n\nهل تحتاج أي شيء آخر؟\nأنا هنا لخدمتك دائماً! 😊',
        actions: []
    },
    
    // الوداع
    goodbye: {
        patterns: ['باي', 'مع السلامة', 'وداعا', 'الى اللقاء', 'سلام'],
        response: '👋 مع السلامة!\n\nنتمنى لك يوماً سعيداً 🌟\nلا تتردد في العودة إذا احتجت أي مساعدة!',
        actions: []
    }
};

// الرد الافتراضي
const defaultResponse = {
    response: `🤔 عذراً، لم أفهم سؤالك بشكل واضح.\n\nيمكنني مساعدتك في:\n• 💳 الفواتير والدفع\n• 🔧 طلبات الصيانة\n• 📄 معلومات العقد\n• 📝 الشكاوى والاقتراحات\n• 📞 التواصل مع الإدارة\n\nأو اختر من الخيارات السريعة أدناه:`,
    actions: [{text: '✉️ رسالة للمالك', url: '/messages/create'}]
};

function toggleChat() {
    const window = document.getElementById('chatbot-window');
    window.classList.toggle('d-none');
}

function sendQuick(text) {
    addMessage(text, 'user');
    setTimeout(() => getBotResponse(text), 500);
}

async function sendMessage() {
    const input = document.getElementById('user-input');
    const text = input.value.trim();
    if (!text) return;
    
    addMessage(text, 'user');
    input.value = '';
    
    showTyping();
    
    try {
        const response = await fetch('/resident/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: text })
        });
        
        const data = await response.json();
        hideTyping();
        
        if (data.success) {
            addMessage(data.reply, 'bot');
        } else {
            // استخدام الرد المحلي كبديل
            getBotResponse(text);
        }
    } catch (error) {
        hideTyping();
        // استخدام الرد المحلي في حالة الخطأ
        getBotResponse(text);
    }
}

function addMessage(text, type) {
    const container = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.className = type + '-message';
    div.innerHTML = text.replace(/\n/g, '<br>');
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
}

function showTyping() {
    const container = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.id = 'typing';
    div.className = 'bot-message typing';
    div.innerHTML = '<span></span><span></span><span></span>';
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
}

function hideTyping() {
    const typing = document.getElementById('typing');
    if (typing) typing.remove();
}

function getBotResponse(text) {
    let result = defaultResponse;
    let maxScore = 0;
    
    // البحث في قاعدة المعرفة
    for (const [key, data] of Object.entries(knowledgeBase)) {
        let score = 0;
        for (const pattern of data.patterns) {
            if (text.includes(pattern) || new RegExp(pattern, 'i').test(text)) {
                score++;
            }
        }
        if (score > maxScore) {
            maxScore = score;
            result = data;
        }
    }
    
    addMessage(result.response, 'bot');
    
    // إضافة أزرار الإجراءات إن وجدت
    if (result.actions && result.actions.length > 0) {
        addActionButtons(result.actions);
    }
}

function addActionButtons(actions) {
    const container = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.className = 'action-buttons';
    div.innerHTML = actions.map(a => 
        `<a href="${a.url}" class="action-btn">${a.text}</a>`
    ).join('');
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
}
</script>
