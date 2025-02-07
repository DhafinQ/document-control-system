<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    
    public function index(){
        $notifications = Auth::user()->notifications->sortByDesc('created_at');
        return view('user.notifications',compact('notifications'));
    }

    public function markAsRead($notificationId, Request $request)
    {
        $notification = Auth::user()->notifications()->find($notificationId);

        if ($notification) {
            // Mark the notification as read
            $notification->markAsRead();
            if($request->index){
                return back();
            }else{
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    public function markAllRead(Request $request){
        if ($request->ajax()) {
            $user = Auth::user();
            $user->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        }
        elseif($request->index){
            $user = Auth::user();
            $user->unreadNotifications->markAsRead();
            return back();
        }

        return response()->json(['success' => false], 400);
    }
}
