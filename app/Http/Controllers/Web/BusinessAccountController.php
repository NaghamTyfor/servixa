<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BusinessAccount;
use App\Services\BusinessAccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BusinessAccountController extends Controller
{
    public function __construct(
        private readonly BusinessAccountService $service
    ) {}
    public function index(Request $request): View
    {
        $search   = $request->input('search');
        $status   = $request->input('status');
        $accounts = $this->service->searchAndPaginate($search, $status, 15);

        return view('admin.business-accounts.index', [
            'accounts'    => $accounts,
            'catName'     => 'business-accounts',
            'title'       => 'SERVIXA - Business Accounts',
            'breadcrumbs' => [__('admin.business_accounts')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function show(BusinessAccount $businessAccount): View
    {
        $businessAccount->load([
            'user', 'activityType', 'city', 'reviewer',
            'media' => fn($q) => $q->whereIn('collection_name', ['images', 'documents']),
        ]);

        return view('admin.business-accounts.show', [
            'account'     => $businessAccount,
            'catName'     => 'business-accounts',
            'title'       => 'SERVIXA - Business Account Details',
            'breadcrumbs' => [__('admin.business_accounts'), __('admin.details')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }


    public function approve(BusinessAccount $businessAccount): RedirectResponse
    {
        try {
            $this->service->approve($businessAccount, auth('admin')->id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', __('admin.business_account_approved'));
    }

    public function reject(BusinessAccount $businessAccount): RedirectResponse
    {
        try {
            $this->service->reject($businessAccount, auth('admin')->id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', __('admin.business_account_rejected'));
    }

    public function suspend(BusinessAccount $businessAccount): RedirectResponse
    {
        try {
            $this->service->suspend($businessAccount, auth('admin')->id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', __('admin.business_account_suspended'));
    }

    public function reactivate(BusinessAccount $businessAccount): RedirectResponse
    {
        try {
            $this->service->reactivate($businessAccount, auth('admin')->id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', __('admin.business_account_reactivated'));
    }

}
