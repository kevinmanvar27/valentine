<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AdminSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    public static function getValue(string $key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function setValue(string $key, $value, string $type = 'string', ?string $description = null): self
    {
        Cache::forget("setting_{$key}");
        
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description,
            ]
        );
    }

    public static function getRegistrationFee(): float
    {
        return (float) self::getValue('registration_fee', 51);
    }

    public static function getFullPaymentAmount(): float
    {
        return (float) self::getValue('full_payment_amount', 299);
    }

    public static function getHalfPaymentAmount(): float
    {
        return (float) self::getValue('half_payment_amount', 149);
    }

    public static function getAppLogo(): ?string
    {
        return self::getValue('app_logo');
    }

    public static function getPaymentQRCode(): ?string
    {
        return self::getValue('payment_qr_code');
    }

    public static function getPaymentUPI(): ?string
    {
        return self::getValue('payment_upi', 'example@upi');
    }

    // Razorpay Settings
    public static function isRazorpayEnabled(): bool
    {
        return (bool) self::getValue('razorpay_enabled', false);
    }

    public static function getRazorpayKeyId(): ?string
    {
        return self::getValue('razorpay_key_id');
    }

    public static function getRazorpayKeySecret(): ?string
    {
        return self::getValue('razorpay_key_secret');
    }

    // Google Pay / UPI Settings
    public static function isGooglePayEnabled(): bool
    {
        return (bool) self::getValue('googlepay_enabled', true);
    }
}
