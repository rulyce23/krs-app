<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get user's notifications
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $perPage = $request->get('per_page', 10);
        
        $query = $user->notifications();
        
        // Filter by read status
        if ($request->filled('read_status')) {
            if ($request->read_status === 'read') {
                $query->read();
            } elseif ($request->read_status === 'unread') {
                $query->unread();
            }
        }
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        $notifications = $query->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'message' => 'Notifications retrieved successfully',
            'data' => NotificationResource::collection($notifications),
            'meta' => [
                'pagination' => [
                    'current_page' => $notifications->currentPage(),
                    'last_page' => $notifications->lastPage(),
                    'per_page' => $notifications->perPage(),
                    'total' => $notifications->total(),
                ],
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount(Request $request): JsonResponse
    {
        $user = $request->user();
        $count = $user->unreadNotifications()->count();
        
        return response()->json([
            'success' => true,
            'message' => 'Unread count retrieved successfully',
            'data' => [
                'unread_count' => $count
            ],
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($id);
        
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
            'data' => new NotificationResource($notification->fresh()),
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($id);
        
        $notification->markAsUnread();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification marked as unread',
            'data' => new NotificationResource($notification->fresh()),
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        
        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
            'data' => null,
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($id);
        
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully',
            'data' => null,
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ]);
    }

    /**
     * Create notification (for testing purposes)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'data' => 'nullable|array',
        ]);

        $user = $request->user();
        
        $notification = $user->notifications()->create([
            'type' => $validated['type'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'data' => $validated['data'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification created successfully',
            'data' => new NotificationResource($notification),
            'meta' => [
                'timestamp' => now()->toISOString(),
                'version' => 'v1'
            ]
        ], 201);
    }
}