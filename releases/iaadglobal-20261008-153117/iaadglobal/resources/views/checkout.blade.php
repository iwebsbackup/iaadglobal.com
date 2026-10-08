<x-layouts.app title="Checkout | DiCD 2026">

    @php
        // Line items rebuilt from the saved registration (same tier, checked in the controller)
        $tier = $registration->fee_tier;
        $nonRes = collect(config('registration.packages.non_residential.rows'))->keyBy('category');
        $res = collect(config('registration.packages.residential.rows'))->keyBy('category');

        $lines = [];
        if ($registration->accommodation === 'double') {
            $lines[] = [
                'Residential · Double occupancy (you + 1 sharing)',
                $res['Double Occupancy With Accompanying Person']['prices'][$tier],
            ];
        } elseif ($registration->accommodation === 'single') {
            $lines[] = ['Residential · Single occupancy', $res['Single Occupancy']['prices'][$tier]];
        } else {
            $lines[] = [$user->category, $nonRes[$user->category]['prices'][$tier]];
        }

        $accCount = count($registration->accompanying ?? []);
        if ($accCount) {
            $lines[] = [
                'Accompanying person × ' . $accCount,
                $accCount * $nonRes['Accompanying Person']['prices'][$tier],
            ];
        }

        $wsCount = count($registration->workshops ?? []);
        if ($wsCount) {
            $lines[] = ['Workshops × ' . $wsCount, $wsCount * $nonRes['Any Workshop']['flat']];
        }

        $card = 'rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8';
    @endphp

    {{-- hero --}}
    <section
        class="relative isolate overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] pt-36 pb-16 text-white">
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
        <div class="mx-auto max-w-7xl px-6 text-center">
            <h1
                class="font-display text-5xl leading-[1] font-bold tracking-tight sm:text-6xl motion-safe:animate-fade-up">
                <em
                    class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">Checkout</em>
            </h1>
            <div class="mt-6 flex justify-center">
                <a href="/registration-payment" class="btn-line !px-5 !py-2.5 !text-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Edit registration details
                </a>
            </div>
        </div>
    </section>

    <section
        class="relative isolate overflow-x-clip bg-gradient-to-b from-[#041c38] via-navy-deep to-navy pb-24 text-white">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.07)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]">
            </div>
            <div
                class="absolute -top-72 -left-40 size-[480px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.30),transparent)]">
            </div>
        </div>

        <div class="mx-auto max-w-2xl space-y-6 px-6">

            {{-- delegate --}}
            <div class="{{ $card }}">
                <h2 class="mb-4 font-display text-xl font-bold">Delegate</h2>
                <p class="font-display text-lg font-bold">{{ $user->title }} {{ $user->name }}</p>
                <p class="mt-1 text-sm text-white/70">{{ $user->email }} · {{ $user->phone }}</p>
                <p class="mt-1 text-sm text-white/70">{{ $user->institution }}</p>
            </div>

            {{-- order summary --}}
            <div class="{{ $card }}">
                <h2 class="mb-1 font-display text-xl font-bold">Order summary</h2>
                <p class="mb-5 text-xs text-white/55">{{ config('registration.tiers.' . $tier . '.label') }} rates ·
                    {{ config('registration.tiers.' . $tier . '.note') }}</p>

                <ul class="space-y-3 text-sm">
                    @foreach ($lines as [$name, $price])
                        <li class="flex justify-between gap-4">
                            <span class="text-white/80">{{ $name }}</span>
                            <strong class="shrink-0">₹{{ number_format($price) }}</strong>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-5 space-y-2 border-t border-white/15 pt-4 text-sm">
                    <div class="flex justify-between text-white/70">
                        <span>Subtotal</span><span>₹{{ number_format($registration->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-white/70">
                        <span>GST ({{ config('registration.gst') }}%)</span>
                        <span>₹{{ number_format($registration->gst_amount) }}</span>
                    </div>
                    <div class="flex justify-between pt-2 font-display text-xl text-gold-light">
                        <strong>Total</strong><strong>₹{{ number_format($registration->total) }}</strong>
                    </div>
                </div>
            </div>

            {{-- pay --}}
            {{-- No @csrf here: this form posts to an external site, so a CSRF token must not be sent. --}}
            <form method="POST" action="{{ $gatewayUrl }}" x-data="{ submitting: false }" @submit="submitting = true"
                @pageshow.window="submitting = false">

                <input type="hidden" name="amount" value="{{ $amount }}">
                <input type="hidden" name="currency" value="{{ $currency }}">
                <input type="hidden" name="description" value="DiCD 2026 Registration">
                <input type="hidden" name="theme_color" value="#083b78">
                <input type="hidden" name="prefill_name" value="{{ $user->title }} {{ $user->name }}">
                <input type="hidden" name="prefill_email" value="{{ $user->email }}">
                <input type="hidden" name="prefill_contact" value="{{ $user->phone }}">
                <input type="hidden" name="response_url" value="{{ $responseUrl }}">
                <input type="hidden" name="hash" value="{{ $hash }}">

                <button type="submit" :disabled="submitting"
                    class="btn-fill w-full disabled:cursor-not-allowed disabled:opacity-60">
                    <span x-show="!submitting">Pay ₹{{ number_format($registration->total) }} now <i
                            class="fa-solid fa-lock text-xs"></i></span>
                    <span x-show="submitting" x-cloak>Redirecting to payment…</span>
                </button>

                <p class="mt-3 text-center text-xs text-white/55">You will be taken to our secure payment page.</p>
            </form>
        </div>
    </section>

</x-layouts.app>
