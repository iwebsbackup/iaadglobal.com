{{-- resources/views/registration.blade.php --}}
<x-layouts.app title="Registration | DiCD 2026">

    {{-- hero --}}
    <section
        class="relative isolate overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] pt-36 pb-20 text-white">
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
            <span
                class="inline-flex items-center gap-2 rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase motion-safe:animate-fade-up">
                <i class="fa-solid fa-ticket"></i> 19–21 December 2026
            </span>
            <h1
                class="mt-5 font-display text-5xl leading-[1] font-bold tracking-tight sm:text-6xl lg:text-7xl motion-safe:animate-fade-up [animation-delay:80ms]">
                Registration <em
                    class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">Fees</em>
            </h1>
        </div>
    </section>

    {{-- fees --}}
    <section
        class="relative isolate overflow-hidden bg-gradient-to-b from-[#041c38] via-navy-deep to-navy pb-24 text-white">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.07)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]">
            </div>
            <div
                class="absolute -top-72 -left-40 size-[480px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.30),transparent)]">
            </div>
            <div
                class="absolute -right-32 -bottom-40 size-[420px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.14),transparent)]">
            </div>
        </div>

        <div class="mx-auto max-w-5xl space-y-8 px-6">

            @foreach (['non_residential', 'residential'] as $key)
                <x-fee-table :package="$key" />
            @endforeach

            {{-- inclusions --}}
            <div class="grid gap-5 md:grid-cols-2">
                @foreach (['residential' => 'Residential', 'non_residential' => 'Non-Residential'] as $key => $label)
                    <div class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur">
                        <h3 class="mb-4 text-xs font-bold tracking-widest text-gold-light uppercase">{{ $label }}
                            package includes</h3>
                        <ul class="space-y-2.5 text-sm text-white/80">
                            @foreach (config("registration.packages.$key.includes") as $item)
                                <li class="flex gap-2.5"><i
                                        class="fa-solid fa-circle-check mt-1 text-xs text-gold-light"></i>{{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            {{-- register CTA --}}
            <div
                class="flex flex-wrap items-center justify-between gap-6 rounded-3xl border border-gold-light/30 bg-white/5 px-7 py-6 backdrop-blur">
                <div>
                    <strong class="block font-display text-xl sm:text-2xl">Ready to join DiCD 2026?</strong>
                    <span class="text-sm text-white/65">Secure your seat at the current rate.</span>
                </div>
                <a href="/register" class="btn-fill">Register Now <i class="fa-solid fa-arrow-right text-xs"></i></a>
            </div>

            {{-- cancellation --}}
            <div id="terms">
                <h2 class="mb-5 text-center font-display text-2xl font-bold">Cancellation Policy</h2>
                <div class="grid gap-4 sm:grid-cols-3">
                    @foreach (config('registration.cancellation') as $c)
                        <div class="rounded-2xl border border-white/15 bg-white/10 p-5 text-center backdrop-blur">
                            <span
                                class="block text-xs font-bold tracking-wider text-white/60 uppercase">{{ $c['when'] }}</span>
                            <strong
                                class="mt-2 block font-display text-3xl text-gold-light">{{ $c['refund'] }}</strong>
                            @if ($c['note'])
                                <span class="text-xs text-white/55">{{ $c['note'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <ul class="mt-4 space-y-1.5 text-sm text-white/65">
                    @foreach (config('registration.cancellation_notes') as $n)
                        <li class="flex gap-2.5"><i
                                class="fa-solid fa-angles-right mt-1 text-xs text-gold-light"></i>{{ $n }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- terms --}}
            <div class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8">
                <h2 class="mb-5 font-display text-2xl font-bold">Terms &amp; Conditions</h2>
                <ul class="space-y-3 text-sm leading-relaxed text-white/75">
                    @foreach (config('registration.terms') as $t)
                        <li class="flex gap-2.5"><i
                                class="fa-solid fa-angles-right mt-1 text-xs text-gold-light"></i>{{ $t }}
                        </li>
                    @endforeach
                </ul>
                <p class="mt-6 rounded-2xl border border-gold-light/30 bg-gold-light/10 p-4 text-sm text-white/80">
                    <strong class="text-gold-light">Please note:</strong> {{ config('registration.payment_note') }}
                </p>
                <a href="/contact" class="btn-fill mt-6">Contact the helpdesk <i
                        class="fa-solid fa-arrow-right text-xs"></i></a>
            </div>
        </div>
    </section>

</x-layouts.app>
