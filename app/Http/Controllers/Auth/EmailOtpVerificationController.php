<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailOtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class EmailOtpVerificationController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const RESEND_COOLDOWN_SECONDS = 60;

    public function show(Request $request): View|RedirectResponse
    {
        $user = $this->pendingUser($request);
        if (! $user) {
            return redirect()->route('register')->withErrors(['email' => 'Start registration to receive a verification code.']);
        }

        return view('auth.verify-email-otp', compact('user'));
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate(['otp' => ['required', 'digits:6']]);
        $user = $this->pendingUser($request);
        if (! $user) return redirect()->route('register');

        if (! $user->email_otp_hash || ! $user->email_otp_expires_at || now()->greaterThan($user->email_otp_expires_at)) {
            return back()->withErrors(['otp' => 'This code has expired. Please request a new code.']);
        }
        if ($user->email_otp_attempts >= self::MAX_ATTEMPTS) {
            return back()->withErrors(['otp' => 'Too many attempts. Please request a new code.']);
        }
        if (! Hash::check($request->otp, $user->email_otp_hash)) {
            $user->increment('email_otp_attempts');
            $remaining = self::MAX_ATTEMPTS - $user->fresh()->email_otp_attempts;
            return back()->withErrors(['otp' => $remaining > 0 ? "Invalid code. {$remaining} attempt(s) remaining." : 'Too many attempts. Please request a new code.']);
        }

        $user->forceFill([
            'email_verified_at' => now(), 'email_otp_hash' => null, 'email_otp_expires_at' => null,
            'email_otp_attempts' => 0, 'email_otp_last_sent_at' => null,
        ])->save();
        $request->session()->forget('email_otp_user_id');
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false))->with('success', 'Your email has been verified. Welcome to ARAUM.');
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $this->pendingUser($request);
        if (! $user) return redirect()->route('register');

        $secondsSinceLastSend = $user->email_otp_last_sent_at?->diffInSeconds(now()) ?? self::RESEND_COOLDOWN_SECONDS;
        if ($secondsSinceLastSend < self::RESEND_COOLDOWN_SECONDS) {
            return back()->withErrors(['otp' => 'Please wait '.(self::RESEND_COOLDOWN_SECONDS - $secondsSinceLastSend).' seconds before requesting another code.']);
        }

        $otp = (string) random_int(100000, 999999);
        $user->forceFill([
            'email_otp_hash' => Hash::make($otp), 'email_otp_expires_at' => now()->addMinutes(10),
            'email_otp_attempts' => 0, 'email_otp_last_sent_at' => now(),
        ])->save();
        try {
            Mail::to($user->email)->send(new EmailOtpMail($user->name, $otp));
        } catch (\Throwable $exception) {
            report($exception);
            return back()->withErrors(['otp' => 'We could not send the email right now. Please try again shortly.']);
        }

        return back()->with('status', 'A fresh verification code has been sent.');
    }

    private function pendingUser(Request $request): ?User
    {
        $id = $request->session()->get('email_otp_user_id');
        return $id ? User::find($id) : null;
    }
}
