<?php

namespace App\Services;

use App\Models\OtpVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OtpService
{
    private const OTP_LENGTH   = 6;
    private const OTP_TTL_MINS = 10;

    public function generateAndSend(string $phone): OtpVerification
    {
        OtpVerification::forPhone($phone)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        $code = $this->generateCode();

        $this->sendViaWhatsApp($phone, $code);

        $otp = OtpVerification::create([
            'phone'      => $phone,
            'code'       => $code,
            'expires_at' => Carbon::now()->addMinutes(self::OTP_TTL_MINS),
            'is_used'    => false,
        ]);

        return $otp;
    }

    public function verify(string $phone, string $code): bool
    {
        $otp = OtpVerification::forPhone($phone)
            ->valid()
            ->where('code', $code)
            ->latest()
            ->first();

        if (! $otp) {
            return false;
        }

        $otp->update(['is_used' => true]);

        return true;
    }

    private function generateCode(): string
    {
        return str_pad((string) random_int(0, 999999), self::OTP_LENGTH, '0', STR_PAD_LEFT);
    }

    private function sendViaWhatsApp(string $phone, string $code): void
    {
        $instanceId = 'instance160921';
        $token = 'gt04nbx580bcskps';
        $url = "https://api.ultramsg.com/{$instanceId}/messages/chat";

        $message = __('auth.otp_message', [
            'code'    => $code,
            'minutes' => self::OTP_TTL_MINS,
        ]);

        $response = Http::post($url, [
            'token' => $token,
            'to'    => $phone,
            'body'  => $message,
        ]);

        if (! $response->successful()) {
            Log::error('UltraMsg OTP send failed', [
                'phone'    => $phone,
                'response' => $response->body(),
            ]);
            throw new \Exception(__('auth.otp_send_failed'));
        }

        Log::info('رمز التحقق (OTP)', [
        'phone' => $phone,
        'code'  => $code,
    ]);
    }
}
