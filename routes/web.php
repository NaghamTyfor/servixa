<?php

use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Web\ActivityTypeController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\BusinessAccountController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CityController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DynamicFieldController;
use App\Http\Controllers\Web\FcmController;
use App\Http\Controllers\Web\PermissionController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\SliderController;
use App\Http\Controllers\Web\SubCategoryController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Http;



Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {

    Route::prefix('sliders')->name('sliders.')->group(function () {

        Route::get('/', [SliderController::class, 'index'])
            ->name('index');

        Route::get('/create', [SliderController::class, 'create'])
            ->name('create')
            ;

        Route::post('/', [SliderController::class, 'store'])
            ->name('store')
            ;

        Route::get('/{slider}', [SliderController::class, 'show'])
            ->name('show')
            ;

        Route::get('/{slider}/edit', [SliderController::class, 'edit'])
            ->name('edit')
            ;

        Route::put('/{slider}', [SliderController::class, 'update'])
            ->name('update')
            ;

        Route::delete('/{slider}', [SliderController::class, 'destroy'])
            ->name('destroy')
            ;
Route::patch('/{slider}/toggle-active', [SliderController::class, 'toggleActive'])
    ->name('toggle-active');
    });

    Route::prefix('reports')->name('reports.')->group(function () {

        Route::get('/', [ReportController::class, 'index'])
            ->name('index')
            ;

        Route::get('/{report}', [ReportController::class, 'show'])
            ->name('show')
            ;

        Route::delete('/{report}', [ReportController::class, 'destroy'])
            ->name('destroy')
            ;
    });
});

Route::get('/',       [AuthController::class, 'showLoginForm'])->name('coverSignIn');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/language/{lang}', [LanguageController::class, 'switchLang'])->name('language.switch');


Route::middleware(['auth:admin'])->group(function () {
    Route::put('/admin/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/admin/notifications/all-data', [App\Http\Controllers\Web\NotificationController::class, 'getAllNotifications'])->name('admin.notifications.all-data');
Route::get('/admin/notifications/dropdown', [App\Http\Controllers\Web\NotificationController::class, 'dropdown'])
    ->name('admin.notifications.dropdown');
});
Route::middleware('auth:admin')->group(function () {
Route::post('/fcm/register-token', [FcmController::class, 'storeToken'])
    ->name('admin.fcm.store');

Route::prefix('admin')->name('admin.')->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifications', [App\Http\Controllers\Web\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [App\Http\Controllers\Web\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\Web\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/read-all', [App\Http\Controllers\Web\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/view-all', [App\Http\Controllers\Web\NotificationController::class, 'indexView'])->name('notifications.view-all');
});

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

    Route::post('admin/cities/bulk-destroy', [CityController::class, 'bulkDestroy'])
        ->name('admin.cities.bulk-destroy')
        ->middleware('permission:cities.delete');

    Route::resource('cities', CityController::class)
        ->names('admin.cities')
        ->middleware([
            'index'   => 'permission:cities.view',
            'show'    => 'permission:cities.view',
            'create'  => 'permission:cities.create',
            'store'   => 'permission:cities.create',
            'edit'    => 'permission:cities.edit',
            'update'  => 'permission:cities.edit',
            'destroy' => 'permission:cities.delete',
        ]);

    Route::post('admin/activity-types/bulk-destroy', [ActivityTypeController::class, 'bulkDestroy'])
        ->name('admin.activity-types.bulk-destroy')
        ->middleware('permission:activity_types.delete');

    Route::resource('activity-types', ActivityTypeController::class)
        ->names('admin.activity-types')
        ->middleware([
            'index'   => 'permission:activity_types.view',
            'show'    => 'permission:activity_types.view',
            'create'  => 'permission:activity_types.create',
            'store'   => 'permission:activity_types.create',
            'edit'    => 'permission:activity_types.edit',
            'update'  => 'permission:activity_types.edit',
            'destroy' => 'permission:activity_types.delete',
        ]);

    Route::prefix('roles')->name('admin.roles.')->middleware('permission:roles.view')->group(function () {
        Route::get('/',                          [RoleController::class, 'index'])->name('index');
        Route::get('/create',                    [RoleController::class, 'create'])->name('create')->middleware('permission:roles.create');
        Route::post('/',                         [RoleController::class, 'store'])->name('store')->middleware('permission:roles.create');
        Route::get('/{role}',                     [RoleController::class, 'show'])->name('show')->middleware('permission:roles.view');
        Route::get('/{role}/edit',                 [RoleController::class, 'edit'])->name('edit')->middleware('permission:roles.edit');
        Route::put('/{role}',                      [RoleController::class, 'update'])->name('update')->middleware('permission:roles.edit');
        Route::delete('/{role}',                   [RoleController::class, 'destroy'])->name('destroy')->middleware('permission:roles.delete');
        Route::post('/{role}/sync-permissions',    [RoleController::class, 'syncPermissions'])->name('sync-permissions')->middleware('permission:roles.assign_permissions');
        Route::delete('/bulk-destroy',            [RoleController::class, 'bulkDestroy'])->name('bulk-destroy')->middleware('permission:roles.delete');
    });

    Route::prefix('admins')->name('admin.admins.')->middleware('permission:admins.view')->group(function () {
    Route::get('/trashed', [AdminController::class, 'trashed'])->name('trashed');
    Route::patch('/{id}/restore', [AdminController::class, 'restore'])->name('restore')->middleware('permission:admins.delete');
    Route::delete('/{id}/force-destroy', [AdminController::class, 'forceDestroy'])->name('force-destroy')->middleware('permission:admins.delete');

        Route::get('/',                          [AdminController::class, 'index'])->name('index');
        Route::get('/create',                     [AdminController::class, 'create'])->name('create')->middleware('permission:admins.create');
        Route::post('/',                         [AdminController::class, 'store'])->name('store')->middleware('permission:admins.create');
        Route::get('/{admin}',                    [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/edit',                [AdminController::class, 'edit'])->name('edit')->middleware('permission:admins.edit');
        Route::put('/{admin}',                     [AdminController::class, 'update'])->name('update')->middleware('permission:admins.edit');
        Route::patch('/{admin}/update-role',     [AdminController::class, 'updateRole'])->name('update-role')->middleware('permission:admins.edit');
        Route::delete('/{admin}',                [AdminController::class, 'destroy'])->name('destroy')->middleware('permission:admins.delete');
        Route::delete('/bulk-destroy',            [AdminController::class, 'bulkDestroy'])->name('bulk-destroy')->middleware('permission:admins.delete');
    });


    Route::get('/permissions', [PermissionController::class, 'index'])
        ->name('admin.permissions.index')
        ->middleware('permission:roles.view');



Route::prefix('business-accounts')->name('admin.business-accounts.')->group(function () {

    Route::get('/', [BusinessAccountController::class, 'index'])
        ->name('index')
        ->middleware('permission:business_accounts.view');

    Route::get('/{businessAccount}', [BusinessAccountController::class, 'show'])
        ->name('show')
        ->middleware('permission:business_accounts.view');

    Route::patch('/{businessAccount}/approve', [BusinessAccountController::class, 'approve'])
        ->name('approve')
        ->middleware('permission:business_accounts.approve');

    Route::patch('/{businessAccount}/reject', [BusinessAccountController::class, 'reject'])
        ->name('reject')
        ->middleware('permission:business_accounts.reject');

    Route::patch('/{businessAccount}/suspend', [BusinessAccountController::class, 'suspend'])
        ->name('suspend')
        ->middleware('permission:business_accounts.suspend');

    Route::patch('/{businessAccount}/reactivate', [BusinessAccountController::class, 'reactivate'])
        ->name('reactivate')
        ->middleware('permission:business_accounts.reactivate');

});
});

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {


    Route::prefix('categories')->name('categories.')->group(function () {

        Route::get('/',            [CategoryController::class, 'index'])       ->name('index');
        Route::get('/create',      [CategoryController::class, 'create'])      ->name('create');
        Route::post('/',           [CategoryController::class, 'store'])       ->name('store');
        Route::get('/{category}',  [CategoryController::class, 'show'])        ->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])   ->name('edit');
        Route::put('/{category}',  [CategoryController::class, 'update'])      ->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])   ->name('destroy');

        Route::post('/bulk-destroy', [CategoryController::class, 'bulkDestroy'])->name('bulk-destroy');

        Route::prefix('/{category}/sub-categories')->name('sub-categories.')->group(function () {

            Route::get('/',                    [SubCategoryController::class, 'index'])   ->name('index');
            Route::get('/create',              [SubCategoryController::class, 'create'])  ->name('create');
            Route::post('/',                   [SubCategoryController::class, 'store'])   ->name('store');
            Route::get('/{subCategory}',       [SubCategoryController::class, 'show'])    ->name('show');
            Route::get('/{subCategory}/edit',  [SubCategoryController::class, 'edit'])    ->name('edit');
            Route::put('/{subCategory}',       [SubCategoryController::class, 'update'])  ->name('update');
            Route::delete('/{subCategory}',    [SubCategoryController::class, 'destroy']) ->name('destroy');
            Route::post('/bulk-destroy',       [SubCategoryController::class, 'bulkDestroy'])->name('bulk-destroy');

            Route::prefix('/{subCategory}/dynamic-fields')->name('dynamic-fields.')->group(function () {
                Route::get('/',               [DynamicFieldController::class, 'indexForSubCategory'])   ->name('index');
                Route::get('/create',         [DynamicFieldController::class, 'createForSubCategory'])  ->name('create');
                Route::post('/',              [DynamicFieldController::class, 'storeForSubCategory'])    ->name('store');
                Route::get('/{dynamicField}', [DynamicFieldController::class, 'showForSubCategory'])    ->name('show'); // ✅ Added show
                Route::get('/{dynamicField}/edit',   [DynamicFieldController::class, 'editForSubCategory'])   ->name('edit');
                Route::put('/{dynamicField}',        [DynamicFieldController::class, 'updateForSubCategory'])  ->name('update');
                Route::delete('/{dynamicField}',     [DynamicFieldController::class, 'destroyForSubCategory']) ->name('destroy');
            });
        });

        Route::prefix('/{category}/dynamic-fields')->name('dynamic-fields.')->group(function () {
            Route::get('/',               [DynamicFieldController::class, 'indexForCategory'])   ->name('index');
            Route::get('/create',         [DynamicFieldController::class, 'createForCategory'])  ->name('create');
            Route::post('/',              [DynamicFieldController::class, 'storeForCategory'])    ->name('store');
            Route::get('/{dynamicField}', [DynamicFieldController::class, 'showForCategory'])    ->name('show'); // ✅ Added show
            Route::get('/{dynamicField}/edit',   [DynamicFieldController::class, 'editForCategory'])   ->name('edit');
            Route::put('/{dynamicField}',        [DynamicFieldController::class, 'updateForCategory'])  ->name('update');
            Route::delete('/{dynamicField}',     [DynamicFieldController::class, 'destroyForCategory']) ->name('destroy');
        });
    });
});

Route::prefix('services')->name('admin.services.')->middleware(['auth:admin'])->group(function () {
    Route::get('/', [ServiceController::class, 'index'])
        ->name('index')
        ->middleware('permission:services.view');

    Route::get('/{service}', [ServiceController::class, 'show'])
        ->name('show')
        ->middleware('permission:services.view');

    Route::patch('/{service}/approve', [ServiceController::class, 'approve'])
        ->name('approve')
        ->middleware('permission:services.approve');

    Route::patch('/{service}/reject', [ServiceController::class, 'reject'])
        ->name('reject')
        ->middleware('permission:services.reject');

    Route::patch('/{service}/suspend', [ServiceController::class, 'suspend'])
        ->name('suspend')
        ->middleware('permission:services.suspend');

    Route::patch('/{service}/reactivate', [ServiceController::class, 'reactivate'])
        ->name('reactivate')
        ->middleware('permission:services.reactivate');



});


Route::get('/{userId1}/{userId2}/{serviceId}', [ChatController::class, 'showDemo'])->name('chat.demo');
Route::post('/chat/{conversationId}/send', [ChatController::class, 'sendFromWeb'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class)
    ->name('chat.send.web');

