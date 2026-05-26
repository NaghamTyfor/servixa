<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserAuthService
{
    public function __construct(
        private OtpService $otpService
    ) {}

public function register(array $data): array
{
    $user = User::create([
        'first_name' => $data['first_name'],
        'last_name'  => $data['last_name'],
        'phone'      => $data['phone'],
        'password'   => Hash::make($data['password']),
        'city_id'    => $data['city_id'],
        'is_active'  => false,
    ]);

    $otpSent = true;
    try {
        $this->otpService->generateAndSend($data['phone']);
    } catch (\Exception $e) {
        Log::error('فشل إرسال رمز OTP أثناء التسجيل', [
            'phone' => $data['phone'],
            'error' => $e->getMessage(),
        ]);
        $otpSent = false;
    }

    $token = $user->createToken('mobile-app')->accessToken;

    return [
        'user'     => $user,
        'token'    => $token,
        'otp_sent' => $otpSent,
    ];
}

    public function verifyOtpForUser(User $user, string $code): ?User
    {
        if (! $this->otpService->verify($user->phone, $code)) {
            return null;
        }

        if (! $user->is_active) {
            $user->update(['is_active' => true]);
        }

        $user->load('city');

        return $user;
    }

    public function resendOtpForUser(User $user): bool
    {
        try {
            $this->otpService->generateAndSend($user->phone);
            return true;
        } catch (\Exception $e) {
            Log::error('Resend OTP failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function login(string $phone, string $password)
    {
        $user = User::where('phone', $phone)->with('city')->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return null;
        }

        if (! $user->is_active) {
            return ['error' => 'account_not_verified'];
        }

        $token = $user->createToken('mobile-app')->accessToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $user->token()->revoke();
    }
}
