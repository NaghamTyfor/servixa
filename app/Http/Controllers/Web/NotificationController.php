<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
public function dropdown(Request $request): JsonResponse
{
    if (!auth('admin')->check()) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    $admin = auth('admin')->user();

    try {
        $notifications = $admin->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        $locale = app()->getLocale();
        $formatted = $notifications->map(function ($notification) use ($locale) {
            $data = $notification->data;

            $title = __($data['title'] ?? '', $data['body_params'] ?? [], $locale);
            $body  = __($data['body'] ?? '', $data['body_params'] ?? [], $locale);

            if (is_array($title)) $title = json_encode($title, JSON_UNESCAPED_UNICODE);
            if (is_array($body))  $body  = json_encode($body, JSON_UNESCAPED_UNICODE);

            $title = (string) $title;
            $body  = (string) $body;

            $type = $data['type'] ?? null;
            $url = '#';
if ($type === 'business_account_pending' && isset($data['business_account_id'])) {
    $url = route('admin.business-accounts.show', $data['business_account_id']);
} elseif ($type === 'service_pending' && isset($data['service_id'])) {
    $url = route('admin.services.show', $data['service_id']);
} elseif ($type === 'report_submitted' && isset($data['report_id'])) {
    $url = route('admin.reports.show', $data['report_id']);
}

            return [
                'id'         => $notification->id,
                'type'       => $notification->type,
                'title'      => $title,
                'body'       => $body,
                'read_at'    => $notification->read_at,
                'created_at' => $notification->created_at->toISOString(),
                'url'        => $url,
            ];
        });

        return response()->json([
            'notifications' => $formatted,
        ]);
    } catch (\Exception $e) {
        Log::error('Dropdown notifications error: ' . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
}
public function getAllNotifications(Request $request)
{
    $admin = Auth::guard('admin')->user();
    $notifications = $admin->notifications()->paginate(20);

    $formatted = $notifications->map(function ($notification) {
        $title = $notification->translated_title;
        $body  = $notification->translated_body;

        if (is_array($title)) {
            $title = json_encode($title, JSON_UNESCAPED_UNICODE);
        }
        if (is_array($body)) {
            $body = json_encode($body, JSON_UNESCAPED_UNICODE);
        }

        $title = (string) $title;
        $body  = (string) $body;

        $data = $notification->data;
        $type = $data['type'] ?? null;
        $url = '#';
        if ($type === 'business_account_pending' && isset($data['business_account_id'])) {
            $url = route('admin.business-accounts.show', $data['business_account_id']);
        } elseif ($type === 'service_pending' && isset($data['service_id'])) {
            $url = route('admin.services.show', $data['service_id']);
        }
        return [
            'id'         => $notification->id,
            'type'       => $notification->type,
            'title'      => $title,
            'body'       => $body,
            'read_at'    => $notification->read_at,
            'created_at' => $notification->created_at->diffForHumans(),
            'url'        => $url,
        ];
    });

    return response()->json([
        'data'       => $formatted,
        'total'      => $notifications->total(),
        'current_page' => $notifications->currentPage(),
        'last_page'  => $notifications->lastPage(),
    ]);
}
public function index(Request $request): JsonResponse
{
    if (!auth('admin')->check()) {
        return response()->json(['error' => 'Unauthenticated'], 401);
    }

    $admin = auth('admin')->user();

    try {
        $notifications = $admin->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $formatted = $notifications->through(function ($notification) {
            $data = $notification->data;
            $locale = app()->getLocale();

            return [
                'id'         => $notification->id,
                'type'       => $data['type'] ?? null,
                'title'      => __($data['title'] ?? '', $data['body_params'] ?? [], $locale),
                'body'       => __($data['body'] ?? '', $data['body_params'] ?? [], $locale),
                'read_at'    => $notification->read_at,
                'created_at' => $notification->created_at->toISOString(),
                'data'       => $data,
            ];
        });

        return response()->json([
            'data'          => $formatted,
            'current_page'  => $notifications->currentPage(),
            'last_page'     => $notifications->lastPage(),
            'total'         => $notifications->total(),
        ]);
    } catch (\Exception $e) {
        Log::error('Notifications API error: ' . $e->getMessage());
        return response()->json(['error' => 'Server error'], 500);
    }
}

    public function indexView(Request $request)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('coverSignIn');
        }

        $admin = auth('admin')->user();

        try {
            $notifications = $admin->notifications()
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            $locale = app()->getLocale();
            foreach ($notifications as $notification) {
                $data = $notification->data;
                $notification->translated_title = __($data['title'] ?? '', $data['body_params'] ?? [], $locale);
                $notification->translated_body = __($data['body'] ?? '', $data['body_params'] ?? [], $locale);
                $notification->type = $data['type'] ?? null;
            }

            return view('admin.notifications.index', [
                'notifications' => $notifications,
                'catName'       => 'notifications',
                'title'         => 'SERVIXA - Notifications',
                'breadcrumbs'   => [__('admin.notifications')],
                'scrollspy'     => 0,
                'simplePage'    => 0,
            ]);
        } catch (\Exception $e) {
            Log::error('Notifications view error: ' . $e->getMessage());
            abort(500, 'Unable to load notifications');
        }
    }


    public function unreadCount(Request $request): JsonResponse
    {
        if (!auth('admin')->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $admin = auth('admin')->user();

        try {
            $count = $admin->unreadNotifications->count();
            return response()->json(['unread_count' => $count]);
        } catch (\Exception $e) {
            Log::error('Unread count error: ' . $e->getMessage());
            return response()->json(['unread_count' => 0, 'error' => $e->getMessage()], 500);
        }
    }


    public function markAsRead(Request $request, string $id): JsonResponse
    {
        if (!auth('admin')->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $admin = auth('admin')->user();

        try {
            $notification = $admin->notifications()->where('id', $id)->firstOrFail();
            $notification->markAsRead();
            return response()->json(['status' => 'marked_as_read']);
        } catch (\Exception $e) {
            Log::error('Mark as read error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


    public function markAllAsRead(Request $request): JsonResponse
    {
        if (!auth('admin')->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $admin = auth('admin')->user();

        try {
            $admin->unreadNotifications->markAsRead();
            return response()->json(['status' => 'all_marked_as_read']);
        } catch (\Exception $e) {
            Log::error('Mark all as read error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
