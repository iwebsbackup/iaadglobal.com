<x-layouts.app title="Forgot Password | DiCD 2026">

    @php
        $field =
            'w-full rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/40 outline-none transition focus:border-gold-light focus:bg-white/15';
        $label = 'block text-xs font-bold tracking-wider text-white/70 uppercase';
        $err = 'mt-1.5 block text-xs font-semibold tracking-normal text-red-300 normal-case';
    @endphp

    <section
        class="relative isolate min-h-screen overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] pt-36 pb-24 text-white">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.08)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]">
            </div>
            <div
                class="absolute -top-40 -right-32 size-[520px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.20),transparent)]">
            </div>
            <div
                class="absolute -bottom-48 -left-40 size-[480px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.30),transparent)]">
            </div>
        </div>

        <div class="mx-auto max-w-md px-6">
            <div class="mb-6 flex justify-end">
                <a href="/login" class="btn-line !px-5 !py-2.5 !text-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Back to login
                </a>
            </div>

            <h1 class="text-center font-display text-4xl leading-tight font-bold tracking-tight sm:text-5xl">
                Forgot
                <em
                    class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">password?</em>
            </h1>
            <p class="mt-3 text-center text-sm text-white/70">Enter your registered email and we'll send you a reset
                link.</p>

            @if (session('status'))
                <p class="mt-6 rounded-xl bg-gold-light/15 px-4 py-3 text-sm font-semibold text-gold-light">
                    {{ session('status') }}</p>
            @endif

            <form method="POST" action="/forgot-password"
                class="mt-8 space-y-4 rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8">
                @csrf

                <label class="{{ $label }}">Email <span class="text-[#ff4d4f]" style="color:#ff4d4f">*</span>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                        required autofocus autocomplete="email" class="{{ $field }} mt-2 normal-case">
                    @error('email')
                        <span class="{{ $err }}">{{ $message }}</span>
                    @enderror
                </label>

                <button type="submit" class="btn-fill w-full">
                    Send reset link <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>
        </div>
    </section>

</x-layouts.app>
