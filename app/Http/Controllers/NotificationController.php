<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
   
    public function markAsRead($id)
    {
        $user = Auth::user();

        $notification = $user->notifications()
            ->where('id', $id)
            ->first();

        if (!$notification) {
            return redirect()
                ->back()
                ->with('error', 'Notification not found.');
        }

       
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }

   
    public function markAllRead()
    {
        Auth::user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return redirect()->back();
    }

    
    public function emailNotification($id)
    {
        $user = Auth::user();

        $notification = $user->notifications()
            ->where('id', $id)
            ->first();

        if (!$notification) {
            return redirect()
                ->back()
                ->with('error', 'Notification not found.');
        }

        if (!$user->email) {
            return redirect()
                ->back()
                ->with('error', 'No email configured for your account.');
        }

        try {
            Mail::to($user->email)
                ->send(new NotificationMail($notification->data));

            return redirect()
                ->back()
                ->with('success', 'Notification sent to your email.');

        } catch (\Throwable $e) {

            Log::error('Failed to email notification: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to send email.');
        }
    }
}
