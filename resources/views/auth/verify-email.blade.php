<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-extrabold text-yellow-300 tracking-widest uppercase">Verify Email</h2>
    </div>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-yellow-200 bg-yellow-500/10 border border-yellow-500/25 rounded-md px-3 py-2">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    @if (session('status') == 'verification-email-failed')
        <div class="mb-4 font-medium text-sm text-red-200 bg-red-500/10 border border-red-500/25 rounded-md px-3 py-2">
            {{ __('We could not send the verification email. Please try again shortly or contact the hotel.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-yellow-200 hover:text-yellow-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-300">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
