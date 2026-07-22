<x-guest-layout>
    <div class="mb-6">
        <p class="text-xs font-bold tracking-[.25em] text-yellow-300">ARAUM HOTEL</p>
        <h2 class="mt-2 text-2xl font-extrabold text-white">Verify your email</h2>
        <p class="mt-2 text-sm text-gray-300">We sent a six-digit code to <span class="text-yellow-200">{{ $user->email }}</span>. It expires in 10 minutes.</p>
    </div>

    @if (session('status')) <div class="mb-4 rounded-lg border border-yellow-400/30 bg-yellow-300/10 p-3 text-sm text-yellow-100">{{ session('status') }}</div> @endif
    @if (session('error')) <div class="mb-4 rounded-lg border border-red-400/30 bg-red-400/10 p-3 text-sm text-red-100">{{ session('error') }}</div> @endif
    <form method="POST" action="{{ route('verification.otp.verify') }}">
        @csrf
        <x-input-label for="otp" value="Verification code" />
        <x-text-input id="otp" class="mt-1 block w-full text-center text-2xl tracking-[.5em]" type="text" name="otp" inputmode="numeric" autocomplete="one-time-code" maxlength="6" required autofocus />
        <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        <x-primary-button class="mt-6 w-full justify-center">Verify and activate account</x-primary-button>
    </form>
    <form method="POST" action="{{ route('verification.otp.resend') }}" class="mt-4 text-center">
        @csrf
        <button class="text-sm text-yellow-200 underline underline-offset-4 hover:text-yellow-100" type="submit">Resend verification code</button>
    </form>
</x-guest-layout>
