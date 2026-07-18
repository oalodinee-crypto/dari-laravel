# نظام داري لإدارة العقارات
## DARI Property Management System

نظام متكامل لإدارة العقارات مبني على Laravel مع واجهة عربية احترافية.

---

## المتطلبات

- PHP 8.1+
- Composer
- MySQL أو MariaDB
- Node.js (اختياري)

---

## خطوات التثبيت

### 1. نسخ المشروع إلى مجلد XAMPP

```bash
# انسخ مجلد dari-laravel إلى:
C:\xampp\htdocs\dari-laravel
```

### 2. فتح Terminal في مجلد المشروع

```bash
cd C:\xampp\htdocs\dari-laravel
```

### 3. تثبيت الاعتماديات

```bash
composer install
```

### 4. إعداد ملف البيئة

```bash
copy .env.example .env
php artisan key:generate
```

### 5. إنشاء قاعدة البيانات

افتح phpMyAdmin من XAMPP وأنشئ قاعدة بيانات باسم:
```
dari_db
```

### 6. تعديل ملف .env

افتح ملف `.env` وتأكد من:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dari_db
DB_USERNAME=root
DB_PASSWORD=
```

### 7. تشغيل الـ Migrations و Seeders

```bash
php artisan migrate --seed
```

### 8. إنشاء رابط للتخزين

```bash
php artisan storage:link
```

### 9. تشغيل المشروع

```bash
php artisan serve
```

ثم افتح المتصفح على:
```
http://localhost:8000
```

---

## بيانات الدخول

### المدير (Admin)
- **البريد:** admin@dari.com
- **كلمة المرور:** lwma773157823

### المشرف (Manager)
- **البريد:** manager@dari.com
- **كلمة المرور:** password123

### الفني (Technician)
- **البريد:** tech@dari.com
- **كلمة المرور:** password123

### المستخدم (User)
- **البريد:** user@dari.com
- **كلمة المرور:** password123

---

## الميزات

### لوحة التحكم
- إحصائيات شاملة
- أحدث العقارات
- طلبات الصيانة

### إدارة العقارات
- إضافة/تعديل/حذف العقارات
- رفع صور متعددة
- تصنيف حسب النوع والحالة

### إدارة المستخدمين
- إنشاء حسابات جديدة
- تعيين الأدوار والصلاحيات
- تفعيل/تعطيل الحسابات

### الأدوار والصلاحيات
- 4 أدوار أساسية
- صلاحيات قابلة للتخصيص
- نظام Spatie Permission

### طلبات الصيانة
- إنشاء طلبات صيانة
- تعيين الفنيين
- تتبع الحالة

---

## هيكل المشروع

```
dari-laravel/
├── app/
│   ├── Http/Controllers/    # المتحكمات
│   ├── Models/              # النماذج
│   └── Providers/           # مزودو الخدمات
├── config/                  # ملفات الإعداد
├── database/
│   ├── migrations/          # ترحيلات قاعدة البيانات
│   └── seeders/             # بيانات تجريبية
├── public/                  # الملفات العامة
├── resources/views/         # واجهات Blade
├── routes/                  # مسارات التطبيق
└── storage/                 # التخزين
```

---

## الدعم الفني

للمساعدة أو الاستفسارات، تواصل معنا.
المطور 
--- عقبه محمد العديني
775028636

