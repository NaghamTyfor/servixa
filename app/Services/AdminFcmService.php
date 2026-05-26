<?php

namespace App\Services;

use App\Models\AdminDeviceToken;
use App\Models\Admin;
use App\Notifications\BusinessAccountPending;
use App\Notifications\ReportSubmitted;
use App\Notifications\ServicePending;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class AdminFcmService
{
    protected $messaging;

    public function __construct()
    {
        $this->messaging = Firebase::messaging();
    }

    public function sendToAdminsWithPermission(
        string $permission,
        string $titleKey,
        string $bodyKey,
        array $replace = [],
        array $data = [],
        ?string $locale = null,
        ?string $notificationType = null,
        $extraData = null
    ): void {
        Log::info(' AdminFcmService called', [
            'permission' => $permission,
            'type' => $notificationType ?? 'none',
        ]);

        $admins = Admin::permission($permission)->get();

        if ($admins->isEmpty()) {
            Log::info('[FCM] No admins with permission: ' . $permission);
            return;
        }

        foreach ($admins as $admin) {
            $this->sendDatabaseNotification($admin, $notificationType, $extraData);
        }

        $tokens = AdminDeviceToken::whereIn('admin_id', $admins->pluck('id'))
            ->pluck('token')
            ->toArray();

        if (empty($tokens)) {
            Log::info('[FCM] No device tokens for admins with permission: ' . $permission);
            return;
        }

        $locale = $locale ?? App::getLocale();
        $title  = __($titleKey, $replace, $locale);
        $body   = __($bodyKey,  $replace, $locale);

        $data['title'] = $title;
        $data['body']  = $body;
        $stringData = array_map('strval', $data);

        try {
            $message = CloudMessage::new()
                ->withNotification(Notification::create($title, $body))
                ->withData($stringData);

            $response = $this->messaging->sendMulticast($message, $tokens);

            Log::info('[FCM] Sent: ' . $response->successes()->count()
                . ' success, ' . $response->failures()->count() . ' failed');

            $invalidTokens = array_merge(
                $response->invalidTokens(),
                $response->unknownTokens()
            );

            if (!empty($invalidTokens)) {
                AdminDeviceToken::whereIn('token', $invalidTokens)->delete();
                Log::info('[FCM] Removed ' . count($invalidTokens) . ' invalid tokens');
            }

        } catch (\Throwable $e) {
            Log::error('[FCM] Send failed: ' . $e->getMessage());
        }
    }

    protected function sendDatabaseNotification(
        Admin $admin,
        ?string $notificationType,
        $extraData
    ): void {
        if (!$notificationType) return;

        try {
            switch ($notificationType) {
                case 'business_account_pending':
                    $id   = $extraData['id']   ?? null;
                    $name = $extraData['name']  ?? '';
                    if ($id && $name) {
                        $admin->notify(new BusinessAccountPending((int) $id, $name));
                    }
                    break;

                case 'service_pending':
                    $id    = $extraData['id']    ?? null;
                    $title = $extraData['title'] ?? '';
                    if ($id && $title) {
                        $admin->notify(new ServicePending((int) $id, $title));
                    }
                    break;

                case 'report_submitted':
                    $reportId     = $extraData['report_id'] ?? null;
                    $serviceTitle = $extraData['service_title'] ?? '';
                    $reason       = $extraData['reason'] ?? '';
                    if ($reportId && $serviceTitle) {
                        $admin->notify(new ReportSubmitted((int) $reportId, $serviceTitle, $reason));
                    }
                    break;
            }
        } catch (\Throwable $e) {
            Log::error('[FCM] DB notification failed for admin ' . $admin->id . ': ' . $e->getMessage());
        }
    }
}
