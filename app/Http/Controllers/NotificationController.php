<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = UserNotification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('student.notifications', compact('notifications'));
    }
    
    public function markAsRead($id)
    {
        $notification = UserNotification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();
            
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
    
    public function markAllRead()
    {
        UserNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return response()->json(['success' => true]);
    }
    
    public function destroy($id)
    {
        $notification = UserNotification::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();
            
        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
    
    public function destroyAll()
    {
        UserNotification::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }
    
    public function unreadCount()
    {
        $count = UserNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['unread_count' => $count]);
    }
    
    public function fetch()
    {
        $notifications = UserNotification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $unread_count = UserNotification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
            
        return response()->json([
            'success' => true,
            'unread_count' => $unread_count,
            'notifications' => $notifications
        ]);
    }
}