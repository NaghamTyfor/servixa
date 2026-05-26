<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BusinessAccountController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ServiceRequestController;
use App\Http\Controllers\ChatController;
use App\Http\Middleware\HasApprovedBusinessAccount;
use App\Models\AdminDeviceToken;
use Illuminate\Support\Facades\Route;
use Kreait\Laravel\Firebase\Facades\Firebase;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login',    [AuthController::class, 'login'])->name('login');
});

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');
        Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend-otp');
    });
});
Route::middleware(['auth:api', 'active.user'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me',      [AuthController::class, 'me'])->name('me');
    });
    Route::apiResource('business-accounts', BusinessAccountController::class)
        ->names([
            'index'   => 'business-accounts.index',
            'store'   => 'business-accounts.store',
            'show'    => 'business-accounts.show',
            'update'  => 'business-accounts.update',
            'destroy' => 'business-accounts.destroy',
        ]);

    Route::get('services/dynamic-fields', [ServiceController::class, 'dynamicFields'])->name('services.dynamic-fields');
    Route::get('services/my-services', [ServiceController::class, 'myServices'])->name('services.my-services');

    Route::apiResource('services', ServiceController::class)
        ->except(['index', 'show'])
        ->middleware(HasApprovedBusinessAccount::class);

    Route::post('services/{service}/requests', [ServiceRequestController::class, 'store'])
        ->name('service-requests.store')
        ->middleware(HasApprovedBusinessAccount::class);

    Route::post('services/{service}/ratings', [RatingController::class, 'store'])
        ->name('ratings.store');

Route::prefix('requests')->name('requests.')->group(function () {
    Route::get('/', [ServiceRequestController::class, 'myRequests'])->name('index');
    Route::patch('/{serviceRequest}/accept', [ServiceRequestController::class, 'accept'])->name('accept');
    Route::patch('/{serviceRequest}/reject', [ServiceRequestController::class, 'reject'])->name('reject');
    Route::patch('/{serviceRequest}/cancel',  [ServiceRequestController::class, 'cancel'])->name('cancel');
    Route::delete('/{serviceRequest}',       [ServiceRequestController::class, 'destroy'])->name('destroy');
});
});

Route::get('services', [ServiceController::class, 'index'])->name('services.index');
Route::get('services/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::get('services/{service}/ratings', [RatingController::class, 'index'])->name('ratings.index');

Route::middleware('auth:api')->group(function () {

    Route::prefix('notifications')->name('api.notifications.')->group(function () {

        Route::get('/', [NotificationController::class, 'index'])->name('index');

        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');

        Route::patch('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-read');

        Route::patch('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
    });
});


Route::middleware('auth:api')->group(function () {

    Route::post('/conversations', [ChatController::class, 'storeConversation']);

    Route::get('/conversations/{conversationId}/messages', [ChatController::class, 'getMessages']);

    Route::post('/conversations/{conversationId}/messages', [ChatController::class, 'sendMessage']);
});


Route::get('sliders', [\App\Http\Controllers\Api\SliderController::class, 'index'])
    ->name('sliders.index');


Route::middleware(['auth:api', 'active.user'])->group(function () {

    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\FavoriteController::class, 'index'])
            ->name('index');

        Route::post('/{service}', [\App\Http\Controllers\Api\FavoriteController::class, 'toggle'])
            ->name('toggle');
    });

    Route::post('services/{service}/reports', [\App\Http\Controllers\Api\ReportController::class, 'store'])
        ->name('reports.store');
});
