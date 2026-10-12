<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->user()->role === 'artisan' 
                ? redirect()->route('artisan.dashboard')
                : redirect()->route('dashboard');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($request->user()->role === 'artisan') {
            return redirect()->route('artisan.dashboard')->with('status', 'Akaunti yako imethibitishwa kikamilifu!');
        }

        return redirect()->route('dashboard')->with('status', 'Email verified successfully!');
    }
}
