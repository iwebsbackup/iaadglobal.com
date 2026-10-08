<x-layouts.app title="Registration Payment | DiCD 2026">

    @php
        $paid = $registration?->isPaid() ?? false;

        // Unpaid: always the CURRENT tier (fees change with time).
        // Paid: locked to the tier that was paid.
        $tiers = config('registration.tiers');
        $now = now('Asia/Kolkata');
        $tier = $paid
            ? $registration->fee_tier
            : collect($tiers)
                ->keys()
                ->first(
                    fn($k) => !$tiers[$k]['ends'] ||
                        $now->lte(\Illuminate\Support\Carbon::parse($tiers[$k]['ends'], 'Asia/Kolkata')->endOfDay()),
                );

        $nonRes = collect(config('registration.packages.non_residential.rows'))->keyBy('category');
        $res = collect(config('registration.packages.residential.rows'))->keyBy('category');

        $fees = [
            'accompanying' => $nonRes['Accompanying Person']['prices'][$tier],
            'workshop' => $nonRes['Any Workshop']['flat'],
            'single' => $res['Single Occupancy']['prices'][$tier],
            'double' => $res['Double Occupancy With Accompanying Person']['prices'][$tier],
            'category' => $nonRes[$user->category]['prices'][$tier],
        ];

        $workshops = config('registration.workshops');
        $titles = ['Dr.', 'Prof.', 'Mr.', 'Miss', 'Ms.'];
        $genders = ['Male', 'Female', 'Other'];

        $field =
            'w-full rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/40 outline-none transition focus:border-gold-light focus:bg-white/15 disabled:opacity-60';
        $label = 'block text-xs font-bold tracking-wider text-white/70 uppercase';
        $req = '<span class="text-[#ff4d4f]" style="color:#ff4d4f">*</span>';
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
            <div class="mb-6 flex justify-end">
                <a href="/dashboard" class="btn-line !px-5 !py-2.5 !text-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Back to dashboard
                </a>
            </div>
            <span
                class="inline-flex items-center gap-2 rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase motion-safe:animate-fade-up">
                <i class="fa-solid fa-ticket"></i> {{ $tiers[$tier]['label'] }} rates · {{ $tiers[$tier]['note'] }}
            </span>
            <h1
                class="mt-5 font-display text-5xl leading-[1] font-bold tracking-tight sm:text-6xl motion-safe:animate-fade-up [animation-delay:80ms]">
                Registration <em
                    class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">Payment</em>
            </h1>
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

        <div class="mx-auto max-w-7xl px-6">
            @if (session('status'))
                <p class="mb-6 rounded-xl bg-gold-light/15 px-4 py-3 text-sm font-semibold text-gold-light">
                    {{ session('status') }}</p>
            @endif
            @if (!$paid)
                @switch(request('payment'))
                    @case('failed')
                        <p class="mb-6 rounded-xl bg-red-400/15 px-4 py-3 text-sm font-semibold text-red-300">
                            <i class="fa-solid fa-circle-xmark mr-1"></i> Your payment failed and no registration was
                            confirmed.
                            @if ($registration?->payment_error)
                                Reason: {{ $registration->payment_error }}.
                            @endif
                            You can try again below.
                        </p>
                    @break

                    @case('cancelled')
                        <p class="mb-6 rounded-xl bg-gold-light/15 px-4 py-3 text-sm font-semibold text-gold-light">
                            Payment was cancelled. Your details are still saved, so you can go to checkout again.
                        </p>
                    @break

                    @case('unmatched')
                        <p class="mb-6 rounded-xl bg-red-400/15 px-4 py-3 text-sm font-semibold text-red-300">
                            We could not match your payment to your registration. If money was deducted from your account,
                            please contact the DiCD helpdesk and we will confirm it for you.
                        </p>
                    @break
                @endswitch
            @endif
            @if ($registration && !$paid)
                @if ($registration->fee_tier === $tier)
                    <div
                        class="mb-6 flex flex-col gap-4 rounded-xl border border-gold-light/40 bg-gold-light/10 p-5 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-white/80">
                            <strong class="block font-display text-base text-gold-light">Your registration details are
                                saved</strong>
                            Total ₹{{ number_format($registration->total) }} (incl. GST). Go to checkout, or change
                            anything
                            below and save again.
                        </p>
                        <a href="/checkout" class="btn-fill shrink-0 !px-5 !py-2.5 !text-sm">
                            Go to checkout <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                @else
                    <p class="mb-6 rounded-xl bg-gold-light/15 px-4 py-3 text-sm font-semibold text-gold-light">
                        Registration rates have changed since you saved your details. Review the options below and save
                        again
                        to continue at the new price.
                    </p>
                @endif
            @endif
            @if ($paid)
                <p class="mb-6 rounded-xl bg-green-400/15 px-4 py-3 text-sm font-semibold text-green-300">
                    <i class="fa-solid fa-circle-check mr-1"></i> Payment received on
                    {{ $registration->paid_at?->timezone('Asia/Kolkata')->format('d M Y') }}.
                    @if ($registration->payment_reference)
                        Reference: {{ $registration->payment_reference }}
                    @endif
                </p>
            @else
                <p class="mb-6 rounded-xl bg-gold-light/15 px-4 py-3 text-sm font-semibold text-gold-light">
                    Your fee is not locked until you pay. {{ $tiers[$tier]['label'] }} rates apply today
                    ({{ $tiers[$tier]['note'] }}) and will increase after that.
                </p>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-400/15 px-4 py-3 text-sm font-semibold text-red-300">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form method="POST" action="/registration-payment" x-data="{
            fees: @js($fees),
            gst: {{ (int) config('registration.gst') }},
            category: @js($user->category),
            accommodation: @js($registration->accommodation ?? 'none'),
            sharing: @js($registration->sharing ?? ['title' => 'Mr.', 'name' => '', 'gender' => '']),
            persons: @js($registration->accompanying ?? []),
            hasAcc: {{ !empty($registration?->accompanying) ? 'true' : 'false' }},
            workshops: @js($registration->workshops ?? []),
        
            toggleAcc() {
                if (this.hasAcc && !this.persons.length) this.addPerson();
                if (!this.hasAcc) this.persons = [];
            },
            addPerson() { this.persons.push({ title: 'Mr.', name: '', gender: '' }); },
            removePerson(i) {
                this.persons.splice(i, 1);
                if (!this.persons.length) this.hasAcc = false;
            },
            money(n) { return '₹' + Number(n).toLocaleString('en-IN'); },
        
            get lines() {
                const out = [];
                const acc = this.persons.length;
                if (this.accommodation === 'double') {
                    out.push(['Residential · Double occupancy (you + 1 sharing)', this.fees.double]);
                } else if (this.accommodation === 'single') {
                    out.push(['Residential · Single occupancy', this.fees.single]);
                } else {
                    out.push([this.category, this.fees.category]);
                }
                if (acc) out.push([`Accompanying person × ${acc}`, acc * this.fees.accompanying]);
                if (this.workshops.length) out.push([`Workshops × ${this.workshops.length}`, this.workshops.length * this.fees.workshop]);
                return out;
            },
            get subtotal() { return this.lines.reduce((s, l) => s + l[1], 0); },
            get gstAmount() { return Math.round(this.subtotal * this.gst / 100); },
            get total() { return this.subtotal + this.gstAmount; },
        }"
            class="mx-auto grid max-w-7xl items-start gap-8 px-6 lg:grid-cols-[1.4fr_.8fr]">
            @csrf

            <fieldset @disabled($paid) class="min-w-0 space-y-6">

                {{-- 1 · delegate category (read only) --}}
                <div class="{{ $card }}">
                    <h2 class="mb-5 flex items-center gap-3 font-display text-xl font-bold"><span
                            class="grid size-8 place-items-center rounded-full bg-gold-light text-sm text-navy-deep">1</span>
                        Delegate category</h2>
                    <div class="rounded-2xl border-[1.5px] border-gold-light bg-gold-light/15 p-4">
                        <strong class="block font-display text-sm">{{ $user->category }}</strong>
                        <span
                            class="mt-1 block font-display text-lg text-gold-light">₹{{ number_format($fees['category']) }}</span>
                    </div>
                    <p class="mt-3 text-xs text-white/55">Your category was chosen at registration and cannot be
                        changed here.</p>
                </div>

                {{-- 2 · accommodation --}}
                <div class="{{ $card }}">
                    <h2 class="mb-1 flex items-center gap-3 font-display text-xl font-bold"><span
                            class="grid size-8 place-items-center rounded-full bg-gold-light text-sm text-navy-deep">2</span>
                        Accommodation</h2>
                    <p class="mb-5 text-sm text-white/60">Residential Package (3 Nights &amp; 4 Days) ·
                        {{ config('registration.packages.residential.subtitle') }}. Replaces the registration fee.</p>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <label class="cursor-pointer rounded-2xl border-[1.5px] p-4 transition"
                            :class="accommodation === 'none' ? 'border-gold-light bg-gold-light/15' :
                                'border-white/15 bg-white/5 hover:border-gold-light/50'">
                            <input type="radio" name="accommodation" value="none" x-model="accommodation"
                                class="sr-only">
                            <strong class="block font-display text-sm">No accommodation</strong>
                            <span class="mt-1 block text-xs text-white/60">Non-residential</span>
                        </label>
                        <label class="cursor-pointer rounded-2xl border-[1.5px] p-4 transition"
                            :class="accommodation === 'single' ? 'border-gold-light bg-gold-light/15' :
                                'border-white/15 bg-white/5 hover:border-gold-light/50'">
                            <input type="radio" name="accommodation" value="single" x-model="accommodation"
                                class="sr-only">
                            <strong class="block font-display text-sm">Single occupancy</strong>
                            <span
                                class="mt-1 block font-display text-lg text-gold-light">₹{{ number_format($fees['single']) }}</span>
                        </label>
                        <label class="cursor-pointer rounded-2xl border-[1.5px] p-4 transition"
                            :class="accommodation === 'double' ? 'border-gold-light bg-gold-light/15' :
                                'border-white/15 bg-white/5 hover:border-gold-light/50'">
                            <input type="radio" name="accommodation" value="double" x-model="accommodation"
                                class="sr-only">
                            <strong class="block font-display text-sm">Double occupancy</strong>
                            <span
                                class="mt-1 block font-display text-lg text-gold-light">₹{{ number_format($fees['double']) }}</span>
                        </label>
                    </div>

                    {{-- sharing person (double only) --}}
                    <div x-show="accommodation === 'double'" x-cloak x-transition
                        class="mt-6 rounded-2xl border border-white/15 bg-white/5 p-5">
                        <strong class="mb-4 block font-display text-sm tracking-wide text-gold-light uppercase">Person
                            sharing your room</strong>
                        <div class="grid gap-4 sm:grid-cols-3">
                            <label class="{{ $label }}">Title {!! $req !!}
                                <select x-model="sharing.title" name="sharing[title]"
                                    :required="accommodation === 'double'"
                                    class="{{ $field }} mt-2 normal-case">
                                    @foreach ($titles as $t)
                                        <option class="text-dark-navy">{{ $t }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="{{ $label }}">Full name {!! $req !!}
                                <input type="text" x-model="sharing.name" name="sharing[name]"
                                    placeholder="Enter full name" :required="accommodation === 'double'"
                                    class="{{ $field }} mt-2 normal-case">
                            </label>
                            <label class="{{ $label }}">Gender {!! $req !!}
                                <select x-model="sharing.gender" name="sharing[gender]"
                                    :required="accommodation === 'double'"
                                    class="{{ $field }} mt-2 normal-case">
                                    <option value="" class="text-dark-navy">Select</option>
                                    @foreach ($genders as $g)
                                        <option class="text-dark-navy">{{ $g }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- 3 · additional accompanying persons --}}
                <div class="{{ $card }}">
                    <h2 class="mb-1 flex items-center gap-3 font-display text-xl font-bold"><span
                            class="grid size-8 place-items-center rounded-full bg-gold-light text-sm text-navy-deep">3</span>
                        Accompanying persons</h2>
                    <p class="mb-5 text-sm text-white/60">Anyone else coming with you, apart from yourself and your
                        room-sharer.</p>

                    <label class="flex cursor-pointer items-center gap-3 font-semibold">
                        <input type="checkbox" x-model="hasAcc" @change="toggleAcc()"
                            class="size-5 accent-[#f2c65a]">
                        I am bringing accompanying person(s) <span
                            class="text-sm font-normal text-white/60">(₹{{ number_format($fees['accompanying']) }}
                            each)</span>
                    </label>

                    <div x-show="hasAcc" x-cloak x-transition class="mt-6 space-y-4">
                        <template x-for="(p, i) in persons" :key="i">
                            <div class="rounded-2xl border border-white/15 bg-white/5 p-5">
                                <div class="mb-4 flex items-center justify-between">
                                    <strong class="font-display text-sm tracking-wide text-gold-light uppercase"
                                        x-text="`Accompanying person ${i + 1}`"></strong>
                                    <button type="button" @click="removePerson(i)"
                                        class="text-xs font-bold text-white/60 transition hover:text-red-300"><i
                                            class="fa-solid fa-trash-can mr-1"></i> Remove</button>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-3">
                                    <label class="{{ $label }}">Title {!! $req !!}
                                        <select x-model="p.title" :name="`accompanying[${i}][title]`"
                                            class="{{ $field }} mt-2 normal-case">
                                            @foreach ($titles as $t)
                                                <option class="text-dark-navy">{{ $t }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="{{ $label }}">Full name {!! $req !!}
                                        <input type="text" x-model="p.name" :name="`accompanying[${i}][name]`"
                                            placeholder="Enter full name" :required="hasAcc"
                                            class="{{ $field }} mt-2 normal-case">
                                    </label>
                                    <label class="{{ $label }}">Gender {!! $req !!}
                                        <select x-model="p.gender" :name="`accompanying[${i}][gender]`"
                                            :required="hasAcc" class="{{ $field }} mt-2 normal-case">
                                            <option value="" class="text-dark-navy">Select</option>
                                            @foreach ($genders as $g)
                                                <option class="text-dark-navy">{{ $g }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </template>
                        <button type="button" @click="addPerson()" class="btn-line !px-5 !py-2.5 !text-sm"><i
                                class="fa-solid fa-plus text-xs"></i> Add another person</button>
                    </div>
                </div>

                {{-- 4 · workshops --}}
                <div class="{{ $card }}">
                    <h2 class="mb-1 flex items-center gap-3 font-display text-xl font-bold"><span
                            class="grid size-8 place-items-center rounded-full bg-gold-light text-sm text-navy-deep">4</span>
                        Workshops <span class="text-sm font-normal text-white/60">(optional ·
                            ₹{{ number_format($fees['workshop']) }} each)</span></h2>
                    <div class="mt-5 grid gap-3 md:grid-cols-2">
                        @foreach ($workshops as $w)
                            <label
                                class="flex cursor-pointer items-start gap-3 rounded-2xl border-[1.5px] p-4 text-sm font-semibold transition"
                                :class="workshops.includes(@js($w)) ?
                                    'border-gold-light bg-gold-light/15' :
                                    'border-white/15 bg-white/5 hover:border-gold-light/50'">
                                <input type="checkbox" name="workshops[]" value="{{ $w }}"
                                    x-model="workshops" class="mt-0.5 size-4 shrink-0 accent-[#f2c65a]">
                                {{ $w }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </fieldset>

            {{-- summary --}}
            <aside class="rounded-3xl border border-gold-light/30 bg-white/10 p-6 backdrop-blur lg:sticky lg:top-28">
                <h2 class="font-display text-xl font-bold">Summary</h2>
                <p class="mt-1 text-xs text-white/55">{{ $tiers[$tier]['label'] }} rates apply ·
                    {{ $tiers[$tier]['note'] }}</p>

                <ul class="mt-5 space-y-3 text-sm">
                    <template x-for="l in lines" :key="l[0]">
                        <li class="flex justify-between gap-4"><span class="text-white/80"
                                x-text="l[0]"></span><strong class="shrink-0" x-text="money(l[1])"></strong></li>
                    </template>
                </ul>

                <div class="mt-5 space-y-2 border-t border-white/15 pt-4 text-sm">
                    <div class="flex justify-between text-white/70"><span>Subtotal</span><span
                            x-text="money(subtotal)"></span></div>
                    <div class="flex justify-between text-white/70"><span>GST
                            ({{ config('registration.gst') }}%)</span><span x-text="money(gstAmount)"></span></div>
                    <div class="flex justify-between pt-2 font-display text-xl text-gold-light">
                        <strong>Total</strong><strong x-text="money(total)"></strong>
                    </div>
                </div>

                @unless ($paid)
                    <label class="mt-6 flex cursor-pointer items-start gap-3 text-xs text-white/70">
                        <input type="checkbox" name="agree" required class="mt-0.5 size-4 shrink-0 accent-[#f2c65a]">
                        <span>I agree to the <a href="/registration#terms" target="_blank"
                                class="font-bold text-gold-light underline">terms, conditions and cancellation
                                policy</a>.</span>
                    </label>

                    <button type="submit" class="btn-fill mt-5 w-full">
                        {{ $registration ? 'Save changes & go to checkout' : 'Proceed to payment' }} <i
                            class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                @endunless
            </aside>
        </form>
    </section>

</x-layouts.app>
