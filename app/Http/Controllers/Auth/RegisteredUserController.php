<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\EmailOtpMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $sent = $this->sendOtp($user);
        $request->session()->put('email_otp_user_id', $user->id);

        return redirect()->route('verification.otp.show')->with(
            $sent ? 'status' : 'error',
            $sent ? 'We sent a verification code to '.$user->email.'.' : 'Your account was created, but we could not deliver the code. Check the mail settings and resend the code.'
        );
    }

    private function sendOtp(User $user): bool
    {
        $otp = (string) random_int(100000, 999999);
        $user->forceFill([
            'email_otp_hash' => Hash::make($otp),
            'email_otp_expires_at' => now()->addMinutes(10),
            'email_otp_attempts' => 0,
            'email_otp_last_sent_at' => now(),
        ])->save();

        try {
            Mail::to($user->email)->send(new EmailOtpMail($user->name, $otp));
            return true;
        } catch (\Throwable $exception) {
            report($exception);
            return false;
        }
    }
}
