<?php

namespace App\Services;

use App\Models\Unit;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

// خدمة توليد وتخزين رمز الاستجابة السريعة (QR Code) للوحدات
class QrCodeService
{
    /**
     * توليد QR Code لوحدة محددة
     */
    public function generateForUnit(Unit $unit): string
    {
        $url = route('units.public', $unit->id);
        $filename = 'qrcodes/unit_' . $unit->id . '.svg';
        
        $qrCode = QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->generate($url);
        
        Storage::disk('public')->put($filename, $qrCode);
        
        $unit->update(['qr_code' => $filename]);
        
        return $filename;
    }
    
    /**
     * توليد QR Code لجميع الوحدات
     */
    public function generateForAllUnits(): int
    {
        $units = Unit::all();
        $count = 0;
        
        foreach ($units as $unit) {
            $this->generateForUnit($unit);
            $count++;
        }
        
        return $count;
    }
    
    /**
     * جلب رابط صورة QR Code
     */
    public function getQrCodeUrl(Unit $unit): ?string
    {
        if ($unit->qr_code) {
            return Storage::disk('public')->url($unit->qr_code);
        }
        return null;
    }
}
