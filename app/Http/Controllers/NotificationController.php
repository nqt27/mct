<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth']); // Add admin middleware if needed
    }

    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        // Use simplePaginate instead of paginate for simpler implementation
        $notifications = DatabaseNotification::where('notifiable_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }


    public function show($id)
    {
        $notification = DatabaseNotification::where('notifiable_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();
        return view('admin.notification', compact('notification'));
    }

    public function markAllAsRead()
    {
        try {
            DatabaseNotification::where('notifiable_id', Auth::id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể đánh dấu thông báo'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DatabaseNotification::where('notifiable_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail()
                ->delete();

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa thông báo'
            ], 500);
        }
    }
}
