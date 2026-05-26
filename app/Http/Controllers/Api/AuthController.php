<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
use App\Http\Resources\UserResource;
use App\Services\UserAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private UserAuthService $userAuthService
    ) {}

public function register(RegisterRequest $request)
{
    $result = $this->userAuthService->register($request->validated());

    $result['user']->load('city');

    $response = [
        'data' => [
            'user'  => UserResource::make($result['user']),
            'token' => $result['token'],
        ],
    ];

    if ($result['otp_sent']) {
        $response['message'] = __('auth.otp_sent');
    } else {
        $response['message'] = __('auth.otp_send_failed'); // أو رسالة مخصصة
    }

    return response()->json($response, 201);
}

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = auth('api')->user();
        $verifiedUser = $this->userAuthService->verifyOtpForUser($user, $request->code);

        if (! $verifiedUser) {
            return response()->json([
                'message' => __('auth.otp_invalid_or_expired'),
            ], 400);
        }

        $token = $request->bearerToken();

        return response()->json([
            'message' => __('auth.account_verified'),
            'data'    => [
                'user'  => UserResource::make($verifiedUser),
                'token' => $token,
            ],
        ]);
    }

    public function resendOtp()
    {
        $user = auth('api')->user();
        $sent = $this->userAuthService->resendOtpForUser($user);

        if (! $sent) {
            return response()->json([
                'message' => __('auth.otp_resend_failed'),
            ], 400);
        }

        return response()->json([
            'message' => __('auth.otp_resent'),
        ]);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->userAuthService->login($request->phone, $request->password);

        if (! $result) {
            return response()->json([
                'message' => __('auth.invalid_credentials'),
            ], 401);
        }

        if (isset($result['error'])) {
            return response()->json([
                'message' => __('auth.account_not_verified'),
            ], 403);
        }

        $result['user']->load('city');

        return response()->json([
            'message' => __('auth.login_success'),
            'data'    => [
                'user'  => UserResource::make($result['user']),
                'token' => $result['token'],
            ],
        ]);
    }

    public function logout()
    {
        $user = auth('api')->user();
        $this->userAuthService->logout($user);

        return response()->json([
            'message' => __('auth.logout_success'),
        ]);
    }

    public function me()
    {
        $user = auth('api')->user()->load('city');

        return response()->json([
            'message' => __('auth.profile_retrieved'),
            'data'    => UserResource::make($user),
        ]);
    }
}
