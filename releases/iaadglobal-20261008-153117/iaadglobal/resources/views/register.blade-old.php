{{-- resources/views/register.blade.php --}}

<x-layouts.app title="Register | DiCD 2026">

    @php
        // ---- pricing, read from config/registration.php ----
        $tiers = config('registration.tiers');
        $now = now('Asia/Kolkata');
        $tier = collect($tiers)
            ->keys()
            ->first(
                fn($k) => !$tiers[$k]['ends'] ||
                    $now->lte(\Illuminate\Support\Carbon::parse($tiers[$k]['ends'], 'Asia/Kolkata')->endOfDay()),
            );

        $nonRes = collect(config('registration.packages.non_residential.rows'))->keyBy('category');
        $res = collect(config('registration.packages.residential.rows'))->keyBy('category');

        $categories = ['Participants', 'SAARC AAD Member', 'Post Graduate Student'];

        $fees = [
            'accompanying' => $nonRes['Accompanying Person']['prices'][$tier],
            'workshop' => $nonRes['Any Workshop']['flat'],
            'single' => $res['Single Occupancy']['prices'][$tier],
            'double' => $res['Double Occupancy With Accompanying Person']['prices'][$tier],
        ];
        foreach ($categories as $c) {
            $fees[$c] = $nonRes[$c]['prices'][$tier];
        }

        $workshops = config('registration.workshops');
        $titles = ['Dr.', 'Prof.', 'Mr.', 'Miss', 'Ms.'];
        $genders = ['Male', 'Female', 'Other'];

        $field =
            'w-full rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/40 outline-none transition focus:border-gold-light focus:bg-white/15';
        $label = 'block text-xs font-bold tracking-wider text-white/70 uppercase';
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
            <span
                class="inline-flex items-center gap-2 rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase motion-safe:animate-fade-up">
                <i class="fa-solid fa-ticket"></i> {{ $tiers[$tier]['label'] }} rates · {{ $tiers[$tier]['note'] }}
            </span>
            <h1
                class="mt-5 font-display text-5xl leading-[1] font-bold tracking-tight sm:text-6xl lg:text-7xl motion-safe:animate-fade-up [animation-delay:80ms]">
                Register for <em
                    class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">DiCD
                    2026</em>
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

        <form method="POST" action="/register" enctype="multipart/form-data" x-data="{
            fees: @js($fees),
            gst: {{ (int) config('registration.gst') }},
            category: '',
            accommodation: 'none', // none | single | double
            sharing: { title: 'Mr.', name: '', gender: '' },
            hasAcc: false,
            persons: [],
            workshops: [],
        
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
                } else if (this.category) {
                    out.push([this.category, this.fees[this.category]]);
                }
                if (this.category && acc) out.push([`Accompanying person × ${acc}`, acc * this.fees.accompanying]);
                if (this.workshops.length) out.push([`Workshops × ${this.workshops.length}`, this.workshops.length * this.fees.workshop]);
                return out;
            },
            get subtotal() { return this.lines.reduce((s, l) => s + l[1], 0); },
            get gstAmount() { return Math.round(this.subtotal * this.gst / 100); },
            get total() { return this.subtotal + this.gstAmount; },
        }"
            class="mx-auto grid max-w-7xl items-start gap-8 px-6 lg:grid-cols-[1.4fr_.8fr]">
            @csrf

            <div class="space-y-6">

                {{-- 1 · delegate category --}}
                <div class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8">
                    <h2 class="mb-5 flex items-center gap-3 font-display text-xl font-bold"><span
                            class="grid size-8 place-items-center rounded-full bg-gold-light text-sm text-navy-deep">1</span>
                        Delegate category</h2>
                    <div class="grid gap-3 sm:grid-cols-3">
                        @foreach ($categories as $c)
                            <label class="cursor-pointer rounded-2xl border-[1.5px] p-4 transition"
                                :class="category === '{{ $c }}' ? 'border-gold-light bg-gold-light/15' :
                                    'border-white/15 bg-white/5 hover:border-gold-light/50'">
                                <input type="radio" name="category" value="{{ $c }}" x-model="category"
                                    required class="sr-only">
                                <strong class="block font-display text-sm">{{ $c }}</strong>
                                <span
                                    class="mt-1 block font-display text-lg text-gold-light">₹{{ number_format($fees[$c]) }}</span>
                            </label>
                        @endforeach
                    </div>

                    <label x-show="category === 'Post Graduate Student'" x-cloak x-transition
                        class="{{ $label }} mt-5">
                        Letter of HOD (required for PG students)
                        <input type="file" name="hod_letter" accept=".pdf,.jpg,.jpeg,.png"
                            :required="category === 'Post Graduate Student'"
                            class="{{ $field }} mt-2 normal-case file:mr-3 file:rounded-lg file:border-0 file:bg-gold-light file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-navy-deep">
                    </label>
                </div>

                {{-- 2 · accommodation --}}
                <div class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8">
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
                            <label class="{{ $label }}">Title
                                <select x-model="sharing.title" name="sharing[title]"
                                    :required="accommodation === 'double'"
                                    class="{{ $field }} mt-2 normal-case">
                                    @foreach ($titles as $t)
                                        <option class="text-dark-navy">{{ $t }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="{{ $label }}">Full name
                                <input type="text" x-model="sharing.name" name="sharing[name]"
                                    :required="accommodation === 'double'"
                                    class="{{ $field }} mt-2 normal-case">
                            </label>
                            <label class="{{ $label }}">Gender
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
                <div class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8">
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
                                    <label class="{{ $label }}">Title
                                        <select x-model="p.title" :name="`accompanying[${i}][title]`"
                                            class="{{ $field }} mt-2 normal-case">
                                            @foreach ($titles as $t)
                                                <option class="text-dark-navy">{{ $t }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="{{ $label }}">Full name
                                        <input type="text" x-model="p.name" :name="`accompanying[${i}][name]`"
                                            :required="hasAcc" class="{{ $field }} mt-2 normal-case">
                                    </label>
                                    <label class="{{ $label }}">Gender
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
                <div class="rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8">
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
            </div>

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
                <p x-show="!lines.length" class="mt-5 text-sm text-white/55">Choose a delegate category to see your
                    total.</p>

                <div class="mt-5 space-y-2 border-t border-white/15 pt-4 text-sm" x-show="lines.length" x-cloak>
                    <div class="flex justify-between text-white/70"><span>Subtotal</span><span
                            x-text="money(subtotal)"></span></div>
                    <div class="flex justify-between text-white/70"><span>GST
                            ({{ config('registration.gst') }}%)</span><span x-text="money(gstAmount)"></span></div>
                    <div class="flex justify-between pt-2 font-display text-xl text-gold-light">
                        <strong>Total</strong><strong x-text="money(total)"></strong>
                    </div>
                </div>

                <label class="mt-6 flex cursor-pointer items-start gap-3 text-xs text-white/70">
                    <input type="checkbox" name="agree" required class="mt-0.5 size-4 shrink-0 accent-[#f2c65a]">
                    <span>I agree to the <a href="/registration#terms" target="_blank"
                            class="font-bold text-gold-light underline">terms, conditions and cancellation
                            policy</a>.</span>
                </label>

                <button type="submit" :disabled="!category"
                    class="btn-fill mt-5 w-full disabled:cursor-not-allowed disabled:opacity-50">
                    Proceed to payment <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </aside>
        </form>
    </section>

</x-layouts.app>
