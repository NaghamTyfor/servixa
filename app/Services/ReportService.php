<?php

namespace App\Services;

use App\Models\Report;
use App\Models\Service;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class ReportService
{
 public function submit(User $user, Service $service, string $reason): Report
{
    $exists = Report::where('user_id', $user->id)
        ->where('service_id', $service->id)
        ->exists();

    if ($exists) {
        throw ValidationException::withMessages([
            'service_id' => __('reports.already_reported'),
        ]);
    }

    $report = Report::create([
        'user_id'    => $user->id,
        'service_id' => $service->id,
        'reason'     => $reason,
    ]);

    $adminFcm = app(AdminFcmService::class);
    $serviceTitle = $service->getTranslation('title', app()->getLocale()) ?? $service->title;

    $adminFcm->sendToAdminsWithPermission(
        'reports.view',  
        'admin_notifications.report_submitted.title',
        'admin_notifications.report_submitted.body',
        ['service' => $serviceTitle, 'reason' => $reason],
        ['type' => 'report_submitted', 'report_id' => $report->id],
        null,
        'report_submitted',
        [
            'report_id'     => $report->id,
            'service_title' => $serviceTitle,
            'reason'        => $reason
        ]
    );

    return $report;
}

    public function searchAndPaginate(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Report::query()
            ->with(['user', 'service']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($q2) => $q2
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                )->orWhereHas('service', fn($q2) => $q2
                    ->where('title->ar', 'like', "%{$search}%")
                    ->orWhere('title->en', 'like', "%{$search}%")
                )->orWhere('reason', 'like', "%{$search}%");
            });
        }

        return $query
            ->latest()
            ->paginate($perPage)
            ->appends(['search' => $search]);
    }


}
