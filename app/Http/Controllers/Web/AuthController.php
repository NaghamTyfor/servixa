<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\AdminLoginRequest;
use App\Services\AdminAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        private  AdminAuthService $adminAuthService
    ) {}

    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->intended(route('dashboard'));
        }

        return view('admin/auth/cover/sign-in', [
            'catName' => 'auth',
            'title' => 'SERVIXA - Sign In',
            "breadcrumbs" => ["Authentication", "Sign In"],
            'scrollspy' => 0,
            'simplePage' => 1
        ]);
    }

    public function login(AdminLoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        [$success, $errorField, $errorMessage] = $this->adminAuthService->login(
            $credentials['email'],
            $credentials['password'],
            $request->boolean('remember')
        );

        if (! $success) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([$errorField => $errorMessage]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

public function logout(Request $request): RedirectResponse
{
    $fcmToken = $request->input('fcm_token');
    $this->adminAuthService->logout($fcmToken);
    return redirect()->route('coverSignIn');
}
}
