<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreAdminRequest;
use App\Http\Requests\Web\UpdateAdminRequest;
use App\Models\Admin;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct(
        private readonly RoleService $service
    ) {}


    public function index(Request $request): View
    {
        $name  = $request->input('name');
        $email = $request->input('email');

        $admins = $this->service->searchAdmins($name, $email);

        $roles = Role::where('guard_name', 'admin')
            ->where('name', '!=', 'super-admin')
            ->get();

        $totalAdmins = Admin::count();
        $totalRoles  = Role::where('guard_name', 'admin')->count();

        return view('admin.admins.index', [
            'admins'       => $admins,
            'roles'        => $roles,
            'totalAdmins'  => $totalAdmins,
            'totalRoles'   => $totalRoles,
            'nameSearch'   => $name,
            'emailSearch'  => $email,
            'catName'      => 'admins',
            'title'        => 'SERVIXA - Administrators',
            'breadcrumbs'  => [__('admin.admins')],
            'scrollspy'    => 0,
            'simplePage'   => 0,
        ]);
    }

    public function create(): View
    {
        $roles = Role::where('guard_name', 'admin')
            ->where('name', '!=', 'super-admin')
            ->get();

        return view('admin.admins.create', [
            'roles'       => $roles,
            'catName'     => 'admins',
            'title'       => 'SERVIXA - Add Admin',
            'breadcrumbs' => [__('admin.admins'), __('admin.add')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        $this->service->createAdmin($request->validated());

        return redirect()->route('admin.admins.index')
            ->with('success', __('admin.admin_created'));
    }

    public function show(Admin $admin): View
    {
        $admin->load('roles.permissions');

        return view('admin.admins.show', [
            'admin'       => $admin,
            'catName'     => 'admins',
            'title'       => 'SERVIXA - Admin Details',
            'breadcrumbs' => [__('admin.admins'), __('admin.details')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function edit(Admin $admin): View
    {
        if ($admin->hasRole('super-admin')) {
            abort(403, __('admin.cannot_modify_super_admin'));
        }

        $roles = Role::where('guard_name', 'admin')
            ->where('name', '!=', 'super-admin')
            ->get();

        return view('admin.admins.edit', [
            'admin'       => $admin,
            'roles'       => $roles,
            'catName'     => 'admins',
            'title'       => 'SERVIXA - Edit Admin',
            'breadcrumbs' => [__('admin.admins'), __('admin.edit')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

public function update(UpdateAdminRequest $request, Admin $admin): RedirectResponse
{
    if ($admin->hasRole('super-admin')) {
        return back()->withErrors(['admin' => __('admin.cannot_modify_super_admin')]);
    }

    $data = $request->validated();

    if (!$request->has('roles')) {
        $data['roles'] = [];
    }

    $this->service->updateAdmin($admin, $data);

    return redirect()->route('admin.admins.index')
        ->with('success', __('admin.admin_updated'));
}
    public function destroy(Admin $admin): RedirectResponse
    {
        try {
            $this->service->deleteAdmin($admin);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['admin' => $e->getMessage()]);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', __('admin.admin_deleted'));
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = json_decode($request->input('ids'), true);

        if (!empty($ids)) {
            try {
                $this->service->bulkDeleteAdmins($ids);
            } catch (\RuntimeException $e) {
                return back()->withErrors(['admins' => $e->getMessage()]);
            }
        }

        return redirect()
            ->route('admin.admins.index')
            ->with('success', __('admin.admins_deleted', ['count' => count($ids)]));
    }


public function trashed(Request $request): View
{
    $search = $request->input('search');
    $admins = $this->service->searchTrashedAdmins($search, 15);

    return view('admin.admins.trashed', [
        'admins'      => $admins,
        'catName'     => 'admins',
        'title'       => 'SERVIXA - Deleted Administrators',
        'breadcrumbs' => [__('admin.admins'), __('admin.trashed')],
        'scrollspy'   => 0,
        'simplePage'  => 0,
    ]);
}


public function restore(Request $request, int $id): JsonResponse|RedirectResponse
{
    try {
        $admin = $this->service->restoreAdmin($id);
    } catch (\RuntimeException $e) {
        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
        return back()->withErrors(['admin' => $e->getMessage()]);
    }

    if ($request->wantsJson() || $request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => __('admin.admin_restored'),
            'admin'   => $admin
        ]);
    }

    return redirect()->route('admin.admins.trashed')
        ->with('success', __('admin.admin_restored'));
}


public function forceDestroy(Request $request, int $id): JsonResponse|RedirectResponse
{
    try {
        $this->service->forceDeleteAdmin($id);
    } catch (\RuntimeException $e) {
        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
        return back()->withErrors(['admin' => $e->getMessage()]);
    }

    if ($request->wantsJson() || $request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => __('admin.admin_force_deleted')
        ]);
    }

    return redirect()->route('admin.admins.trashed')
        ->with('success', __('admin.admin_force_deleted'));
}
}
