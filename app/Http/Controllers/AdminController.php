<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function pendingUsers(Request $request)
    {
        $this->ensureAdmin($request->user());

        $users = User::where('role', 'artisan')
            ->where('is_approved', false)
            ->latest()
            ->get();

        return view('admin.pending-user', compact('users'));
    }

    public function approveUser(Request $request, $id)
    {
        $this->ensureAdmin($request->user());

        $user = User::where('role', 'artisan')->findOrFail($id);
        $user->update(['is_approved' => true]);

        return back()->with('success', 'Akaunti ya artisan imeidhinishwa kwa mafanikio.');
    }

    public function rejectUser(Request $request, $id)
    {
        $this->ensureAdmin($request->user());

        $user = User::where('role', 'artisan')->findOrFail($id);
        $user->delete();

        return back()->with('success', 'Ombi la artisan limekataliwa na akaunti imefutwa.');
    }

    private function ensureAdmin(?User $user): void
    {
        abort_unless($user && $user->role === 'admin', 403);
    }
}
