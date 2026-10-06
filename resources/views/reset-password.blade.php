<x-layouts.app title="Reset Password | DiCD 2026">

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
            <h1 class="text-center font-display text-4xl leading-tight font-bold tracking-tight sm:text-5xl">
                Reset
                <em
                    class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">password</em>
            </h1>

            <form method="POST" action="/reset-password"
                class="mt-8 space-y-4 rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <label class="{{ $label }}">Email <span class="text-[#ff4d4f]" style="color:#ff4d4f">*</span>
                    <input type="email" name="email" value="{{ old('email', request('email')) }}" required readonly
                        autocomplete="email" class="{{ $field }} mt-2 normal-case opacity-70">
                    @error('email')
                        <span class="{{ $err }}">{{ $message }}</span>
                    @enderror
                </label>

                <label class="{{ $label }}">New password <span class="text-[#ff4d4f]"
                        style="color:#ff4d4f">*</span>
                    <div class="relative mt-2" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password" placeholder="Minimum 6 characters"
                            required minlength="6" autofocus autocomplete="new-password"
                            class="{{ $field }} pr-12 normal-case">
                        <button type="button" @click="show = !show"
                            :aria-label="show ? 'Hide password' : 'Show password'"
                            class="absolute inset-y-0 right-0 px-4 text-white/60 transition hover:text-gold-light">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="{{ $err }}">{{ $message }}</span>
                    @enderror
                </label>

                <label class="{{ $label }}">Confirm password <span class="text-[#ff4d4f]"
                        style="color:#ff4d4f">*</span>
                    <div class="relative mt-2" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation"
                            placeholder="Re-enter password" required minlength="6" autocomplete="new-password"
                            class="{{ $field }} pr-12 normal-case">
                        <button type="button" @click="show = !show"
                            :aria-label="show ? 'Hide password' : 'Show password'"
                            class="absolute inset-y-0 right-0 px-4 text-white/60 transition hover:text-gold-light">
                            <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </label>

                <button type="submit" class="btn-fill w-full">
                    Reset password <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
    </section>

</x-layouts.app>
