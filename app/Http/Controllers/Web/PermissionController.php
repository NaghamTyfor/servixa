<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\RoleService;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function __construct(
        private readonly RoleService $service
    ) {}


    public function index(): View
    {
        $permissions = $this->service->allPermissions(); 

        return view('admin.admins.permissions', [
            'permissions' => $permissions,
            'catName'     => 'permissions',
            'title'       => 'SERVIXA - Permissions',
            'breadcrumbs' => [__('admin.admins_permissions'), __('admin.permissions')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }
}
